



function initMap() {
 

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 11,
    center: new google.maps.LatLng(45.512090, -73.550979),
    mapTypeId: 'roadmap'
  });
var infoWindow = new google.maps.InfoWindow();

downloadUrl("ajaxControler.php", function(data) {
  var xml = data.responseXML;
  var markers = xml.documentElement.getElementsByTagName("marker");
  for (var i = 0; i < markers.length; i++) {
    var name = markers[i].getAttribute("name");
    var photo = markers[i].getAttribute("photo");
    var urlTest = markers[i].getAttribute("urlTest");
    var url = markers[i].getAttribute("url");
  
    var point = new google.maps.LatLng(
        parseFloat(markers[i].getAttribute("lat")),
        parseFloat(markers[i].getAttribute("lng")));
    var html = "<b>" + name + "</b> <br/>"+ "<a href='"+urlTest+"'><img src='"+photo+"'alt='Porte de jour' width:'304px' height:'228px'></a>";
     
   
    var marker = new google.maps.Marker({
      map: map,
      position: point,
      
    });
    bindInfoWindow(marker, map, infoWindow, html);
  }
});
}

 function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

 function downloadUrl(url,callback) {
 var request = window.ActiveXObject ?
     new ActiveXObject('Microsoft.XMLHTTP') :
     new XMLHttpRequest;

 request.onreadystatechange = function() {
   if (request.readyState == 4) {
     request.onreadystatechange = doNothing;
     callback(request, request.status);
   }
 };

 request.open('GET', url, true);
 request.send(null);
}
 function doNothing() {}

   