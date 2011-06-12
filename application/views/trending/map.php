<?php
  echo View::factory('shared/header')
    ->set('title', "What's trending now map");
?>

<style type="text/css"> 
  html { height: 100% }
  body { height: 100%; margin: 0px; padding: 0px }
  #map_canvas { height: 100% }
</style>

<div id="map_canvas">
  
  
<script>
<?php

  $start_sec = $start->format('U');
  $end_sec = $end->format('U');

  $locations = array();
  $counts = array();
  
  foreach($venues as $venue) {
    /*
    echo '<pre>';
    print_r($venue);
    break;
    */
    
    $id = $venue['_id'];
    $locations[$id] = array($venue['location']['lat'], $venue['location']['lng']);
    
    $trends = array_fill(0, 60*24, 0);
    foreach($venue['here'] as $trend) {
      if($trend['date']->sec < $start_sec || $trend['date']->sec > $end_sec) {
        continue;
      }
      
      //date('Y-m-d H:i',
      $trends[ floor(($trend['date']->sec - $start_sec) / 60) ] = $trend['count'];
    }
    
    $chunks = 48;
    $maxed = array();
    for($i = 0 ; $i < $chunks ; $i++) {
      $chunk = array_slice($trends, $i * 60*24/$chunks, 60*24/$chunks);
      $maxed[$i] = max($chunk);
    }
    $counts[$id] = $maxed;
  }
  
//  $delta = new DateInterval('P1M'); // one minute

  echo 'var locations = ', json_encode($locations), ';', PHP_EOL;
  echo 'var counts = ', json_encode($counts), ';', PHP_EOL;

  
?>


function initialize() {
  var myLatlng = new google.maps.LatLng(40.735631, -73.990474);
  var myOptions = {
    zoom: 13,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  
  function setCircles() {
    var circles = {};
    for(var id in locations) {
      var point = new google.maps.LatLng(locations[id][0], locations[id][1]);
      circles[id] = new google.maps.Circle({
            center: point,
            radius: 0,
            fillColor:'#ff0000',
            fillOpacity: 0.55,
            strokeOpacity:0.8,
            strokeColor: "#cccccc",
            strokeWeight: 2,
            map:map
        });
    }
    return circles;
  }
  
  var circles = setCircles();
  
  var min = 0;
  
  function animate() {
    for(var id in counts) {
      circles[id].setRadius(1/(1+Math.log(counts[id][min]))*80*counts[id][min])
    }
    min++;
    console.log(min);
    if(min > <?php echo $chunks; ?>) {
      clearInterval(intrvl);
    }
  }
  
  animate();
  var intrvl = setInterval(animate, 200);
}
  
(function() {
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
  document.head.appendChild(script);
})();
</script>



<?php
  echo View::factory('shared/footer');
?>