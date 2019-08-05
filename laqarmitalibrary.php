<?php
/*
Plugin Name: La Qarmita Library Catalogue Plugin
Plugin URI: https://choclomedia.com
Description: This as been made for La Qarmita Library.
Author: Jose Rodriguez
Version: 1.0.0
Author URI: https://choclomedia.com
*/


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


define( 'DO_EVENTS_PLUGIN_DIR', trailingslashit( dirname(__FILE__) ) );
define( 'DO_EVENTS_PLUGIN_URL', plugins_url('', __FILE__) );

function dons_load_textdomain() {
    load_plugin_textdomain( 'does', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}
add_action( 'plugins_loaded', 'dons_load_textdomain' );

function show_company_brand(){
?>
<!-- Choclomedia.com Ecuador -->
<?php
}
add_action('wp_head', 'show_company_brand');

require_once 'backend/lq_cpt_libros.php';
