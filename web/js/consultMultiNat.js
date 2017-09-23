function initMap() {
    var markersZone = new google.maps.LatLngBounds();

    var mapDiv = new google.maps.Map( document.getElementById("google-maps"));

    markersTable.forEach(function(latlng){
        var latit = latlng.lat,
            longi = latlng.lng;
        var contentString = '<div id="content" class="text-center">'+
            '<h1 id="firstHeading" class="firstHeading">'+
            nomVern+
            '</h1>'+
            '<div id="bodyContent">'+
            '<p><b>Observé(e) le '+
            date+
            '</b></p>'+
            '<p>par '+
            firstName+
            ' '+
            lastName+
            '</p>'+
            '<p><u>Coordonnées GPS</u> :</p>'+
            '<p>Latitude '+
            lati+
            ' - Longitude '+
            long+
            '</p>'+
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
