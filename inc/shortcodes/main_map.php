<?php function main_map_shortcode(){?>
    <div class="map-container">
        <div class="main-map">

        </div>

        <div class="band-list">
            <div class="band-inner">
            <ul class="bands js-band-list">

            </ul>
        </div>
            <div class="utils">
                <a class="js-reset-map btn btn-ember btn-block">Reset Map</a>
            </div>
        </div>
    </div>



    <script>
        ;(function($){
            window.Brotherhood = window.Brotherhood || {};
            window.Brotherhood.mapPoints = <?php echo Brotherhood::getAllBandsJSON();?>;
            window.Brotherhood.imageBase = <?php echo json_encode(plugins_url('images/m', dirname(__DIR__)))?>;
        }(jQuery));
    </script>

    <script type="text/html" id="main-map-infowindow">
        <div class="map-info-content">
            <h4 class="heading">{{name}}</h4>
            <div class="address">{{address}}</div>
            <div class="social">{{social}}</div>
        </div>
    </script>

    <script type="text/html" id="map-band-row">
        <li class="band-item">
            <a href="#">{{name}}</a>
        </li>
    </script>

<?php } ?>