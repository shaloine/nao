function initMap() {
    var center = {
        lat: lati,
        lng: long
    };

    var mapOptions = {
        center: center,
        zoom: 10
    };

    var map = new google.maps.Map(document.getElementById('google-maps'), mapOptions);

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

    var mark = [
        {lat: lati, lng: long}
    ];

    var latLng = new google.maps.LatLng(lati, long);
    var marker = new google.maps.Marker({
        position: latLng,
        map: map
    });

    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });
};
