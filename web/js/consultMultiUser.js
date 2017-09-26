function initMap() {
    var circlesZone = new google.maps.LatLngBounds();

    var map = new google.maps.Map(document.getElementById("google-maps"));

    var opt = {minZoom: 6, maxZoom: 9};
    map.setOptions(opt);

    circlesTable.forEach(function (latlng) {
        var latit = latlng.lat,
            longi = latlng.lng;
        var center = new google.maps.LatLng(latit, longi);
        var circleOptions = {
            strokeColor: '#FF0000',
            strokeOpacity: 0.5,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.5,
            map: map,
            center: center,
            radius: 5000
        };
        var circle = new google.maps.Circle(circleOptions);
        circlesZone.extend(circle.getCenter());
    })

    map.fitBounds(circlesZone);
};
