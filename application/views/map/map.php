<!DOCTYPE html>
<html>
<head>
  <title>Map of Checkins</title>
  <style type="text/css">
    html { height: 100% }
    body { height: 100%; margin: 0px; padding: 0px }
    #map_canvas { height: 100% }
  </style>
</head>
<body>
<!--  <h1 id="map!">Map!</h1> -->
  <div id="map_canvas"></div>
  
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
  <script type="text/javascript" charset="utf-8">
    var latlng = new google.maps.LatLng(40.692778, -73.990278);
    var myOptions = {
      zoom: 14,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"),
      myOptions);
      
<?php
  $v = array();
  foreach($venues as $venue) {

if(is_array($venue['loc']))
    array_push($v, array(
      'name' => $venue['name'],
      'count' => $venue['count'],
      'loc' => array(
        $venue['loc']['lat'],
        $venue['loc']['lng'],
      ),
    ));
  }
  echo 'var venues = ',json_encode($v),';', PHP_EOL;
?>
    var infowin = null;
    for(var i=0;i<venues.length;i++) {
      (function() {
        var point = new google.maps.LatLng(venues[i].loc[0], venues[i].loc[1]),
          info = venues[i].name + "<p>Visited " + venues[i]['count'] +"</p>";
        
      var mark = new google.maps.Circle({
        center: point,
//        radius: venues[i]['count']*5,
        radius: 1/(1+Math.log(venues[i]['count']))*40*venues[i]['count'],
        fillColor:'#ff0000',
        fillOpacity: 0.55,
        strokeOpacity:0.8,
        strokeColor: "#cccccc",
        strokeWeight: 2,
        map:map
      });
      google.maps.event.addListener(mark, 'click', function() {
        if(null !== infowin) {
          infowin.close();
        }
        var infowindow = new google.maps.InfoWindow({
            content: info,
            position: point
        });
        google.maps.event.addListener(infowindow, 'closeclick', function() {
          infowin = null;
        })
        infowindow.open(map);
        infowin = infowindow;
      })
    })();
    }
  </script>
<?php
  echo View::factory('shared/footer');
?>
