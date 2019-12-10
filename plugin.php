<?php
/*
Plugin Name: License Keys (Forms integration)
Description: Ninja Forms integration with License Keys for WooCommerce.
Version: 1.0.0
Author: 10 Quality
Author URI: https://www.10quality.com/

WC requires at least: 3
WC tested up to: 3.8.1
*/
require_once( __DIR__ . '/app/Boot/bootstrap.php' );
// --
// Special load
// --
add_action( 'plugins_loaded', [&$wclkninjaforms, '_c_return_NinjaFormsController@on_load'], 1 );