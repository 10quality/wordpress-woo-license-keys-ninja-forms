<?php
/**
 * Woo License Key Ninja Form select option.
 *
 * @author 10Quality <info@10quality.com>
 * @license GPLv3
 * @package woo-license-keys-nf
 * @version 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?><div><strong><?php echo esc_attr( $license_key->the_key ) ?></strong></div>
<div>
    <span><?php echo esc_attr( $license_key->product->get_name() ) ?></span>
    <span> | </span>
    <span><i><?php _e( 'Order', 'woocommerce' ) ?> #<?php echo esc_attr( $license_key->order_id ) ?></i></span>
</div>
