<?php
class Brotherhood_Importer
{
    const DATA_INSTALLED_KEY = "data_installed";

    public function installData()
    {
        global $wpdb;

        if(Brotherhood::getOption(self::DATA_INSTALLED_KEY) == false) {
            $wpdb->query("INSERT INTO `bh_brotherhood_band` (`name`, `street`, `city`, `state`, `zip_code`, `facebook`, `twitter`, `website`, `gig_dates`, `interview`, `latitude`, `longitude`)
            VALUES
            ('Van Halst', 'Thornton Ct', 'Edmonton', 'AB', 'T5J 2E7', 'https://www.facebook.com/vanhalstmusic/', 'https://twitter.com/vanhalstband', 'http://vanhalstmusic.com/', NULL, NULL, NULL, NULL),
                ('Divinity', '9th Avenue', 'Calgary', 'AB', 'AB T2G', 'https://www.facebook.com/divinitymetal', NULL, 'http://www.divinity.ca/', NULL, NULL, NULL, NULL),
                ('Mountain Man', 'Denman Street', 'Vancouver', 'BC', 'V6G 2L7', 'https://www.facebook.com/mountainmanmetal/', 'https://twitter.com/we_are_mtn_man', 'https://mountainmanmetal.bandcamp.com/', NULL, NULL, NULL, NULL),
                ('Celestial Ruin', 'W Pender Street', 'Vancouver', 'BC', 'V6B 1W7', 'https://www.facebook.com/celestialruincanada/', 'https://twitter.com/celestialruin?lang=en', 'http://celestialruin.com/', NULL, NULL, NULL, NULL),
                ('Demise of The Crown', 'Rue Nobel', 'Montreal', 'QC', 'J4B 5H1', 'https://www.facebook.com/Demise-of-the-Crown-58357974949/', NULL, NULL, NULL, NULL, NULL, NULL),
                ('Exes for Eyes', 'Yonge Street', 'Toronto', 'ON', 'M4Y 1X7', 'https://www.facebook.com/ExesForEyesMusic', 'https://twitter.com/exes_for_eyes', 'http://www.exesforeyes.com', NULL, NULL, NULL, NULL),
                ('Medevil', 'Hornby Street', 'Vancouver', 'BC', 'V6Z 1V3', 'https://www.facebook.com/medevilband', 'https://twitter.com/medevilmusic', 'http://www.medevilmusic.com/', NULL, NULL, NULL, NULL),
                ('Striker', '100A St', 'Edmonton', 'AB', 'AB T57', 'https://www.facebook.com/strikermetal', 'https://twitter.com/strikermetal?lang=en-gb', 'http://www.striker-metal.com/band/', NULL, NULL, NULL, NULL),
                ('A Rebel Few', 'Ainslie St', 'Cambridge', 'ON', 'N1R 3J6', 'https://www.facebook.com/arebelfew/', 'https://twitter.com/arebelfew', 'http://www.arebelfew.com/', NULL, NULL, NULL, NULL),
                ('A Devil’s Sin', 'Sherbrooke Est', 'Montreal', 'QC', 'H1N 1C9', NULL, NULL, NULL, NULL, NULL, NULL, NULL);");

            Brotherhood::updateOption(self::DATA_INSTALLED_KEY, 1);
        }

        self::updateLatLngs();
    }

    public function updateLatLngs()
    {
        global $wpdb;

        $bands = $wpdb->get_results(
            $sql = "SELECT * FROM `" . Brotherhood::getBandTableName() . "`",
            ARRAY_A
        );

        foreach($bands as $band){
            self::updateLatLng($band);
            sleep(2);
        }
    }

    /* Get the latitude & longitude of each address */
    public function updateLatLng($row)
    {
        global $wpdb;
        $row['country'] = 'Canada';

        $dataUrl = urlencode(preg_replace("/\s+/", " ", $row['street'] . " " . $row['city']." ".$row['state']." ".$row['zip_code'] . " " . $row['country']));
        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $dataUrl . "&sensor=false";

        $latLng = json_decode(file_get_contents($url),true);

        if(!isset($latLng['results'])) {
            return;
        }

        foreach($latLng['results'] as $res){
            if(!isset($res['geometry']['location'])) {
                continue;
            }

            $lat = $res['geometry']['location']['lat'];
            $lng = $res['geometry']['location']['lng'];

            $wpdb->update(
                Brotherhood::getBandTableName(),
                array(
                    'latitude' => $lat,
                    'longitude' => $lng
                ),
                array(
                    'id' => $row['id']
                )
            );
        }

    }


}