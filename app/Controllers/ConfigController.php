<?php

namespace WCLKNinjaForms\Controllers;

use WPMVC\MVC\Controller;

/**
 * Configuration hooks.
 *
 * @author 10Quality <info@10quality.com>
 * @license GPLv3
 * @package woo-license-keys-nf
 * @version 1.0.0
 */
class ConfigController extends Controller
{
    /**
     * Registers assets.
     * @since 1.0.0
     * 
     * @hook wp_enqueue_scripts
     */
    public function register_assets()
    {
        wp_register_script(
            'wclk-ninja-forms',
            assets_url( 'js/app.js', __DIR__ ),
            ['select2'],
            wclk_ninja_forms()->config->get( 'version' ),
            true
        );
        wp_register_style(
            'wclk-ninja-forms',
            assets_url( 'css/app.css', __DIR__ ),
            ['select2'],
            wclk_ninja_forms()->config->get( 'version' )
        );
    }
}