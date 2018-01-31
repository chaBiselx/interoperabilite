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

$positionXml = getXml("https://freegeoip.net/xml/".$IP);
$lat = $positionXml->Latitude;
$long = $positionXml->Longitude;
// var_dump($positionXml);

//XSLTprocessor
$xslt = new XSLTProcessor(); 
$XSL = new DOMDocument(); 
$XSL->load( 'meteo.xslt' );
$xslt->importStylesheet( $XSL ); 

$meteoXml = getXml("http://www.infoclimat.fr/public-api/gfs/xml?_ll=" . $lat . "," . $long . "&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2");

// var_dump($meteoXml);

//apply xslt template
echo $xslt->transformToXML( $meteoXml );

function getXml($url) {
  $file = file_get_contents($url);
  echo $file;
  if ($file === false) {
    // TODO erreur reseau
    return false;
  } else {
    $xml = simplexml_load_string($file);
    if ($xml === false) {
      // TODO erreur xml
      return false;
    }
    else {
      return $xml;
    }
  }
}

?>
