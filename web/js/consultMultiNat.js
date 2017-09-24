function initMap() {
    var markersZone = new google.maps.LatLngBounds();

    var mapDiv = new google.maps.Map( document.getElementById("google-maps"));

    markersTable.forEach(function(latlng){
        var latit = latlng.lat,
            longi = latlng.lng;
        var contentString = '<div id="content" class="text-center">'+
            '<h3 id="firstHeading" class="firstHeading mb-20">'+
            nomVern+
            '</h3>'+
            '<div id="bodyContent">'+
            '<h5><b>OBSERVATION</b></h5><p>Le <b>'+
            date+
            '</b>'+
            ' par <b>'+
            firstName+
            ' '+
            lastName+
            '</b></p><br>'+
            '<h5><b>COORDONÉES GPS :</b></h5>'+
            '<p>Latitude <b>'+
            latit+
            '</b> - Longitude <b>'+
            longi+
            '</b></p>'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        var markerOptions = {
            map: mapDiv,
            position: new google.maps.LatLng(latit, longi)
        };
        var marker = new google.maps.Marker(markerOptions);
        marker.addListener('click', function() {
            infowindow.open(mapDiv, marker);
        });
        markersZone.extend(marker.getPosition());
    })
    mapDiv.fitBounds(markersZone);
};
