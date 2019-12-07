<?php

namespace WCLKNinjaForms\MergeTags;

use NF_Abstracts_MergeTags;
use WCLKNinjaForms\Fields\WooLicenseKey;

/**
 * Ninja forms license key details merge tag.
 *
 * @author 10Quality <info@10quality.com>
 * @license GPLv3
 * @package woo-license-keys-nf
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
     * Constructor.
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->title = __( 'License Key', 'woo-license-keys-nf' );
        $this->merge_tags = [
            'woolicensekey_details'   => [
                    'id'        => $this->id,
                    'tag'       => '{licensekey:details}',
                    'label'     => __( 'Details', 'woo-license-keys-nf' ),
                    'callback'  => [&$this, 'details_render'],
                ],
        ];
        add_filter( 'ninja_forms_action_email_message', [&$this, 'replace_email_message'], 99, 3 );
    }
    /**
     * Triggers email replacement.
     * @since 1.0.0
     * 
     * @hook ninja_forms_action_email_message
     * 
     * @param string $subject Message.
     * @param array  $data
     * @param array  $action_settings 
     * 
     * @return string
     */
    public function replace_email_message( $subject, $data, $action_settings )
    {
        preg_match_all("/{([^}]*)}/", $subject, $matches );

        if( empty( $matches[0] ) ) return $subject;

        foreach( $this->merge_tags as $merge_tag ){
            if( ! isset( $merge_tag[ 'tag' ] ) || ! in_array( $merge_tag[ 'tag' ], $matches[0] ) ) continue;

            if( ! isset($merge_tag[ 'callback' ])) continue;

            if ( is_callable( array( $this, $merge_tag[ 'callback' ] ) ) ) {
                $replace = $this->{$merge_tag[ 'callback' ]}( $data, $action_settings );
            } elseif ( is_callable( $merge_tag[ 'callback' ] ) ) {
                $replace = $merge_tag[ 'callback' ]( $data, $action_settings );
            } else {
                $replace = '';
            }
            
            $subject = str_replace( $merge_tag[ 'tag' ], $replace, $subject );
        }

        return $subject;
    }
    /**
     * Returns tag value.
     * @since 1.0.0
     * 
     * @param array $data
     * @param array $action_settings
     * 
     * @return string
     */
    public function details_render( $data = null, $action_settings = null )
    {
        if ( $data === null || $action_settings === null )
            return;
        foreach ( $data['fields'] as $id => $field ) {
            if( $field['type'] !== WooLicenseKey::KEY )
                continue;
            $code = $field['value'];
            if ( empty( $code ) )
                break;
            $license_key = wc_find_license_key( ['code' => $code] );
            if ( $license_key ) {
                ob_start();
                wclk_ninja_forms()->view( 'mergetags.woolicensekey_details', ['license_key' => &$license_key] );
                return apply_filters( 'wclk_nf_woolicensekey_details_html', ob_get_clean(), $license_key );
            } else {
                break;
            }
        }
        return '';
    }
}