/*************************************************************************************************
 
 ***********************************************************************************************/
 
#include <WiFi.h>
#include <HTTPClient.h>

#include <DHT.h> 
#define DHTPIN 4 
#define DHTTYPE DHT11 
DHT dht11(DHTPIN, DHTTYPE); 

String URL = "http://192.168.227.39/arete_project/data_test.php";

const char* ssid = "Kenny"; 
const char* password = "0719827762Raphael"; 


int temperature = 0;
int humidity = 0;
int soilmoisture = A0; // Analog pin for soil moisture sensor
String suggestion;
int moisturePercentage;



void setup() {
  Serial.begin(9600);

  dht11.begin(); 
  
  connectWiFi();
}

void loop() {
  if(WiFi.status() != WL_CONNECTED) {
    connectWiFi();
  }

  Load_DHT11_Data();
  String postData = "temperature=" + String(temperature) + "&humidity=" + String(humidity) + "&moisturePercentage=" + String(moisturePercentage) + "&suggestion=" + suggestion;
  

  HTTPClient http;
  http.begin(URL);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  
  int httpCode = http.POST(postData);
  String payload = "";

  if(httpCode > 0) {
    // file found at server
    if(httpCode == HTTP_CODE_OK) {
      String payload = http.getString();
      Serial.println(payload);
    } else {
      // HTTP header has been send and Server response header has been handled
      Serial.printf("[HTTP] GET... code: %d\n", httpCode);
    }
  } else {
    Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
  }
  
  http.end();  //Close connection

  Serial.print("URL : "); Serial.println(URL); 
  Serial.print("Data: "); Serial.println(postData);
  Serial.print("httpCode: "); Serial.println(httpCode);
  Serial.print("payload : "); Serial.println(payload);
  Serial.println("--------------------------------------------------");
  delay(5000);
}


void Load_DHT11_Data() {
  //-----------------------------------------------------------
  temperature = dht11.readTemperature(); //Celsius
  humidity = dht11.readHumidity();
  int soilMoistureLevel = analogRead(soilmoisture);
  //-----------------------------------------------------------
  // Check if any reads failed.
  if (isnan(temperature) || isnan(humidity)) {
    Serial.println("Failed to read from DHT sensor!");
    temperature = 0;
    humidity = 0;
  }
  //-----------------------------------------------------------
  Serial.printf("Temperature: %d °C\n", temperature);
  Serial.printf("Humidity: %d %%\n", humidity);

  // Map the soil moisture level to a range from 0 to 100
  moisturePercentage = map(soilMoistureLevel, 4095, 0, 0, 100);

  Serial.print("Soil Moisture Level (%): ");
  Serial.println(moisturePercentage);
  
  if (moisturePercentage >= 50) {
    suggestion = "Wet condition in the soil";
  
    Serial.println(suggestion); // Print a message
  } else {
    suggestion = "Dry condition, Turn on a Pump";
    Serial.println(suggestion); // Print a message
  }
}


void connectWiFi() {
  WiFi.mode(WIFI_OFF);
  delay(1000);
  //This line hides the viewing of ESP as wifi hotspot
  WiFi.mode(WIFI_STA);
  
  WiFi.begin(ssid, password);
  Serial.println("Connecting to WiFi");
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
    
  Serial.print("connected to : "); Serial.println(ssid);
  Serial.print("IP address: "); Serial.println(WiFi.localIP());
}