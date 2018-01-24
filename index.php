<?php

if (gethostname() === "webetu.iutnc.univ-lorraine.fr") {
  stream_context_set_default(
   array(
    'http' => array(
     'proxy' => "tcp://www-cache:3128",
     'request_fulluri' => true
    )
   )
  );
}

//ip client
$IP = $_SERVER['REMOTE_ADDR'];
// $IP = "193.50.135.197";

echo getPosition();
echo getVeloStan();
echo getMeteo();

function getFile($url) {
  $file = file_get_contents($url);
  if ($file === false) {
    // TODO error
    return false;
  } else {
    return $file;
  }
}

function getPosition(){
  $postionXml = getFile( "https://freegeoip.net/xml/".$IP);
  return $postionXml;
}

function getVeloStan(){
  $veloStanXml = getFile( "http://www.velostanlib.fr/service/carto");
  return $veloStanXml;
}

function getMeteo(){
  $meteoXml = getFile( "http://www.infoclimat.fr/public-api/gfs/xml?_ll=48.67103,6.15083&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2");
}

?>
