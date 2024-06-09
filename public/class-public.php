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

			add_filter( 'get_the_generator_html', [ $this, 'generator_tag' ], 10, 2 );
            add_filter( 'get_the_generator_xhtml', [ $this, 'generator_tag' ], 10, 2 );
            add_filter( 'body_class', [ $this, 'body_classes' ] );

            do_action( 'woo-pa-plus-action/plugin/public/loaded' );

        }

		/**
		 * Output generator tag to aid debugging.
		 */
        public function generator_tag( $gen, $type ) {

            $esc_tag = sprintf(
                /* translators: 1:Name of a theme 2: Version number of a theme 3:Name of theme author */
                esc_attr__( '%1$s %2$s by %3$s', 'ppa' ),
                WPAP_CONST_PLUGIN_NAME,
                WPAP_CONST_VERSION,
                'M Gogul Saravanan'
            );

			$gen .= "\n" . '<meta name="generator" content="'.$esc_tag.'">';

            return $gen;
		}

        /**
         * Displays the classes for the body tag
         */
        public function body_classes( $classes ) {
			$classes[] = 'woo-pa-plus-free-plugin';
			return $classes;
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