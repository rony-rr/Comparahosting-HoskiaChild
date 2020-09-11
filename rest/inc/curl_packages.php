<?php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://prov.kaufberater.io/api/data/ES",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
));
$response = json_decode(curl_exec($curl));

if($response == null){
  return 'Ha ocurrido un error con la peticion'; 
}

curl_close($curl);