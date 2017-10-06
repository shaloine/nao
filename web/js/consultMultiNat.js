function initMap() {
    var markersZone = new google.maps.LatLngBounds();

    var map = new google.maps.Map(document.getElementById("google-maps"));

    var markers      = [];

    for(var i = 0; i < markersTable.length; i++ ) {
        var nomVern     = markersTable[i][0],
            date        = markersTable[i][1],
            firstName   = markersTable[i][2],
            lastName    = markersTable[i][3],
            lati        = markersTable[i][4],
            long        = markersTable[i][5],
            path        = markersTable[i][6];
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
        var image = {
            url: '../img/marker.png'
        };
        var markerOptions = {
            map: map,
            position: new google.maps.LatLng(lati, long),
            icon: image,
            info: contentString
        };
        var marker = new google.maps.Marker(markerOptions);
        markers.push(marker);
        marker.addListener('click', function () {
            infowindow.setContent( this.info );
            infowindow.open(map, this);
        });
        markersZone.extend(marker.getPosition());
    }

    var options = {
        imagePath: '../img/m'
    };

    var markerCluster = new MarkerClusterer(map, markers, options);

    map.fitBounds(markersZone);
}
