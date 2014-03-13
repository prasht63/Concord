   
	   var script;
       var map; //Setting up a map variable
       var iterator = 0; //Setting up a iterator to traverse the array
	   var tectonics = new google.maps.KmlLayer("http://en.glotter.com/data/kml/data2827.kml", 
	  {
       suppressInfoWindows: true,
       preserveViewport: true
      }); 
	  
      function initialize()
	  {  
	  var mapOptions = {
                        zoom: 2,
                        center: new google.maps.LatLng(2.8,-187.3),
                        mapTypeId: google.maps.MapTypeId.TERRAIN
                       };
      map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions); //assinging value to map variable
	 assign();
	  check();
      
      
	   
      }//initialize

    function check() 
      {
       if(document.getElementById('tectonics').checked)
	   {
	   tectonics.setMap(map);
	   }
	   else 
       {
	   tectonics.setMap(null);
	   }
     } //check
function assign() 
      {
	  var date,enddate,mag,persec;
	  date=document.getElementById('date').value;
	  enddate=document.getElementById('enddate').value;
	  mag=document.getElementById('mag').value;
	  
     script = document.createElement('script');
	  
      script.src = 'http://comcat.cr.usgs.gov/fdsnws/event/1/query?starttime='+date+'&minmagnitude='+mag+'&format=geojson&callback=eqfeed_callback&endtime='+enddate+'%2023:59:59&orderby=time-asc'; 
	  //document.getElementById("p1").innerHTML=script.src;
       document.getElementsByTagName('head')[0].appendChild(script); 
      } //assign
	 
    window.eqfeed_callback = function(results)
	  {
	   
      for (var i = 0; i < results.features.length; i++) /*The results are stored in array results and can be accesed via the counter*/
	  { 
       setTimeout(function()
	    {
          addMarker();
        }, i*(1000/document.getElementById('persec').value));//timeout
        } //adding marker fns
		 
	function addMarker() 
	  {
		 var earthquake = results.features[iterator];
         var coords = earthquake.geometry.coordinates;
         var latLng = new google.maps.LatLng(coords[1],coords[0]);
         var marker = new google.maps.Marker
		 ({
            position: latLng,
            map: map,
			title:""+iterator,
			icon: getCircle(earthquake.properties.mag,results.features[iterator].geometry.coordinates[2]) 
			/*To plot the marker as a circle with radius depending on magnitude and colour depending upon depth
			*/
         });//marker 
		iterator++;
		google.maps.event.addListener(marker, 'mouseover', function()/*Adding a eventlistener to add mouseover property*/
		{
	     var marker = this;
         var date = new Date(results.features[marker.title].properties.time);
         infoWindow.setContent('<h3>Earthquake Details</h3><hr>Place:' +results.features[marker.title].properties.place+
	     '<br>Magnitude:'+results.features[marker.title].properties.mag+'<br>Depth:'+results.features[marker.title].geometry.coordinates[2]+'km<br>Date:'+date);
		 /*Writing information in the content window at the call time rather than run time.Increased efficiency and lower use of resources.*/

         infoWindow.open(map, marker);/*CallingFunction to pop up information window*/
        }); 
		/*Printing information about the current earthquake being plotted*/
		 
		  var date = new Date(results.features[iterator].properties.time);
		  document.getElementById("p3").innerHTML=date;
	  
      }//addMarker
      }//results
	  
	  function getCircle(magnitude,depth)
	  {
	  var col;
	  if(depth<70){col="red"}
	  if(depth>=70 && depth <=300){col="yellow";}
	  if(depth>300){col="green";} /*Setting colour of circle marker basedepth*/  
	  return {
              path: google.maps.SymbolPath.CIRCLE,
              fillColor:''+col,
              fillOpacity: .4,
              scale: Math.pow(2, magnitude/1.2) / Math.PI,//radius based on magnitude
              strokeColor: 'blue',
              strokeWeight: .5
             };
  
      }//getCircle
	  var infoWindow = new google.maps.InfoWindow;
	  google.maps.event.addDomListener(window, 'load', initialize);

  
