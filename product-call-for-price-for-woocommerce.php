<?php 
/**
* Plugin Name: Product Call For Price For Woocommerce
* Description: This plugin replace Call for Price when price field for product is left empty.
* Version: 1.0
* Copyright: 2022
* Text Domain: product-call-for-price-for-woocommerce
*/


if (!defined('ABSPATH')) {
    die('-1');
}

// define for base name
define('PCFPFW_BASE_NAME', plugin_basename(__FILE__));

// define for plugin file
define('pcfpfw_plugin_file', __FILE__);


if (!defined('PCFPFW_PLUGIN_URL')) {
    define('PCFPFW_PLUGIN_URL',plugins_url('', __FILE__));
}
if (!defined('PCFPFW_PLUGIN_DIR')) {
    define('PCFPFW_PLUGIN_DIR', plugin_dir_path(__FILE__));
}


// Include function files
include_once(PCFPFW_PLUGIN_DIR.'includes/frontend.php');
include_once(PCFPFW_PLUGIN_DIR.'includes/admin.php');

function PCFPFW_load_admin_script(){
    wp_enqueue_style( 'jquery-admin-style', PCFPFW_PLUGIN_URL. '/admin/css/design.css', '', '1.0' );
}
add_action( 'admin_enqueue_scripts', 'PCFPFW_load_admin_script' );
?>