function initMap() {
    if(navigator.geolocation) {
        function hasPosition(position) {
            var point = new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                myOptions = {
                    zoom: 12,
                    center: point,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                },
                mapDiv = document.getElementById("google-maps"),
                map = new google.maps.Map(mapDiv, myOptions),
                marker = new google.maps.Marker({
                    position: point,
                    map: map
                });

            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(event.latLng);
            });

            var marker;
            function placeMarker(location) {
                if(marker){ //on vérifie si le marqueur existe
                    marker.setPosition(location); //on change sa position
                }else{
                    marker = new google.maps.Marker({ //on créé le marqueur
                        position: location,
                        map: map
                    });
                }
                document.getElementById("oc_platformbundle_observation_latitude").value=location.lat();
                document.getElementById("oc_platformbundle_observation_longitude").value=location.lng();
            }
        }
        navigator.geolocation.getCurrentPosition(hasPosition);
    }
};
