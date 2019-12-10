<?php

namespace WCLKNinjaForms\Controllers;

use WPMVC\MVC\Controller;
use WCLKNinjaForms\Fields\WooLicenseKey;
use WCLKNinjaForms\MergeTags\WooLicenseKeyDetails;

/**
 * Ninja forms realted hooks.
 *
 * @author 10Quality <info@10quality.com>
 * @license GPLv3
 * @package woo-license-keys-nf
 * @version 1.0.0
 */
class NinjaFormsController extends Controller
{
    /**
     * Special load, outside WPMVC framework, to prioritize
     * some Ninja Forms registrations.
     * @since 1.0.0
     * 
     * @hook plugins_loaded
     */
    public function on_load()
    {
        add_filter( 'ninja_forms_field_template_file_paths', [&$this, 'register_template_paths'] );
        add_filter( 'ninja_forms_register_fields', [&$this, 'register_fields'] );
        add_filter( 'ninja_forms_loaded', [&$this, 'register_mergetags'] );
    }
    /**
     * Returns list of available template paths.
     * @since 1.0.0
     * 
     * @hook ninja_forms_field_template_file_paths
     * 
     * @param array $paths
     * 
     * @return array
     */
    public function register_template_paths( $paths )
    {
        $paths[] = wclk_ninja_forms()->config->get( 'paths.templates' );
        return $paths;
    }
    /**
     * Registers merge tags.
     * @since 1.0.0
     * 
     * @hook ninja_forms_loaded
     */
    public function register_mergetags()
    {
        Ninja_Forms()->merge_tags[WooLicenseKeyDetails::KEY] = new WooLicenseKeyDetails();
    }
    /**
     * Returns list of available fields.
     * @since 1.0.0
     * 
     * @hook ninja_forms_register_fields
     * 
     * @param array $fields
     * 
     * @return array
     */
    public function register_fields( $fields )
    {
        $fields[WooLicenseKey::KEY] = new WooLicenseKey;
        return $fields;
    }
    /**
     * Enqueues front end assets.
     * @since 1.0.0
     * @hook ninja_forms_enqueue_scripts
     * 
     * @param array $args Ninja form arguments.
     */
    public function enqueue_scripts( $args )
    {
        if ( array_key_exists( 'form_id', $args ) ) {
            $fields = Ninja_Forms()->form( $args['form_id'] )->get_fields();
            foreach ( $fields as $field ) {
                $settings = $field->get_settings();
                if ( $settings['type'] === WooLicenseKey::KEY ) {
                    wp_enqueue_style( 'wclk-ninja-forms' );
                    wp_enqueue_script( 'wclk-ninja-forms' );
                    wp_add_inline_script(
                        'wclk-ninja-forms',
                        $this->view->get(
                            'fields.woolicensekey-inline-script',
                            ['data' => apply_filters( 'wclk_nf_woolicensekey_js_data', [
                                'ajax'          => is_user_logged_in(),
                                'ajax_url'      => is_user_logged_in() ? admin_url( 'admin-ajax.php' ) : false,
                                'ajax_action'   => is_user_logged_in() ? 'wclk_ninja_form' : false,
                                'min_length'    => null,
                                'lang'          => [
                                                    'placeholder'       => empty( $settings['placeholder'] )
                                                        ? ( is_user_logged_in()
                                                            ? __( 'Type to search for a license key...', 'woo-license-keys-nf' )
                                                            : __( 'Type your license key...', 'woo-license-keys-nf' )
                                                        )
                                                        : $settings['placeholder'],
                                                    'inputTooShort'     => __( 'Type more characters', 'woo-license-keys-nf' ),
                                                    'inputTooLong'      => __( 'Type less characters', 'woo-license-keys-nf' ),
                                                    'errorLoading'      => __( 'Error loading license keys', 'woo-license-keys-nf' ),
                                                    'loadingMore'       => __( 'Loading more license keys', 'woo-license-keys-nf' ),
                                                    'noResults'         => __( 'No license keys found in account', 'woo-license-keys-nf' ),
                                                    'searching'         => __( 'Searching...', 'woo-license-keys-nf' ),
                                                    'maximumSelected'   => __( 'Error loading license keys', 'woo-license-keys-nf' ),
                                                ],
                            ] ) ]
                        ),
                        'before'
                    );
                    break;
                }
            }
        }
    }
}