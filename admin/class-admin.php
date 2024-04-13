<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Woo_Product_Attr_Plus_WP_Plugin_Admin' ) ) {

	/**
	 * Define the functionality for the admin-facing area of the plugin.
	 */
    class Woo_Product_Attr_Plus_WP_Plugin_Admin {

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

            do_action( 'woo-pa-plus-action/plugin/admin/loaded' );

        }

    }

}

if( !function_exists( 'woo_pa_plus_wp_plugin_admin' ) ) {

    /**
     * Returns the instance of a class.
     */
    function woo_pa_plus_wp_plugin_admin() {

        return Woo_Product_Attr_Plus_WP_Plugin_Admin::get_instance();
    }
}

woo_pa_plus_wp_plugin_admin();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */