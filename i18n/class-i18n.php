<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Woo_Product_Attr_Plus_WP_Plugin_i18n' ) ) {

	/**
	 * Define the locale for this plugin for internationalization.
	 */
    class Woo_Product_Attr_Plus_WP_Plugin_i18n {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		/**
		 * Returns the instance.
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
            }

			return self::$instance;

		}

		/**
		 * Constructor
		 */
        public function __construct() {

			add_action( 'plugins_loaded', [ $this, 'load_plugin_textdomain' ] );
            do_action( 'woo-pa-plus-action/plugin/i18n/loaded' );

        }

		/**
		 * Load plugin textdomain for i18n.
		 */
		public function load_plugin_textdomain() {

			load_plugin_textdomain( 'pap', false, plugin_basename( dirname( WPAP_CONST_DIR ) ) . '/languages');

		}

    }

}

if( !function_exists( 'woo_pa_plus_wp_plugin_i18n' ) ) {

    /**
     * Returns the instance of a class.
     */
    function woo_pa_plus_wp_plugin_i18n() {

        return Woo_Product_Attr_Plus_WP_Plugin_i18n::get_instance();
    }
}

woo_pa_plus_wp_plugin_i18n();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */