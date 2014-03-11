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
      src="earthquake.js">
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
