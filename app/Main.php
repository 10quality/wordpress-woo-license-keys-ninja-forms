<?php

namespace WCLKNinjaForms;

use WPMVC\Bridge;

/**
 * Main class.
 * Bridge between Wordpress and App.
 * Class contains declaration of hooks and filters.
 *
 * @author Cami M
 * @copyright 10Quality <info@10quality.com>
 * @license GPLv3
 * @package woo-license-keys-ninja-forms
 * @version 1.0.0
 */
class Main extends Bridge
{
    /**
     * Declaration of public wordpress hooks.
     */
    public function init()
    {
        $this->add_action( 'wp_enqueue_scripts', 'ConfigController@register_assets' );
        $this->add_action( 'ninja_forms_enqueue_scripts', 'NinjaFormsController@enqueue_scripts' );
        // AJAX
        $this->add_action( 'wp_ajax_wclk_ninja_form', 'AjaxController@get' );
        $this->add_action( 'wp_ajax_nopriv_wclk_ninja_form', 'AjaxController@get' );
    }
    /**
     * Declaration of admin only wordpress hooks.
     * For Wordpress admin dashboard.
     */
    public function on_admin()
    {
    }
}