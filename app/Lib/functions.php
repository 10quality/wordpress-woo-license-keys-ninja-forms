<?php
/**
 * Global functions.
 *
 * @author 10Quality <info@10quality.com>
 * @license GPLv3
 * @package woo-license-keys-nf
 * @version 1.0.0
 */

if ( ! function_exists( 'wclk_ninja_forms' ) ) {
    /**
     * Returns bridge class.
     * @since 1.0.0
     * 
     * @return \WCLKNinjaForms\Main
     */
    function wclk_ninja_forms()
    {
        return get_bridge( 'WCLKNinjaForms' );
    }
}