;(function($){
    window.Brotherhood = window.Brotherhood || {};

    $(document).on('ready', function(){
        function initMap() {
            var map = new google.maps.Map($('.main-map').get(0));

            var infowindow = new google.maps.InfoWindow({
                'maxWidth': 200
            });

            if(window.Brotherhood.mapPoints){
                var bound = new google.maps.LatLngBounds();
                var latLng;
                var markers = [];

                $(window.Brotherhood.mapPoints).each(function(){
                    var self = this;
                    latLng = new google.maps.LatLng(this.latitude, this.longitude)
                    bound.extend(latLng);

                    var marker = new google.maps.Marker({
                        position: latLng,
                        title: this.name
                    });

                    marker.addListener('click', function() {
                        var contentString = $('#main-map-infowindow').html();



                        var data = {
                            name: self.name
                        };

                        data.address = self.street + "<br />" +
                                self.city + ", " + self.state + "<br />" +
                                self.zip_code;

                        data.social = "";

                        

                        for(var i in data){
                            console.log(data);
                            var reg = new RegExp("{{" + i + "}}", 'g');
                            contentString = contentString.replace(reg, data[i]);
                        }

                        infowindow.setContent(contentString);
                        infowindow.open(map, marker);
                    });

                    markers.push(marker);
                });

                new MarkerClusterer(map, markers, {imagePath: window.Brotherhood.imageBase});

                map.setCenter(bound.getCenter());
                map.setZoom(4);
            }

        }

        initMap();
    });
}(jQuery));