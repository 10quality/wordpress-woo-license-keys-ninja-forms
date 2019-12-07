<?php

namespace WCLKNinjaForms\MergeTags;

use NF_Abstracts_MergeTags;
use WCLKNinjaForms\Fields\WooLicenseKey;

/**
 * Ninja forms license key details merge tag.
 *
 * @author 10Quality <info@10quality.com>
 * @license GPLv3
 * @package woo-license-keys-ninja-forms
 * @version 1.0.0
 */
final class WooLicenseKeyDetails extends NF_Abstracts_MergeTags
{
    /**
     * Merge tag key name.
     * @since 1.0.0
     * @var string
     */
    const KEY = 'woolicensekey_mergetags';
    /**
     * Merge tag id.
     * @since 1.0.0
     * @var string
     */
    protected $id = self::KEY;
    /**
     * Form ID.
     * @since 1.0.0
     * @var int
     */
    protected $form_id;
    /**
     * Submission.
     * @since 1.0.0
     * @var object
     */
    protected $submission;
    /**
     * Constructor.
     * @since 1.0.0
     */
    public function __construct()
    {
        parent::__construct();
        $this->title = __( 'License Key', 'woo-license-keys-ninja-forms' );
        $this->merge_tags = [
            'woolicensekey_details'   => [
                    'id'        => $this->id,
                    'tag'       => '{licensekey:details}',
                    'label'     => __( 'Details', 'woo-license-keys-ninja-forms' ),
                    'callback'  => [&$this, 'details_render'],
                ],
        ];
        add_action( 'nf_get_form_id', [&$this, 'set_form_id' ], 15, 1 );
        add_action( 'ninja_forms_save_sub', [&$this, 'set_submission' ] );
    }
    /**
     * Sets form id.
     * @since 1.0.0
     * 
     * @hook nf_get_form_id
     * 
     * @param int $form_id
     */
    public function set_form_id( $form_id )
    {
        vdump_and_die($form_id);
        $this->form_id = $form_id;
    }
    /**
     * Sets submission object.
     * @since 1.0.0
     * 
     * @hook ninja_forms_save_sub
     * 
     * @param int $sub_id
     */
    public function set_submission( $sub_id )
    {
        $this->submission = Ninja_Forms()->form()->sub( $sub_id )->get();
    }
    /**
     * Returns tag value.
     * @since 1.0.0
     * 
     * @return string
     */
    public function details_render()
    {
        return;
        foreach( Ninja_Forms()->form()->get_fields() as $field ) {
            $settings = $field->get_settings();
            if( $settings['type'] !== WooLicenseKey::KEY )
                continue;
            $code = apply_filters(
                'ninja_forms_merge_tag_value_' . $settings['type'],
                null,
                $field
            );
            $license_key = wc_find_license_key( ['code' => $code] );
            if ( $license_key ) {
                ob_start();
                wclk_ninja_forms()->view( 'mergetags.woolicensekey_details', ['license_key' => &$license_key] );
                return apply_filters( 'wclk_nf_woolicensekey_details_html', ob_get_clean(), $license_key );
            } else {
                break;
            }
        }
        return;
    }
}