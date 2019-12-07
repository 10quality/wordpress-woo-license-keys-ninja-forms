<?php
/**
 * Woo License Key details merge tag for Ninja Form.
 *
 * @author 10Quality <info@10quality.com>
 * @license GPLv3
 * @package woo-license-keys-nf
 * @version 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php if ( $license_key ) : ?>
<table cellpadding="5" cellspacing="0" style="width:100%">
    <tbody>
        <tr>
            <th style="text-align: left; padding: 5px; background-color: #f7f7f7; width: 130px;"><?php _e( 'License Key Code', 'woo-license-keys' ) ?></th>
            <td style="text-align: left; padding: 5px;"><code style="background-color: #FFEBEE;padding: 2px 5px;color: #B71C1C;"><?php echo esc_attr( $license_key->the_key ) ?></code></td>
        </tr>
        <tr>
            <th style="text-align: left; padding: 5px; background-color: #f7f7f7; width: 130px;"><?php _e( 'Product', 'woocommerce' ) ?></th>
            <td style="text-align: left; padding: 5px;"><?php echo esc_attr( $license_key->product->get_name() ) ?></td>
        </tr>
        <tr>
            <th style="text-align: left; padding: 5px; background-color: #f7f7f7; width: 130px;"><?php _e( 'Order', 'woocommerce' ) ?></th>
            <td style="text-align: left; padding: 5px;">#<?php echo esc_attr( $license_key->order_id ) ?></td>
        </tr>
    </tbody>
</table>
<?php endif ?>