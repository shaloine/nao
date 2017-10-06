function initMap() {
    var center = {
        lat: lati,
        lng: long
    };

    var mapOptions = {
        center: center,
        zoom: 9
    };

    var map = new google.maps.Map(document.getElementById('google-maps'), mapOptions);

    var opt = { minZoom: 6, maxZoom: 9 };
    map.setOptions(opt);

    for (var observation in map) {
        var observationCircle = new google.maps.Circle({
            strokeColor: '#017A74',
            strokeOpacity: 0.015,
            strokeWeight: 2,
            fillColor: '#017A74',
            fillOpacity: 0.015,
            map: map,
            center: center,
            radius: 5000
        });
    }
};
