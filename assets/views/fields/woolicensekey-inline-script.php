<?php
/**
 * Woo License Key Ninja Form javascript data.
 *
 * @author 10Quality <info@10quality.com>
 * @license GPLv3
 * @package woo-license-keys-nf
 * @version 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>window.woolicensekey_data = <?php echo wp_json_encode( $data ); ?>