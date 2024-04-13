<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Woo_Product_Attr_Plus_WP_Plugin_Public' ) ) {

	/**
	 * Define the functionality for the public-facing area of the plugin.
	 */
    class Woo_Product_Attr_Plus_WP_Plugin_Public {

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

            do_action( 'woo-pa-plus-action/plugin/public/loaded' );

        }

    }

}

if( !function_exists( 'woo_pa_plus_wp_plugin_public' ) ) {

    /**
     * Returns the instance of a class.
     */
    function woo_pa_plus_wp_plugin_public() {

        return Woo_Product_Attr_Plus_WP_Plugin_Public::get_instance();
    }
}

woo_pa_plus_wp_plugin_public();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */