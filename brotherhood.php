<?php
/*
Plugin Name: Brotherhood
Plugin URI: http://carbolowdrates.com
Description: Demo Music Site
Version: 1
Author: Dave Baker
Author URI: http://www.dave-baker.com
License: GPL

Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : dangerous@scumonline.co.uk)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
session_start();
require_once('inc/includes.php');

DEFINE(DS, DIRECTORY_SEPARATOR);

register_activation_hook( __FILE__, array('Brotherhood', 'install'));
add_action( 'init', array('Brotherhood', 'checkVersionUpgrade') );
add_action('wp', array('Brotherhood', 'addHeaderElements'));

add_shortcode('main_map_shortcode', 'main_map_shortcode');