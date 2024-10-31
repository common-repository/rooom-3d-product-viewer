<?php
/**
 * Plugin Name: rooom 3D Product Viewer
 * Plugin URI: https://www.rooom.com/
 * Description: Present your products in 3D, AR and VR.
 * Version: 1.1.2
 * Author: rooom
 * Author URI: https://rooom.com/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: rooom-3d-product-viewer
 * Domain Path: /languages
 *
 * @package rooom 3D Product Viewer
 **/

defined( 'ABSPATH' ) || exit;


/**
 * Function for delaying initialization of the extension until after WooCommerce is loaded.
 */
function rooom_3d_plugin_viewer_initialize() {
	include_once plugin_dir_path( __FILE__ ) . 'includes/class-rooom-product-viewer.php';

	$GLOBALS['my_extension'] = Rooom_Product_Viewer::instance();
}
add_action( 'plugins_loaded', 'rooom_3d_plugin_viewer_initialize', 10 );

/**
 * Add translations.
 */
function rooom_load_textdomain() {
	load_plugin_textdomain( 'rooom-3d-product-viewer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'rooom_load_textdomain' );
