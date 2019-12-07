<?php
/*
Plugin Name: Integration - Ninja Forms and License Keys for WooCommerce
Description: Ninja Forms integration with License Keys for WooCommerce.
Version: 1.0.0
Author: 10 Quality
Author URI: https://www.10quality.com/
*/
require_once( __DIR__ . '/app/Boot/bootstrap.php' );
// --
// Special load
// --
add_action( 'plugins_loaded', [&$wclkninjaforms, '_c_return_NinjaFormsController@on_load'], 1 );