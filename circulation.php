<?php
set_error_handler(function() {});

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

$eventsJSON=file_get_contents('http://api.loire-atlantique.fr/opendata/1.0/traficevents?filter=Tous');
if ($eventsJSON === false) {
  echo 'Erreur telechargement json depuis API';
  exit();
}
$events = json_decode($eventsJSON);
if ($events == null) {
  echo 'Erreur traitement du fichier json';
  exit();
}

?>

<html>
<head>
  <title>Difficultés de circulation</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
  integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
  crossorigin=""/>
  <!-- Make sure you put this AFTER Leaflet's CSS -->
  <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
  integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
  crossorigin=""></script>
  <script>
  window.onload = function () {
    var mymap = L.map('mapid').setView([47.2382007,-1.6300953], 9);
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      {
        maxZoom: 17,
        minZoom: 9
      }).addTo(mymap);
    var markers = [];
    <?php
    // code js generé avec php, pas très propre, le plus simple est de passer
    // les données en json au client et de les traiter directement en JS
    // mais je sais pas si ca irait pour le sujet vu que l'on utiliserait pas
    // json_decode
      foreach ($events as $idx => $event) {
        $popup = '';
        foreach ($event as $key => $value) {
          if (substr( $key, 0, 5 ) === "ligne") {
            $popup = $popup . $value . '<br>';
          }
        }
        echo 'markers[' . $idx . ']=L.marker([' . $event->latitude . ', ' . $event->longitude . ']).addTo(mymap);';
        echo 'markers[' . $idx . '].bindPopup("' . $popup . '");';
      }
    ?>
  }
  </script>
  <style media="screen">
    #mapid { height: 100%; }
  </style>
</head>
<body>
  <div id="mapid"></div>
</body>
</html>

