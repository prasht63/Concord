<!DOCTYPE html>
<?php if(!isset($_REQUEST['date'])){$request="2012-03-06";}
else {$request=$_REQUEST['date'];}?>

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
       
        script.src = 'http://comcat.cr.usgs.gov/fdsnws/event/1/query?starttime=<?php echo $request?>%2000:00:00&minmagnitude=6&format=geojson&callback=eqfeed_callback&endtime=2014-03-06%2023:59:59&orderby=time'; //data for last month starting from 2013-02-6 to 2014-03-6 and magnitude greater than 6
        //script.src = 'earthquake_GeoJSONP';
        document.getElementsByTagName('head')[0].appendChild(script);
      }

     
      window.eqfeed_callback = function(results) {
        for (var i = 0; i < results.features.length; i++) {
          setTimeout(function() {
      addMarker();
    }, i*100);
        }
		 function addMarker() {
		 var coords = results.features[iterator].geometry.coordinates;
          var latLng = new google.maps.LatLng(coords[1],coords[0]);
          var marker = new google.maps.Marker({
            position: latLng,
            map: map
          }); iterator++;
	  
}
      }
	 

  </script>
  </head>
  <body onload="initialize()">
  <div id="form-div">
    <form class="form" id="form1">Enter Date to see Earthquakes from.
      <p class="name">
        <input name="date" type="text" placeholder="yyyy-mm-dd" class="" id="date"  />
        <label for="name">Current Starting Date is <?php echo "$request"?></label>
      </p><font size=3 color="black">Concord Seismic Eruption Map</div>
    <div id="map_canvas"></div>
  </body>
</html>