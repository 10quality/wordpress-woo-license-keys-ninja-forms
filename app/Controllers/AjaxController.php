<?php

namespace WCLKNinjaForms\Controllers;

use Exception;
use WPMVC\Request;
use WPMVC\Response;
use WPMVC\MVC\Controller;
use LicenseKeys\Models\LicenseKey;

/**
 * Configuration hooks.
 *
 * @author 10Quality <info@10quality.com>
 * @license GPLv3
 * @package woo-license-keys-nf
 * @version 1.0.3
 */
class AjaxController extends Controller
{
    /**
     * Handles ajax call.
     * @since 1.0.0
     * 
     * @hook wp_ajax_wclk_ninja_form
     * @hook wp_ajax_nopriv_wclk_ninja_form
     */
    public function get()
    {
        $response = new Response();
        if ( is_user_logged_in() ) {
            try {
                $request = [
                    'code'      => Request::input( 'code', '' ),
                    'limit'     => Request::input( 'limit', 10 ),
                    'page'      => Request::input( 'page', 1 ),
                ];
                $data = [];
                if ( empty( $request['code'] ) ) {
                    $license_keys = LicenseKey::from_user( get_current_user_id() );
                    for ( $i = count( $license_keys )-1; $i >= 0; --$i ) {
                        if ( $license_keys[$i]->is_valid )
                            $data[] = apply_filters( 'woocommerce_license_key', $license_keys[$i] );
                        if ( count( $data ) == $request['limit'] )
                            break;
                    }
                } else {
                    $license_key = wc_find_license_key( $request );
                    if ( $license_key ) {
                        $order = wc_get_order( $license_key->order_id );
                        if ( $order->get_user_id() == get_current_user_id() )
                            $data[] = $license_key;
                    }
                }
                $view = $this->view;
                $response->data = array_map( function( $license_key ) use( &$view ) {
                    $array = [];
                    $array['id'] = $license_key->the_key;
                    $array['text'] = $license_key->the_key;
                    $array['html'] = $view->get( 'fields.woolicensekey-select-option', ['license_key' => &$license_key] );
                    return apply_filters( 'wclk_nf_license_key', $array, $license_key );
                }, $data );
                $response->success = true;
            } catch ( Exception $e ) {
                $response->message = __( 'Error while searching for a license key.', 'woo-license-keys-nf' );
            }
        }
        $response->json();
    }
}