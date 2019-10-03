<?php

/**
 * Plugin Name:       WooCommerce Category Tree
 * Description:       Displays three-level deep category tree widget for WooCommerce
 * Version:           1.0.0
 * Author:            Blaz K. - BlazzDev
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WCT_PATH', plugin_dir_path( __FILE__ ) );
define( 'WCT_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'WCT_VERSION', '1.0.0' );

// REQUIRE FUNCTIONS
require_once WCT_PATH . 'includes/functions.php';

// REQUIRE WIDGET
require_once WCT_PATH . 'includes/woocommerce-category-tree-widget.php';

// INCLUDE ASSETS
add_action( 'wp_enqueue_scripts', 'wct_assets' );

// ADD SHORTCODE
add_shortcode( 'wct', 'wct_display_category_tree' );

// REGISTER WIDGET
add_action( 'widgets_init', 'wct_register_widget' );
