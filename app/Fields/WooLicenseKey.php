<?php

namespace WCLKNinjaForms\Fields;

use NF_Fields_Textbox;

/**
 * Ninja forms license key field.
 *
 * @author 10Quality <info@10quality.com>
 * @license GPLv3
 * @package woo-license-keys-nf
 * @version 1.0.0
 */
class WooLicenseKey extends NF_Fields_Textbox
{
    /**
     * Field key name.
     * @since 1.0.0
     * @var string
     */
    const KEY = 'woolicensekey';
    /**
     * Field key name.
     * @since 1.0.0
     * @var string
     */
    protected $_name = self::KEY;
    /**
     * Field section name.
     * @since 1.0.0
     * @var string
     */
    protected $_section = 'userinfo';
    /**
     * Field icon.
     * @since 1.0.0
     * @var string
     * 
     * @link https://fontawesome.com/icons
     */
    protected $_icon = 'key';
    /**
     * Field type.
     * @since 1.0.0
     * @var string
     */
    protected $_type = 'woolicensekey';
    /**
     * Field template.
     * @since 1.0.0
     * @var string
     */
    protected $_templates = 'woolicensekey';
    /**
     * Excluded field settings.
     * @since 1.0.0
     * @var string
     */
    protected $_settings_exclude = [
        'input_limit_set',
        'disable_input',
        'disable_browser_autocomplete',
        'default',
        'mask',
    ];
    /**
     * Constructor.
     * @since 1.0.0
     */
    public function __construct()
    {
        parent::__construct();
        $this->_nicename = __( 'License Key', 'woo-license-keys' );
    }
}