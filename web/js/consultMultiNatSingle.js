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
        '<h5><b>COORDONNÉES GPS :</b></h5>'+
        '<p>Latitude <b>'+
        lati+
        '</b> - Longitude <b>'+
        long+
        '</b></p>'+
        '<br />'+
        '<p><a class="naoLink" href="'+
        path+
        '">Accéder à la fiche détaillée de cette observation</a></p>'
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
