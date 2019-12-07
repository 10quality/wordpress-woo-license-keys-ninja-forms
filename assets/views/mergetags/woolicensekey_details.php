<?php
/**
 * Woo License Key details merge tag for Ninja Form.
 *
 * @author 10Quality <info@10quality.com>
 * @license GPLv3
 * @package woo-license-keys-ninja-forms
 * @version 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php if ( $license_key ) : ?>
<table style="width:100%">
    <tbody>
        <tr>
            <th><?php _e( 'Code' ) ?></th>
            <td><code><?php echo esc_attr( $license_key->the_key ) ?></code></td>
        </tr>
        <tr>
            <th><?php _e( 'Product', 'woocommerce' ) ?></th>
            <td><?php echo esc_attr( $license_key->product->get_name() ) ?></td>
        </tr>
        <tr>
            <th><?php _e( 'Order', 'woocommerce' ) ?></th>
            <td>#<?php echo esc_attr( $license_key->order_id ) ?></td>
        </tr>
    </tbody>
</table>
<?php endif ?>