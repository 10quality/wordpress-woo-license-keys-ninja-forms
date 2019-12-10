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
    /**
     * Returns plugin meta, adds documentation link.
     * @since 1.0.0
     * 
     * @hook plugin_row_meta
     * 
     * @param array  $classes
     * @param string $file
     * 
     * @return array
     */
    public function row_meta( $meta, $file )
    {
        if ( $file === wclk_ninja_forms()->config->get( 'localize.textdomain' ) . '/plugin.php' )
            $meta['docs'] = '<a href="' . esc_url( 'https://www.10quality.com/docs/woocommerce-license-keys/integrations/ninja-forms/' )
                . '" aria-label="' . esc_attr__( 'Documentation', 'woo-license-keys' ) . '" target="_blank">'
                . esc_html__( 'Documentation', 'woo-license-keys' ) . '</a>';
        return $meta;
    }
}