#include <ESP8266WiFi.h>
#include <TinyGPS++.h>                                  // Libreria Tiny GPS Plus para el uso del GPS Ublox Neo 6M
#include <SoftwareSerial.h>                             // Librería Software Serial para utilizar otros pines como conexión serial, para comunicación con el GPS.
#include <Adafruit_ssd1306syp.h>                        // Librería de Adafruit para el display OLED


const char* ssid     = "AndroidAP5D1F";      // SSID
const char* password = "j12345678";      // Password
const char* host = "verpeliculasfree.com";  // Dirección IP local o remota, del Servidor Web
const int   port = 80;            // Puerto, HTTP es 80 por defecto, cambiar si es necesario.
const int   watchdog = 2000;        // Frecuencia del Watchdog
unsigned long previousMillis = millis(); 

String dato;
String cade;
String line;
int ID_TARJ=1; // Este dato identificará cual es la tarjeta que envía los datos, tener en cuenta que se tendrá más de una tarjeta. 
              // Se debe cambiar el dato (a 2,3,4...) cuando se grabe el programa en las demás tarjetas.

int datoId;
int proceso = 0; // Proceso donde espera inicio y finaliza el servicio

Adafruit_ssd1306syp display(4,5);                       // Definición de pines del Display OLED (SDA a Pin 4), (SCL a Pin 5)

static const int RXPin = 12, TXPin = 13;                // Definición de pines del GPS 12 RX y 13 TX
static const uint32_t GPSBaud = 9600;                   // Tasa de transmisión por defecto del Ublox GPS: 9600

const double Home_LAT = 2.49307;                      // Aquí pueden definir la LATITUD de la ubicación de un SITIO, el programa cálcula la distancia en Km al sitio detectado por el GPS. Importante que usen al menos 5 decimales para que el calculo sea lo más aproximado posible.
const double Home_LNG = -76.55980;                     // Aquí pueden definir la LONGITUD de la ubicación de un SITIO, el programa cálcula la distancia en Km al sitio detectado por el GPS. Importante que usen al menos 5 decimales para que el calculo sea lo más aproximado posible.

TinyGPSPlus gps;                                        // Crea una instancia del objeto TinyGPS++ que se denomina gps
SoftwareSerial ss(RXPin, TXPin);                        // Determina la conexión serial con el GPS en los pines ya definidos, 12 y 13.


static void smartDelay(unsigned long ms)                // Un tipo de retraso que asegura la operación del gps
{
  unsigned long start = millis();
  do 
  {
    while (ss.available())
      gps.encode(ss.read());
  } while (millis() - start < ms);
}


void setup()
{  
  display.initialize();                                 // Inicializa el display OLED 
  display.clear();                                      // Borra lo presentado en el display OLED
  display.setTextSize(1);                               // Fija el tamaño del texto en el display OLED 
  display.setTextColor(WHITE);                          // Fija el color del texto
  display.setCursor(0,0);                               // Fija el cursor en la posición 0,0 del display
  display.println("Localizacion por GPS");  
  display.println(TinyGPSPlus::libraryVersion());
  display.update();                                     // Actualiza el display, para que lo que se ha enviado hasta el momento, después de borrar, se presente en pantalla.
  delay(2500);                                          // Pausa de 2,5 segundos, para poder ver lo presentado en pantalla  
  display.clear();                                      // Borra lo presentado en el display OLED
  display.setCursor(0,0);                               // Fija el cursor en la posición 0,0 del display
  display.println("Conectando a...");  
  display.println(ssid);
  display.update();                                     // Actualiza el display, para que lo que se ha enviado hasta el momento, después de borrar, se presente en pantalla.
  delay(1500);                                          // Pausa de 1,5 segundos, para poder ver lo presentado en pantalla
  WiFi.begin(ssid, password);                           // Inicializa la conexión WiFi de la tarjeta ESP8266 12E
  display.clear();                                      // Borra lo presentado en el display OLED
  display.setCursor(0,0);                               // Fija el cursor en la posición 0,0 del display
  display.print("Esperando conexion WiFi");
  display.update();                                     // Actualiza el display, para que lo que se ha enviado hasta el momento, después de borrar, se presente en pantalla.
  while (WiFi.status() != WL_CONNECTED) {               // Espera a que se establezca la conexión con el WiFi, mientras tanto va presentando "puntos", hasta que se conecte.
    display.print(".");
    display.update();                                   // Actualiza el display, para que se vayan presentado los "puntos" de espera en pantalla.
    delay(500);
  }
  display.setCursor(0,0);                               // Fija el cursor en la posición 0,0 del display
  display.clear();                                      // Borra lo presentado en el display OLED
  display.println("");
  display.println("WiFi conectado");  
  display.println("Direccion IP: ");
  display.println(WiFi.localIP());                      // Envía al display la IP asignada
  display.update();                                     // Actualiza el display, para que lo que se ha enviado hasta el momento, se presente en pantalla.
  delay(2000);                                          // Pausa de 2 segundos, para poder ver lo presentado en pantalla
  ss.begin(GPSBaud);                                    // Fija la velocidad del Puerto serial creado a 9600    
}

void loop()
{   
  unsigned long currentMillis = millis();               // Definición de variables.
  double lati;
  double longi;
  display.clear();
  display.setCursor(0,0); 
  lati = gps.location.lat();                            // Obtiene el valor de latitud del GPS.  
  int lat_entero;                                       // Las siguientes lineas son para almacenar en una variable el componente entero y en otra variable el componente decimal de la latitud
  int lat_decimal;                                      // para unirlos posteriormente, ya que si se deja todo en una sola variable, lo deja por defecto en dos decimales, lo cual no es suficiente
  int lat_entero_abs;                                   // para obtener una buena ubicación en un mapa. También se maneja una variable para valor absoluto, en casos de valores negativos.
  lat_entero = int(lati);
  lat_entero_abs = abs(lat_entero);
  lat_decimal = int((abs(lati) - lat_entero_abs) * 100000);

  Serial.print(lat_entero);
  if (lat_entero == 0)                                  // Se coloca éste condicional para que cuando el GPS apenas ha iniciado, no envíe valores de ubicación con 0, a la base de datos
   { 
     display.print("Esperando obtener datos del GPS...");  // en caso de que los valores recibidos del GPS de latitud sean 0, presenta en pantalla que está esperando obtener datos del GPS.
     display.update();                                     // Actualiza el display para mostrar el mensaje.
     delay (1000);
     display.clear();
     display.update();                                     // Actualiza el display para mostrar la pantalla limpia.
     delay (1000);
   }
   else
   {  
     display.print("Latit   : ");                         // Envía a la pantalla (sin presentarlo aún, porque no hay update) el valor de latitud medido por el GPS.
     display.println(lati,5);
     display.print("Longit  : ");
     longi = gps.location.lng();                          // Obtiene el valor de longitud del GPS.  
     int lon_entero;                                      // Las siguientes lineas son para almacenar en una variable el componente entero y en otra variable el componente decimal de la longitud
     int lon_decimal;                                     // para unirlos posteriormente, ya que si se deja todo en una sola variable, lo deja por defecto en dos decimales, lo cual no es suficiente
     int lon_entero_abs;                                  // para obtener una buena ubicación en un mapa. También se maneja una variable para valor absoluto, en casos de valores negativos.
     lon_entero = int(longi);
     lon_entero_abs = abs(lon_entero);
     lon_decimal = int((abs(longi) - lon_entero_abs) * 100000);
     display.println(longi,5);
     display.print("Satelit : ");                         // Envía a la pantalla (sin presentarlo aún, porque no hay update) el valor del # de satelites medido por el GPS.
     display.println(gps.satellites.value());
     display.print("Altitud : ");                         // Envía a la pantalla (sin presentarlo aún, porque no hay update) el valor de altitud en metros, medido por el GPS.
     display.print(gps.altitude.meters());
     display.println("mts");                          
     display.print("Hora/Min: ");                         // Envía a la pantalla (sin presentarlo aún, porque no hay update) el valor de hora, minutos y segundos, medido por el GPS.
     display.print(gps.time.hour());                       
     display.print(":");
     display.print(gps.time.minute());                     
     display.print(":");
     display.println(gps.time.second());                   
     display.print("Velocid : ");
     display.print(gps.speed.kmph());                     // Envía a la pantalla (sin presentarlo aún, porque no hay update) el valor de velocidad, calculado por el GPS.
     display.println(" km/h"); 
     unsigned long Distance_To_Home = (unsigned long)TinyGPSPlus::distanceBetween(gps.location.lat(),gps.location.lng(),Home_LAT, Home_LNG);
     display.print("Dis casa: ");                        // Envía a la pantalla (sin presentarlo aún, porque no hay update) el valor de distancia al sitio en kms, referenciado arriba, calculado por el GPS.
     display.print(Distance_To_Home);
     display.println(" km"); 
     display.update();                                  // Actualiza la pantalla para mostrar lo que se ha enviado hasta el momento y presenta un retardo, para poder visualizarlo.
     delay(3000); 

     if ( currentMillis - previousMillis > watchdog ) {
        previousMillis = currentMillis;
     WiFiClient client;                                  // Realiza una instancia de WiFiClient denominada client, para poder acceder al servidor web a enviar los datos medidos a la Base de datos
  
     if (!client.connect(host, port)) {
       display.setCursor(0,0);                            // Si hay error en la conexión con el servidor web, se presenta un error de conexión fallida.
       display.clear();                                      
       display.println("Conex. fallida al servidor...");
       display.update();                                     
       delay(1000); 
       return;
      }
  if(proceso == 0){


              Serial.print("hola");
          // Mirando el estado obtenemos el id 
            
                String url = "/taximetro/proceso_eventos/servicio_estado.php";
                // Envío de la solicitud al Servidor
                client.print(String("GET ") + url + " HTTP/1.1\r\n" +
                           "Host: " + host + "\r\n" + 
                           "Connection: close\r\n\r\n");
                unsigned long timeout = millis();
                while (client.available() == 0) {
                  if (millis() - timeout > 5000) {
                    Serial.println(">>> Superado tiempo de espera!");
                    return;
                  }
                }
               
            
                // Lee respuesta del servidor
                while(client.available()){
                  line = client.readStringUntil('\r');
            
                  line.trim();
                  datoId = line.toInt();
            
                  Serial.print(datoId);
                  //Serial.print(line);
                }
                  int longitud = line.length();
            
            
                  
                  int longitud_f = longitud;
                  longitud = longitud - 4;
                  
                  dato = line.substring(longitud,longitud_f);
                  //dato.trim(); // Para quitarle los espacios
            
                       Serial.print("hola");
                      Serial.print(datoId);
                if(datoId > 0){
            
                  proceso = 1;
                  Serial.print("llego");
                  
                }

      }
  /*           //LOCALIZACION CONDUCTORES
      String url1 = "/taximetro/mapa/proceso_localizacion.php?latitud="; // Si hay conexión, arma la url con los datos medidos
       url1 += lat_entero;
       url1 += ".";
       url1 += lat_decimal;
       url1 += "&longitud=";
       url1 += lon_entero;
       url1 += ".";
       url1 += lon_decimal;
       url1 += "&ID_TARJ=";
       url1 += ID_TARJ;
       url1 += "&velocidad=";
       url1 += gps.speed.kmph();
       url1 += "&altitud=";
       url1 += gps.altitude.meters();

       // Envío de la solicitud al Servidor
       client.print(String("GET ") + url1 + " HTTP/1.1\r\n" +
             "Host: " + host + "\r\n" + 
            "Connection: close\r\n\r\n");
       unsigned long timeout = millis();
       while (client.available() == 0) {                     // Verifica que no se supere el tiempo de espera de 5 segundos, esperando respuesta del servidor web
       if (millis() - timeout > 5000) {
              display.println(">>> Superado tiempo de espera!");
              client.stop();
              return;

          }
      }*/
  
    
 
  


  if(proceso == 1){    
       String url = "/taximetro/mapa/programa_GPS.php?latitud="; // Si hay conexión, arma la url con los datos medidos
       url += lat_entero;
       url += ".";
       url += lat_decimal;
       url += "&longitud=";
       url += lon_entero;
       url += ".";
       url += lon_decimal;
       url += "&ID_TARJ=";
       url += ID_TARJ;
       url += "&velocidad=";
       url += gps.speed.kmph();
       url += "&altitud=";
       url += gps.altitude.meters();

       // Envío de la solicitud al Servidor
       client.print(String("GET ") + url + " HTTP/1.1\r\n" +
             "Host: " + host + "\r\n" + 
            "Connection: close\r\n\r\n");
       unsigned long timeout = millis();
       while (client.available() == 0) {                     // Verifica que no se supere el tiempo de espera de 5 segundos, esperando respuesta del servidor web
       if (millis() - timeout > 5000) {
              display.println(">>> Superado tiempo de espera!");
              client.stop();
              return;
        }
      }
  
     // Lee respuesta del servidor                           // Si hay respuesta se lee dicha respuesta y se envía al display el mensaje de DATO ENVIADO4
      while(client.available()){
      line = client.readStringUntil('\r');
      
     }
       display.clear();
       display.setCursor(0,0); 
       display.print("Dato enviado...");
       display.print(line);
       display.update();                                     
       delay(3000); 

  }
     }
     
     }

     smartDelay(500);                                      // Ejecuta un retardo especial, para saber si hay o no respuesta del GPS.
     if (millis() > 5000 && gps.charsProcessed() < 10)
        display.println(F("No GPS data received: check wiring"));
   }
   
   
    
  // finaliza función loop
