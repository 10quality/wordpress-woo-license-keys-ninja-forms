/**
 * Script that initializes Select2 on woolicensekey
 * Ninja Forms fields.
 *
 * @link https://developer.ninjaforms.com/codex/javascript-overview/
 *
 * @author 10Quality <info@10quality.com>
 * @license GPLv3
 * @package woo-license-keys-ninja-forms
 * @version 1.0.0
 */

( function( $ ) {
    /**
     * Field controller.
     * @since 1.0.0
     */
    var WooLicenseKeyFieldController = Marionette.Object.extend( {
        /**
         * Inits controller.
         * @since 1.0.0
         */
        initialize: function()
        {
            this.listenTo( nfRadio.channel( 'form' ), 'render:view', this.initSelect2 );
        },
        /**
         * Inits select2 component.
         * @since 1.0.0
         */
        initSelect2: function()
        {
            $( '.woolicensekey-select2' ).each( function() {
                $( this ).select2( {
                    placeholder: window.woolicensekey_data.lang.placeholder,
                    allowClear: true,
                    tags: true,
                    minimumInputLength: window.woolicensekey_data.min_length === null ? undefined : window.woolicensekey_data.min_length,
                    ajax: window.woolicensekey_data.ajax && window.woolicensekey_data.ajax_url
                        ? {
                            url: window.woolicensekey_data.ajax_url,
                            data: function( params ) {
                                return {
                                    action: window.woolicensekey_data.ajax_action,
                                    code: params.term,
                                };
                            },
                            processResults: function ( response ) {
                                return {
                                    results: response.error !== undefined
                                        && ! response.error
                                        && response.data !== undefined
                                            ? response.data
                                            : [],
                                };
                            },
                            cache: true,
                        }
                        : undefined,
                    escapeMarkup: function( markup ) {
                        return markup;
                    },
                    templateResult: function( data )
                    {
                        return data.html ? data.html : data;
                    },
                    templateSelection: function( data )
                    {
                        return data.text ? data.text : data;
                    },
                    language: {
                        inputTooShort: function( args ) {
                            return window.woolicensekey_data.lang.inputTooShort;
                        },
                        inputTooLong: function( args ) {
                            return window.woolicensekey_data.lang.inputTooLong;
                        },
                        errorLoading: function() {
                            return window.woolicensekey_data.lang.errorLoading;
                        },
                        loadingMore: function() {
                            return window.woolicensekey_data.lang.loadingMore;
                        },
                        noResults: function() {
                            return window.woolicensekey_data.lang.noResults;
                        },
                        searching: function() {
                            return window.woolicensekey_data.lang.searching;
                        },
                        maximumSelected: function( args ) {
                            return window.woolicensekey_data.lang.maximumSelected;
                        },
                    }
                } );
            } );
        }
    });
    /**
     * Controller init.
     * @since 1.0.0
     */
    $( document ).ready( function() {
        window.nfWooLicenseKey = new WooLicenseKeyFieldController();
    } );
} )( jQuery );