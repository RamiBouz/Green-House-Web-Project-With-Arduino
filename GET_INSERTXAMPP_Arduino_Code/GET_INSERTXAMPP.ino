#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266HTTPClient.h>
#include <LM75A.h>

//Temp Sensor
LM75A lm75a_sensor/*(false, //A0 LM75A pin state
                   false, //A1 LM75A pin state
                   false, //A2 LM75A pin state)*/; // Create I2C LM75A instance 

//LED 
#define ON_Board_LED 2  //--> Defining an On Board LED (GPIO2 = D4), used for indicators when the process of connecting to a wifi router
#define LED_D8 15 //--> Defines an LED Pin. D8 = GPIO15
#define LED_D7 13 //--> Defines an LED Pin. D7 = GPIO13

String tempDB, humidityDB, postData ,amountDB ,sumDB, postData1;


//SSID and Password of your WiFi router.
const char* ssid = ""; //--> Your wifi name or SSID.
const char* password = ""; //--> Your wifi password.



//Web Server address / IPv4
const char *host = "IPv4 Address";
//----------------------------------------
  float previous_time=0;
  float current_time=0;
  int seconds=0;
  float sum=0;
  int flag=1;
  
void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);
  pinMode(A0, INPUT);
  delay(1000);

  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password); //--> Connect to your WiFi router
  Serial.println("");

  pinMode(ON_Board_LED, OUTPUT); //--> On Board LED port Direction output
  digitalWrite(ON_Board_LED, HIGH); //--> Turn off Led On Board

  pinMode(LED_D8, OUTPUT); //--> LED port Direction output
  digitalWrite(LED_D8, LOW); //--> Turn off Led

  pinMode(LED_D7, OUTPUT); //--> LED port Direction output
  digitalWrite(LED_D7, LOW); //--> Turn off Led

  //----------------------------------------Wait for connection
  Serial.print("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    //----------------------------------------Make the On Board Flashing LED on the process of connecting to the wifi router.
    digitalWrite(ON_Board_LED, LOW);
    delay(250);
    digitalWrite(ON_Board_LED, HIGH);
    delay(250);
    //----------------------------------------
  }
  //----------------------------------------
  digitalWrite(ON_Board_LED, HIGH); //--> Turn off the On Board LED when it is connected to the wifi router.
  //----------------------------------------If successfully connected to the wifi router, the IP Address that will be visited is displayed in the serial monitor
  Serial.println("");
  Serial.print("Successfully connected to : ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
  Serial.println();
  //----------------------------------------
}

void loop() {
  // INSERT DATA TO SQL
  int humidity = analogRead(A0); //take a sample
  int humidityP = 0;
  humidityP = map(humidity, 1024, 0, 0, 100);
  float temperature = lm75a_sensor.getTemperatureInDegrees();
  Serial.print(temperature);
  delay(2000);



  HTTPClient http;    // http object of clas HTTPClient

  // Convert integer variables to string
  tempDB     = String(temperature);
  humidityDB = String(humidityP);
  
  postData = "tempDB=" + tempDB + "&humidityDB=" + humidityDB;

  http.begin("http://IPv4 Address/greenhouseproject/dbwrite.php");              // Connect to host where MySQL databse is hosted
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.POST(postData);   // Send POST request to php file and store server response code in variable named httpCode
  Serial.println("Values are, tempDB = " + tempDB + " and humidityDB = " + humidityDB );

  // if connection eatablished then do this
  if (httpCode == 200) {
    Serial.println("Values uploaded successfully."); Serial.println(httpCode);
    String webpage = http.getString();    // Get html webpage output and store it in a string
    Serial.println(webpage + "\n");
   
  }

  // if failed to connect then return and restart

  else {
    Serial.println(httpCode);
    Serial.println("Failed to upload values. \n");
    http.end();
    return;
  }
  delay(2000);
  digitalWrite(LED_BUILTIN, LOW);
  delay(2000);
  digitalWrite(LED_BUILTIN, HIGH);


  //GET DATA FROM SQL
  //WATER CONTROL
  // put your main code here, to run repeatedly:
  //----------------------------------------Getting Data from MySQL Database
  String GetAddresswater, LinkGetwater, getDatawater;
  int idwater = 0; //--> ID in Database
  GetAddresswater = "/greenhouseproject/getdatawc.php"; 
  LinkGetwater = host + GetAddresswater; //--> Make a Specify request destination
  getDatawater = "ID=" + String(idwater);
  Serial.println("----------------Connect to Server WATER CONTROL-----------------");
  Serial.println("Get LED Status from Server or Database");
  Serial.print("Request Link : ");
  Serial.println(LinkGetwater);
  http.begin(LinkGetwater); //--> Specify request destination
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");    //Specify content-type header
  int httpCodeGetwater = http.POST(getDatawater); //--> Send the request
  String payloadGetwater = http.getString(); //--> Get the response payload from server
  Serial.print("Response Code : "); //--> If Response Code = 200 means Successful connection, if -1 means connection failed. For more information see here : https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
  Serial.println(httpCodeGetwater); //--> Print HTTP return code
  Serial.print("Returned data from Server : ");
  Serial.println(payloadGetwater); //--> Print request response payload

  if (payloadGetwater == "1" ) {
   digitalWrite(LED_D8, HIGH); //--> Turn off Led
   current_time=millis();
   if((current_time-previous_time)>=1000)
   {seconds++;
   previous_time=current_time;
   Serial.println(seconds);
   flag=1;
    }
    
  }

  if (payloadGetwater == "0" && flag==1 ) {
   digitalWrite(LED_D8, LOW); //--> Turn off Led
   Serial.println(seconds);
   HTTPClient http;    // http object of clas HTTPClient
  // Convert integer variables to string
  sum = seconds * 0.5;
  amountDB  = String(seconds);
  sumDB  = String(sum);
  Serial.println(sum);
  flag=0;
  
  postData1 = "amountDB=" + amountDB + "&sumDB=" + sumDB;

  http.begin("http://IPv4 Address/greenhouseproject/dbwritetime.php");              // Connect to host where MySQL databse is hosted
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.POST(postData1);   // Send POST request to php file and store server response code in variable named httpCode

  // if connection eatablished then do this
  if (httpCode == 200) {
    Serial.println("Values uploaded successfully."); Serial.println(httpCode);
    String webpage = http.getString();    // Get html webpage output and store it in a string
    Serial.println(webpage + "\n");
  }

  // if failed to connect then return and restart

  else {
    Serial.println(httpCode);
    Serial.println("Failed to upload values. \n");
    http.end();
    return;
  }
  seconds=0;
  }

  //NET CONTROL

  String GetAddressnet, LinkGetnet, getDatanet;
  int idnet = 0; //--> ID in Database
  GetAddressnet = "/greenhouseproject/getdatanc.php";
  LinkGetnet = host + GetAddressnet; //--> Make a Specify request destination
  getDatanet = "ID=" + String(idnet);
  Serial.println("----------------Connect to Server NET CONTROL-----------------");
  Serial.println("Get LED Status from Server or Database");
  Serial.print("Request Link : ");
  Serial.println(LinkGetnet);
  http.begin(LinkGetnet); //--> Specify request destination
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");    //Specify content-type header
  int httpCodeGetnet = http.POST(getDatanet); //--> Send the request
  String payloadGetnet = http.getString(); //--> Get the response payload from server
  Serial.print("Response Code : "); //--> If Response Code = 200 means Successful connection, if -1 means connection failed. For more information see here : https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
  Serial.println(httpCodeGetnet); //--> Print HTTP return code
  Serial.print("Returned data from Server : ");
  Serial.println(payloadGetnet); //--> Print request response payload
 
  if (payloadGetnet == "1" )
  {
    digitalWrite(LED_D7, HIGH); //--> Turn off Led
    }
  if (payloadGetnet == "0" ) {
    digitalWrite(LED_D7, LOW); //--> Turn off Led
  }

    Serial.println("----------------Closing Connection----------------");
  http.end(); //--> Close connection
  Serial.println();
  Serial.println("Please wait 5 seconds for the next connection.");
  Serial.println();
  delay(5000); //--> GET Data at every 5 seconds
}
