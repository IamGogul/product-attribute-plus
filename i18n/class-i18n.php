<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'WCPAPLUS_WP_Plugin_i18n' ) ) {

	/**
	 * Define the locale for this plugin for internationalization.
	 */
    class WCPAPLUS_WP_Plugin_i18n {

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
            do_action( 'product-attribute-plus-action/plugin/i18n/loaded' );

        }

		/**
		 * Load plugin textdomain for i18n.
		 */
		public function load_plugin_textdomain() {

			load_plugin_textdomain( 'product-attribute-plus', false, plugin_basename( dirname( WPAP_CONST_DIR ) ) . '/languages');

		}

    }

}

if( !function_exists( 'prod_attr_plus_wp_plugin_i18n' ) ) {

    /**
     * Returns the instance of a class.
     */
    function prod_attr_plus_wp_plugin_i18n() {

        return WCPAPLUS_WP_Plugin_i18n::get_instance();
    }
}

prod_attr_plus_wp_plugin_i18n();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */