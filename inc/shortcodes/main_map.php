<?php function main_map_shortcode(){?>
    <div class="main-map">

    </div>

    <script>
        ;(function($){
            window.Brotherhood = window.Brotherhood || {};
            window.Brotherhood.mapPoints = <?php echo Brotherhood::getAllBandsJSON();?>;
            window.Brotherhood.imageBase = <?php echo json_encode(plugins_url('images/m', dirname(__DIR__)))?>;
        }(jQuery));
    </script>

    <script type="text/html" id="main-map-infowindow">
        <div class="content">
            <h4 class="heading">{{name}}</h4>
            <div class="address">{{address}}</div>
            <div class="social">{{social}}</div>
        </div>
    </script>

<?php } ?>