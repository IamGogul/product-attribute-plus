<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Woo_Product_Attr_Plus_WP_Plugin_Product_Attributes' ) ) {

	/**
	 * Define all actions and hooks that occur in the admin product attributes edit page.
     * edit.php?post_type=product&page=product_attributes
	 */
    class Woo_Product_Attr_Plus_WP_Plugin_Product_Attributes {

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

            do_action( 'woo-pa-plus-action/plugin/product-attributes/loaded' );

        }

    }

}

if( !function_exists( 'woo_pa_plus_wp_plugin_product_attributes' ) ) {

    /**
     * Returns the instance of a class.
     */
    function woo_pa_plus_wp_plugin_product_attributes() {

        return Woo_Product_Attr_Plus_WP_Plugin_Product_Attributes::get_instance();
    }
}

woo_pa_plus_wp_plugin_product_attributes();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */