<?php
class Brotherhood
{
    const version = "1.00";
    const prefixId = "brotherhood_demo__";
    const versionKey = "version";

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

    public static function getBandTableName(){
        global $wpdb;
        return $wpdb->base_prefix . "brotherhood_band";
    }

    public static function checkVersionUpgrade(){
        $installedVersion = self::getOption(self::versionKey);

        if($installedVersion !== self::version){
            self::install();
        }
    }

    public static function getOptionKey($option){
        return self::prefixId . $option;
    }

    public static function getOption($option, $default = null){
        return get_option(self::prefixId . $option, $default);
    }

    public static function updateOption($option, $value){
        update_option(self::prefixId . $option, $value);
    }
}