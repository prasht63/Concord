<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css" type="text/css" media="all" />
    <style>
      html, body, #map_canvas { margin: 40; padding: 0; height: 100%; }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=visualization"></script>
	<script src="plotearthquake.js"></script>
</head>
  <body >
  <div id="form-div">
  <font size=3 color="black">Concord Seismic Eruption Map</font>
  <br>
  <label for="name">Start Date </label>
  <input type="text" placeholder="yyyy-mm-dd" id="date"  />
  <label for="name">End Date</label>
  <input type="text" placeholder="yyyy-mm-dd" id="enddate"  />
  <label for="name">Earthquakes/sec </label>
  <input type="text" placeholder="Earthquake per second" id="persec"  />
  <label for="name" value="6">Magnitude</label>
  <input  type="text" placeholder="Magnitude Cutoff"  id="mag"  />
  <p class="submit">
  <input type="submit" onclick="initialize()" value="Play" />
  </p>
 
      </p><font size=2>Current Earthquake Details:<p id="p1"></p><!--</p><p id="p2"></p><p id="p3"></p></font><p>-->
	  Depth Code:<br> Red:<70kms <br>Yellow:70kms to 300 km</br>Green:>300kms
	  <input type="checkbox" id="tectonics" checked="checked" onclick="check()" />Tectonic Plates</div>
      <div id="map_canvas"></div>
   </body>
</html>
