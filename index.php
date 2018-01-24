<?php
//ip client
//$IP = $_SERVER['REMOTE_ADDR'];
$IP = "193.50.135.197";

echo getPosition();
echo getVeloStan();
echo getMeteo();

function getPosition(){
  $xml = file_get_contents( "https://freegeoip.net/xml/".$IP) ;
  if(empty($xml)){
    return errorPos; //en cas d'erreur
  }else{
    return $xml;
  }
}

function getVeloStan(){
  $veloStan = file_get_contents( "http://www.velostanlib.fr/service/carto") ;
  if(empty($veloStan)){
    return errorStan; //en cas d'erreur
  }else{
    return $veloStan;
  }
}

function getMeteo(){
  $veloStan = file_get_contents( "http://www.infoclimat.fr/public-api/gfs/xml?_ll=48.67103,6.15083&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2") ;
  if(empty($veloStan)){
    return errorMeteo; //en cas d'erreur
  }else{
    return $veloStan;
  }
}

?>
