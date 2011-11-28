<!DOCTYPE html>
<html>
<head>
  <title>Map of Checkins</title>
  
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  <style type="text/css">
    html { height: 100% }
    body { height: 100%; margin: 0px; padding: 0px }
    #map_canvas { height: 100% }
  </style>
  
</head>
<body>
  <div id="map_canvas"></div>
  
  <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
  <script>
    var myOptions = {
      zoom: 14,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"),
      myOptions);
    function setHome() {
      var CarrollGardens = new google.maps.LatLng(40.692778, -73.990278);
      map.setCenter(CarrollGardens);
    }

    if(navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
        map.setCenter(initialLocation);
      }, setHome);
    }
    else {
      setHome();
    }
  </script>
<?php
  echo View::factory('shared/footer')
    ->set('script', 'media/js/map.js');
?>
