var overlays = {};
var infowin = null;

google.maps.event.addListener(map, 'idle', function() {
  var bounds = map.getBounds();
  $.get('/~ddunlop/4sq/map/ajax/1', {bounds:bounds.toUrlValue()}, function(venues) {
    /*
    for(var i = 0 ; i < overlays.length ; i++ ) {
      overlays[i].setMap(null);
    }
    overlays.length = 0;
    */
    var oldOverlays = {};
    for(var id in overlays) {
      oldOverlays[id] = true;
    }
    for(var i=0;i<venues.length;i++) {
      if( venues[i]._id in overlays ) {
        delete oldOverlays[venues[i]._id];
        continue;
      }
      (function() {
        var point = new google.maps.LatLng(venues[i].loc[0], venues[i].loc[1]),
          info = venues[i].name + "<p>Visited " + venues[i]['count'] +"</p>";

        var mark = new google.maps.Circle({
          center: point,
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
        });
        overlays[venues[i]._id] = mark;
      })();
    }
    for(var id in oldOverlays) {
      overlays[id].setMap(null);
      delete overlays[id];
    }
  });
});