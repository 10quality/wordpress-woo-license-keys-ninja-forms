<?php
/*
Plugin Name: License Keys (Forms integration)
Description: Ninja Forms integration with License Keys for WooCommerce.
Plugin URI: https://github.com/10quality/wordpress-woo-license-keys-ninja-forms
Version: 1.0.3
Author: 10 Quality
Author URI: https://www.10quality.com/
Text Domain: woo-license-keys-nf
Domain Path: /assets/lang/

WC requires at least: 3
WC tested up to: 4.0

See "LICENSE" file.
*/
require_once( __DIR__ . '/app/Boot/bootstrap.php' );
// --
// Special load
// --
add_action( 'plugins_loaded', [&$wclkninjaforms, '_c_return_NinjaFormsController@on_load'], 1 );