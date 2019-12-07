<?php

namespace WCLKNinjaForms\Controllers;

use WPMVC\MVC\Controller;
use WCLKNinjaForms\Fields\WooLicenseKey;

/**
 * Ninja forms realted hooks.
 *
 * @author 10Quality <info@10quality.com>
 * @license GPLv3
 * @package woo-license-keys-ninja-forms
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
     * @hook ninja_forms_enqueue_scripts
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
                            'field-woolicensekey-inline-script',
                            ['data' => apply_filters( 'wclk_nf_woolicensekey_js_data', [
                                'ajax'          => is_user_logged_in(),
                                'ajax_url'      => is_user_logged_in() ? admin_url( 'admin-ajax.php' ) : false,
                                'ajax_action'   => is_user_logged_in() ? 'wclk_ninja_form' : false,
                                'min_length'    => null,
                                'lang'          => [
                                                    'placeholder'       => empty( $settings['placeholder'] )
                                                        ? ( is_user_logged_in()
                                                            ? __( 'Type to search for a license key.', 'woo-license-keys-ninja-forms' )
                                                            : __( 'Type your license key.', 'woo-license-keys-ninja-forms' )
                                                        )
                                                        : $settings['placeholder'],
                                                    'inputTooShort'     => __( 'Type more characters', 'woo-license-keys-ninja-forms' ),
                                                    'inputTooLong'      => __( 'Type less characters', 'woo-license-keys-ninja-forms' ),
                                                    'errorLoading'      => __( 'Error loading license keys', 'woo-license-keys-ninja-forms' ),
                                                    'loadingMore'       => __( 'Loading more license keys', 'woo-license-keys-ninja-forms' ),
                                                    'noResults'         => __( 'No license keys found', 'woo-license-keys-ninja-forms' ),
                                                    'searching'         => __( 'Searching...', 'woo-license-keys-ninja-forms' ),
                                                    'maximumSelected'   => __( 'Error loading license keys', 'woo-license-keys-ninja-forms' ),
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