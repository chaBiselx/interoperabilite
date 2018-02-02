function init(lat , lng) {
  //var lat = 42.35;
  //var lng = -71.08
  // initialize the map
  var map = L.map('mapid').setView([lat, lng], 13);

  // load a tile layer
  L.tileLayer('http://tiles.mapc.org/basemap/{z}/{x}/{y}.png',
    {
      attribution: 'Tiles by <a href="http://mapc.org">MAPC</a>, Data by <a href="http://mass.gov/mgis">MassGIS</a>',
      maxZoom: 17,
      minZoom: 9
    }).addTo(map);
}
