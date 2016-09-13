;(function($){
    window.Brotherhood = window.Brotherhood || {};

    $(document).on('ready', function(){
        var map = new google.maps.Map($('.main-map').get(0));
        var mapMarkers = [];
        var markerCluster;
        var completeBound = new google.maps.LatLngBounds();;

        var infowindow = new google.maps.InfoWindow({
            'maxWidth': 200
        });

        function showInfoWindow(dataObject, marker){
            var contentString = $('#main-map-infowindow').html();
            infowindow.close();

            var data = {
                name: dataObject.name
            };

            data.address = dataObject.street + "<br />" +
                dataObject.city + ", " + dataObject.state + "<br />" +
                dataObject.zip_code;

            data.social = "<ul class='list-unstyled'>";

            if(dataObject.facebook) {
                data.social += "<li><a href='" + dataObject.facebook + "' class='item accent' target='_blank'><span class='fa fa-facebook-square'></span>Facebook</a></li>";
            }

            if(dataObject.twitter) {
                data.social += "<li><a href='" + dataObject.twitter + "' class='item accent' target='_blank'><span class='fa fa-twitter-square'></span>Twitter</a></li>";
            }

            if(dataObject.website) {
                data.social += "<li><a href='" + dataObject.website + "' class='item accent' target='_blank'><span class='fa fa-heart-o'></span>Website</a></li>";
            }

            data.social += "</ul>";

            for(var i in data){
                var reg = new RegExp("{{" + i + "}}", 'g');
                contentString = contentString.replace(reg, data[i]);
            }

            infowindow.setContent(contentString);
            infowindow.open(map, marker);
        }

        function resetMap(){
            if(!completeBound){
                return;
            }

            map.setCenter(completeBound.getCenter());
            map.setZoom($(window).width() > 640 ? 4 : 2);
        }

        function initMap() {
            if(window.Brotherhood.mapPoints){
                var latLng;

                $('.js-reset-map').on('click', function(){
                    resetMap();
                })

                $(window.Brotherhood.mapPoints).each(function(){
                    var self = this;
                    latLng = new google.maps.LatLng(this.latitude, this.longitude)
                    completeBound.extend(latLng);

                    var marker = new google.maps.Marker({
                        position: latLng,
                        title: this.name
                    });

                    var bandRow = $('#map-band-row').html();
                    bandRow = $(bandRow.replace(/{{name}}/g, this.name));


                    $(bandRow).find('a').on('click', function(ev){

                        ev.preventDefault();
                        infowindow.close();
                        map.setZoom(15);
                        map.setCenter(marker.getPosition());

                        var listener = google.maps.event.addListener(map, 'idle', function(){
                            console.log("idle");
                            showInfoWindow(self, marker);
                            google.maps.event.removeListener(listener);
                            listener = null;
                        });

                        window.setTimeout(function(){

                        }, 100);
                    });

                    $('.js-band-list').append(bandRow);

                    marker.addListener('click', function() {
                       showInfoWindow(self, marker);
                    });

                    mapMarkers.push(marker);
                });

                markerCluster = new MarkerClusterer(map, mapMarkers, {imagePath: window.Brotherhood.imageBase});

                google.maps.event.addDomListener(window, "resize", function() {
                    var center = map.getCenter();
                    google.maps.event.trigger(map, "resize");
                    map.setCenter(center);
                });

                resetMap();


            }

        }

        // Add Events
        $('.frontpage-banner .btn-ember').on('click', function(){
            $('body, html').animate({
                scrollTop: $('.basic-content').offset().top - $('#menu_row').height()
            }, {
                duration: 750
            })
        });

        initMap();
    });
}(jQuery));