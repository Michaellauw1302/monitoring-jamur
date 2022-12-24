//library untuk jaringan wifi 
#include "WiFi.h"
#include "HTTPClient.h"
//#define HttpClient_h  
//masukan sensor suhu
#include <OneWire.h>
//MEMANGGIL FUNGSI DARI SENSOR SUHU, KIPAS DAN LAMPU----
#include <DallasTemperature.h>
#define ONE_WIRE_BUS 25
#define fan 33
#define pin_lamp 23
//-------------------------------------------
//membaca suhu dengan membuat variabel ONE_WIRE_BUS
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature sensor(&oneWire);
//-------------------------------------------
// membuat variabel UNTUK SENSOR PH
    int pH_Value;
    float ph;
//-------------------------------------------
const int pinDigital = A0; //pin sensor kelembaban tanah
const int relay = 33; //relay kipas
const int relay2 = 32; //relay pompa
//const int relay3 = 23; //relay lampu
//-------------------------------------------
//siapkan variable untuk wifi & password (hospot)
const char* ssid = "Hotspot@bumigora.net";
const char* password = "12345678";
//siapkan variable host / server komputer yg menampung aplikasi web & database
const char* host = "192.168.50.239"; //ip komputer local selalu berganti setiap konek ke hotstpo/wifi baru
//-------------------------------------------
// menyiapkan kebutuhan alat
void setup() {
 Serial.begin(9600);          //menampilkan data di serial monitor program arduino IDE
 pinMode(pH_Value, INPUT);    //menetapkan pin sensor pH sebagai input
 pinMode(fan,OUTPUT);         //menetapkan pin kipas sebagai output
 digitalWrite(fan,1);         //fan,1 menjelaskan kipas hidup
 pinMode(pin_lamp, OUTPUT);   //menetapkan pin lampu sebagai output
 //pinMode(pin_lamp,1);       //fungsi ini tidak dipakai (disable)
 sensor.begin();
 pinMode(pinDigital, INPUT);  //pin digital (A0) sensor kelembaban ditetapkan sebagai input
 pinMode(relay, OUTPUT);      //relay untuk mengatur sensor kelembaban
 pinMode(relay2, OUTPUT);     //relay untuk mengatur hitup mati pin kipas 
// pinMode(relay3, OUTPUT);
//-------------------------------------------
 //menyiapkan koneksi ke wifi
 WiFi.begin(ssid, password);
 Serial.println("Mencoba koneksi...");
 while(WiFi.status() != WL_CONNECTED)
 {
    Serial.print(".");
    delay(500);
 }
 //apabila berhasil terkoneksi
 Serial.println("Berhasil terkoneksi");
 
}
//-------------------------------------------
void loop() {
  sensor.setResolution(9);
  sensor.requestTemperatures();              //meminta nilai suhu untuk sensor suhu DS18B20
//-------------------------------------------
  //baca nilai suhu dan kelembaban
  float suhu = sensor.getTempCByIndex(0);    //membuat variabel sensor dan mendapatkan nilai suhu dari sensor suhu DS18B20
  float kel_tanah;
  int tanah = analogRead(pinDigital);        //membaca pin analog pada ESP32 sebagai variabel pinDigital
  kel_tanah = map (tanah, 4095, 0, 60, 100);
//-------------------------------------------
    //rumus untuk membaca nilai pH
    pH_Value = analogRead(A3);
    ph = pH_Value * (3.3 / 1023.0);          //nilai awal di ambil setelah modul pH di kalibrasi
//-------------------------------------------
  //logika / rumus untuk mendapatkan nilai suhu
  if (suhu >=29.00){                         //menggunakan fungsi if
    Serial.println("Panas butuh kipas");
    digitalWrite(relay, HIGH);  
    //digitalWrite(relay3, HIGH);
    digitalWrite(pin_lamp,LOW);
    Serial.println("lampu mati");
    digitalWrite(fan,0);
  }else{
    Serial.println("sudah sejuk, kipas mati ");
    digitalWrite(relay, LOW);
    //digitalWrite(relay3,LOW);
    digitalWrite(pin_lamp,HIGH);
    Serial.println("lampu hidup");
    digitalWrite(fan,1);
  }
  delay(1000);
//----------------------------------------------------------------
  //logika / rumus untuk mendapatkan nila kelembaban baglog
if (tanah <= 3000) { 
  Serial.println(". Tanaman Masih Basah... "); 
  Serial.println();
  digitalWrite (relay2, HIGH);       //relay sensor tanah Mati
  //digitalWrite(fan,0);
  }

 else if (tanah  <= 4000) {
  Serial.println(". Kelembaban Tanah Masih Cukup... "); 
  Serial.println();
  digitalWrite (relay2, HIGH);       //relay Mati
  //digitalWrite(fan,0);
  }

 else { Serial.println (". Perlu Tambahan Air... "); 
  Serial.println();
  digitalWrite (relay2, LOW);         //relay Hidup


 if (kel_tanah > 60 && kel_tanah <= 100) {
    Serial.println("Tanah basah");

  }
  else if (kel_tanah > 30 && kel_tanah <= 60) {
    Serial.println("Tanah kondisi normal");

  }
  else if (kel_tanah >= 0 && kel_tanah <= 30) {
    Serial.println("Tanah Kering");

  }
  //digitalWrite(fan,1); //kipas angin
  }
//-----------------------------------------------------------------  
  //tampilkan nilai sensor ke serial monitor
  Serial.println("Suhu :" + String(suhu) );
  Serial.println("Kelembaban Tanah :" + String(tanah) );
  Serial.println("Nilai PH adalah :" + String(ph) );

 Serial.print("Persentase Kelembaban Tanah = ");
  Serial.print(kel_tanah);
  Serial.println("%");
  delay(1000);
//----------------------------------------------------------------  
//proses kirim data ke server
  WiFiClient client;
  //inisialisasi port web server 80
  const int httpPort = 80;
  if(!client.connect(host, httpPort))
  {
    Serial.println("Koneksi Gagal");
    return;
  }
  //jika berhasil terkoneksi, maka data akan dikirim ke database
  String Link;
  HTTPClient http;

//konfigurasi koneksi antara alat sensor dengan database
  Link = "http://" + String(host) + "/multisensorv4/kirimdata.php?suhu=" + String(suhu) + "&tanah=" + String(tanah) + "&ph=" + String(ph) + "&kel_tanah=" + String(kel_tanah); //coding untuk mengirim data sensor ke db
  //eksekusi alamat link yang ada
  http.begin(Link);
  http.GET();

  //baca respon setelah berhasil kirim nilai sensor
  String respon = http.getString();
  Serial.println(respon);
  http.end();
  
  delay(1000);
}
//------------------------------------------------------------------------
