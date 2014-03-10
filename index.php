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

    
      window.eqfeed_callback = function(results) {
	  
        for (var i = 0; i < results.features.length; i++) /*The results are stored in array results and can be accesed via the counter*/
		{
          setTimeout(function()
		  {
      addMarker();
    }, i*<?php echo 1000/$persec?>);
        } //adding marker fns
		 function addMarker() {
		 var earthquake = results.features[iterator];
         var coords = earthquake.geometry.coordinates;
         var latLng = new google.maps.LatLng(coords[1],coords[0]);
         var marker = new google.maps.Marker({
            position: latLng,
            map: map,
			title:""+iterator,
			icon: getCircle(earthquake.properties.mag,results.features[iterator].geometry.coordinates[2]) /*To plot the marker as a circle with radius depending on magnitude and colour depending upon depth
			*/
          }); 
		  iterator++;
		google.maps.event.addListener(marker, 'mouseover', function()/*Adding a eventlistener to add mouseover property*/
		{
	  
      var marker = this;
       var date = new Date(results.features[marker.title].properties.time);
      infoWindow.setContent('<h3>Earthquake Details</h3><hr>Place:' +results.features[marker.title].properties.place+
	  '<br>Magnitude:'+results.features[marker.title].properties.mag+'<br>Depth:'+results.features[marker.title].geometry.coordinates[2]+'km<br>Date:'+date);/*Writing information in the content window at the call time rather than run time.Increased efficiency and lower use of resources.*/

      infoWindow.open(map, marker);/*CallingFunction to pop up information window*/
    }); /*Printing information about the current earthquake being plotted*/
		  document.getElementById("p1").innerHTML=results.features[iterator].properties.place;
		  document.getElementById("p2").innerHTML=results.features[iterator].properties.mag;
		  var date = new Date(results.features[iterator].properties.time);
		  document.getElementById("p3").innerHTML=date;
	  
}
      }
	  function getCircle(magnitude,depth) {var col;if(depth<70){col="red"}if(depth>=70 && depth <=300){col="yellow";}if(depth>300){col="green";} /*Setting colour of circle marker basedepth*/  
	  return {
  
    path: google.maps.SymbolPath.CIRCLE,
    fillColor:''+col,
    fillOpacity: .4,
    scale: Math.pow(2, magnitude/1.2) / Math.PI,//radius based on magnitude
    strokeColor: 'blue',
    strokeWeight: .5
  };
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
      </p><font size=2><!--Current Earthquake Details:<p id="p1"></p><p id="p2"></p><p id="p3"></p></font><p>-->Depth Code:<br> Red:<70kms <br>Yellow:70kms to 300 km</br>Green:>300kms</div>
    <div id="map_canvas"></div>
  </body>
</html>
