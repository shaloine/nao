function initMap() {
    var center = {
        lat: lati + 0.05,
        lng: long + 0.05
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
            strokeColor: '#FF0000',
            strokeOpacity: 0.5,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.01,
            map: map,
            center: center,
            radius: 5000
        });
    }
};
