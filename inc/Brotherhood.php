<?php
class Brotherhood
{
    const version = "1.00";
    const prefixId = "brotherhood_demo__";
    const versionKey = "version";
    const MAPS_API_KEY = "AIzaSyA7vIFU3dUCzjuM8BqXX0Fxj_3x7fvlei4";

    public static function install()
    {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        global $wpdb;

        // INSTALL PROCEDURE
        dbDelta($sql = "CREATE TABLE `" . self::getBandTableName() . "` (
          id int(11) unsigned NOT NULL AUTO_INCREMENT,
          name varchar(255) DEFAULT NULL,
          street varchar(255) DEFAULT NULL,
          city varchar(255) DEFAULT NULL,
          state varchar(255) DEFAULT NULL,
          zip_code varchar(255) DEFAULT NULL,
          facebook varchar(255) DEFAULT NULL,
          twitter varchar(255) DEFAULT NULL,
          website varchar(255) DEFAULT NULL,
          gig_dates text,
          interview text,
          latitude decimal(10,8) DEFAULT NULL,
          longitude decimal(11,8) DEFAULT NULL,
          PRIMARY KEY  (id),
          KEY latlong (latitide,longitude)
        )");

        Brotherhood_Importer::installData();


        self::updateOption("version", self::version);
    }

    public static function getBandTableName()
    {
        global $wpdb;
        return $wpdb->base_prefix . "brotherhood_band";
    }

    public function getAllBands()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM `" . self::getBandTableName() . "`");
    }

    public function getAllBandsJSON()
    {
        return json_encode(self::getAllBands());
    }

    public static function checkVersionUpgrade()
    {
        $installedVersion = self::getOption(self::versionKey);

        if($installedVersion !== self::version){
            self::install();
        }
    }

    public static function getOptionKey($option)
    {
        return self::prefixId . $option;
    }

    public static function getOption($option, $default = null)
    {
        return get_option(self::prefixId . $option, $default);
    }

    public static function updateOption($option, $value)
    {
        update_option(self::prefixId . $option, $value);
    }

    public static function addHeaderElements()
    {
        wp_enqueue_script('googlemaps', "https://maps.googleapis.com/maps/api/js?key=" . self::MAPS_API_KEY . "&callback=initMap");
        wp_enqueue_script('googlemarkercluster', plugins_url('js/MarkerCluster.js', dirname(__FILE__)), array('googlemaps'));
        wp_enqueue_script('custom-map', plugins_url('js/map.js', dirname(__FILE__)), array('jquery'));
    }
}