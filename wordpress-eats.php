<?php
/*
 * Plugin Name:       WordPress Eats
 * Plugin URI:        https://zagroba.eu/
 * Description:       Start using WordPress as your online Food Merchant
 * Version:           0.1.0
 * Requires at least: 4.7
 * Requires PHP:      7.0
 * Author:            Adam Zagroba
 * Author URI:        https://zagroba.eu/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-eats
 * Domain Path:       /languages
 */

DEFINE('WP_EATS_DIR', __DIR__);
DEFINE('WP_EATS_URL', plugin_dir_url(__FILE__) );
DEFINE('WP_EATS_VERSION', '0.1.0' );

require_once "setup.php";