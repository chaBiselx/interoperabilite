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
//$IP = $_SERVER['REMOTE_ADDR'];
$IP = "193.50.135.197";


$velostanlibxml = getXml("http://www.velostanlib.fr/service/carto");
$velostanlibJSON = json_encode( $velostanlibxml );
$listMarker = $velostanlibxml;


$positionXml = getXml("https://freegeoip.net/xml/".$IP);
$lat =  $positionXml->Latitude ;
$long = $positionXml->Longitude;
// var_dump($positionXml);

//XSLTprocessor
$xslt = new XSLTProcessor();
$XSL = new DOMDocument();
$XSL->load( 'meteo.xslt' );
$xslt->importStylesheet( $XSL );

$meteoXml = getXml("http://www.infoclimat.fr/public-api/gfs/xml?_ll=" . $lat . "," . $long . "&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2");

$meteoJSON = json_encode($meteoXml);

// var_dump($meteoXml);
foreach ($meteoXml->echeance as $key => $echeance) {
  // var_dump($echeance);
  // foreach ($echeance->temperature as $key => $value) {
  //   var_dump($value);
  // }
}

function getXml($url) {
  $file = file_get_contents($url);
  // echo $file;
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

<html>

<head>
  <title>Evolution température</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
  <script src="node_modules/chart.js/dist/Chart.js"></script>
  <script src="node_modules/chart.js/samples/utils.js"></script>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/main.css"/>


  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""
  />
  <!-- Make sure you put this AFTER Leaflet's CSS -->
  <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin="">
  </script>
  <style>
  canvas {
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
  }
  </style>

<script type="text/javascript">
	function init() {

  // initialize the map
  var map = L.map('mapid').setView([<?php echo $lat ?> , <?php echo $long ?>], 13);

  // load a tile layer
  L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
      maxZoom: 17,
      minZoom: 9
    }).addTo(map);

  var marker = L.marker([ <?php echo $lat ?> , <?php echo $long ?> ]).addTo(map);

//==========================================================================================================
//afficher la liste des markers
  console.log(<?php echo $listMarker ?>);

}
</script>


</head>

<body>
  <div style="width:75%;">
    <canvas id="canvas"></canvas>
  </div>
  <?php
    //apply xslt template
    echo $xslt->transformToXML($meteoXml);
  ?>
  <script>

  var meteo = <?php echo $meteoJSON; ?>;
  var dates = [];
  var temperatures = [];
  for (var i = 0; i < meteo.echeance.length; i++) {
    dates.push(meteo.echeance[i]['@attributes'].timestamp);
    temperatures.push((meteo.echeance[i].temperature.level[0] - 273).toFixed(1)); // 2 metres, K to C
  }

  var timeFormat = 'YYYY-MM-DD HH:mm:ss';

  function newDate(days) {
    return moment().add(days, 'd').toDate();
  }

  function newDateString(days) {
    return moment().add(days, 'd').format(timeFormat);
  }

  function newTimestamp(days) {
    return moment().add(days, 'd').unix();
  }

  var color = Chart.helpers.color;
  var config = {
    type: 'line',
    data: {
      labels: dates,
      datasets: [{
        label: "Temperature à 2 metres (C)",
        backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
        borderColor: window.chartColors.red,
        fill: false,
        data: temperatures,
      }]
    },
    options: {
      title:{
        text: "Chart.js Time Scale"
      },
      scales: {
        xAxes: [{
          type: "time",
          time: {
            format: timeFormat,
            // round: 'day'
            tooltipFormat: timeFormat,
            unit: 'day',
            unitStepSize: 1,
            displayFormats: {
              'millisecond': 'DD/MM',
              'second': 'DD/MM',
              'minute': 'DD/MM',
              'hour': 'DD/MM',
              'day': 'DD/MM',
              'week': 'DD/MM',
              'month': 'DD/MM',
              'quarter': 'DD/MM',
              'year': 'DD/MM',
            }
          },
          scaleLabel: {
            display: true,
            labelString: 'Date'
          }
        }, ],
        yAxes: [{
          scaleLabel: {
            display: true,
            labelString: 'Temperature (C)'
          }
        }]
      },
    }
  };

  window.onload = function() {
    var ctx = document.getElementById("canvas").getContext("2d");
    window.myLine = new Chart(ctx, config);

  };


  </script>
  <div class="content">
    <div id="mapid"></div>
    <script type="text/javascript">  init();
    </script>
  </div>
  <footer>
    Site créé par BISELX Charles, ESCAMILLA Valentin, PENGUILLY Bertrand
  </footer>
</body>
</html>
