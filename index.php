
<!DOCTYPE html>
<?php if(!isset($_REQUEST['date'])){$request="2015-03-06";/*some future date so that play back doesnt start on its own*/$persec=2;$mag=6;}
else {$request=$_REQUEST['date'];$persec=$_REQUEST['persec'];$enddate=$_REQUEST['enddate'];$mag=$_REQUEST['mag'];}?>

<html>
  <head><link rel="stylesheet" href="style.css" type="text/css" media="all" />
    <style>
      html, body, #map_canvas { margin: 40; padding: 0; height: 100%; }
    </style>
    <script
      src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=visualization">
    </script>
    <script>
      var map;
var iterator = 0;
      function initialize() {
	  
        var mapOptions = {
          zoom: 2,
          center: new google.maps.LatLng(2.8,-187.3),
          mapTypeId: google.maps.MapTypeId.TERRAIN
        };
        map = new google.maps.Map(document.getElementById('map_canvas'),
              mapOptions);

       
        var script = document.createElement('script');
       
        script.src = 'http://comcat.cr.usgs.gov/fdsnws/event/1/query?starttime=<?php echo $request;?>%2000:00:00&minmagnitude=<?php echo $mag;?>&format=geojson&callback=eqfeed_callback&endtime=<?php echo $enddate;?>%2023:59:59&orderby=time-asc'; 
       
        document.getElementsByTagName('head')[0].appendChild(script);
      }

     
    var onMarkerClick = function() {
      var marker = this;
      var latLng = marker.getPosition();
      infoWindow.setContent('<h3>Earthquake position at is:</h3>' +
          latLng.lat() + ', ' + latLng.lng());

      infoWindow.open(map, marker);
    };
     
      window.eqfeed_callback = function(results) {
        for (var i = 0; i < results.features.length; i++) {
          setTimeout(function() {
      addMarker();
    }, i*<?php echo 1000/$persec?>);
        }
		 function addMarker() {
		 var coords = results.features[iterator].geometry.coordinates;
          var latLng = new google.maps.LatLng(coords[1],coords[0]);
          var marker = new google.maps.Marker({
            position: latLng,
            map: map
			
          }); 
		  iterator++;google.maps.event.addListener(marker, 'click', onMarkerClick);document.getElementById("p1").innerHTML=results.features[iterator].properties.place;document.getElementById("p2").innerHTML=results.features[iterator].properties.mag;
		  var date = new Date(results.features[iterator].properties.time);document.getElementById("p3").innerHTML=date;
	  
}
      }
	  var infoWindow = new google.maps.InfoWindow;


  </script>
  </head>
  <body onload="initialize()">
  <div id="form-div"><font size=3 color="black">Concord Seismic Eruption Map</font>
    <form class="form" id="form1" action="index.php">
      <p class="name"><label for="name">Start Date </label>
        <input name="date" type="text" placeholder="yyyy-mm-dd" class="" id="date"  />
         <label for="name">End Date</label>
		<input name="enddate" type="text" placeholder="yyyy-mm-dd" class="" id="enddate"  />
       <label for="name">Earthquakes/sec </label>
		<input name="persec" type="text" placeholder="Earthquake per second" class="" id="persec"  />
		<label for="name">Magnitude</label>
		<input name="mag" type="text" placeholder="Magnitude Cutoff" class="" id="mag"  />
         <p class="submit">
        <input type="submit" value="Play" />
      </p></form>
      </p><font size=2>Current Earthquake Details:<p id="p1"></p><p id="p2"></p><p id="p3"></p></font></div>
    <div id="map_canvas"></div>
  </body>
</html>
