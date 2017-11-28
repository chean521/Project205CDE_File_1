/*
 * Google Maps API
 */

window.onload(GetMap(5.341791,100.282081,'googleMap'));

function GetMap(latitude,longitude,container_id)
{
    var myCenter = new google.maps.LatLng(latitude,longitude);
    var mapCanvas = document.getElementById(container_id);
    var mapOptions = {center: myCenter, zoom: 17};
    var map = new google.maps.Map(mapCanvas, mapOptions);
    var marker = new google.maps.Marker({position:myCenter});
    marker.setMap(map);
}