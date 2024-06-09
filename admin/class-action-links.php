<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Woo_Product_Attr_Plus_WP_Plugin_Action_Links' ) ) {

	/**
	 * Define the additional links and row meta of the plugin.
	 */
    class Woo_Product_Attr_Plus_WP_Plugin_Action_Links {

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

            add_filter( 'plugin_action_links_'.WPAP_CONST_BASENAME, [ $this, 'plugin_action_links' ], 10, 4 );
            add_filter( 'plugin_row_meta', [ $this, 'plugin_row_meta' ], 10, 4 );

            do_action( 'woo-pa-plus-action/plugin/action-links/loaded' );

        }

        public function plugin_action_links( $actions, $plugin_file, $plugin_data, $context ) {
            $new_actions = [];

            if( WPAP_CONST_BASENAME === $plugin_file ) {

				$new_actions['settings'] = sprintf(
                    '<a href="%1$s">%2$s</a>',
					esc_url( admin_url( add_query_arg( [ 'page' => 'wc-settings', 'tab' => WPAP_CONST_SETTINGS_TAB_ID ], 'admin.php' ) ) ),
					esc_html__( 'Settings', 'pap' )
				);

				$new_actions['add-swatch'] = sprintf(
                    '<a href="%1$s">%2$s</a>',
					esc_url( admin_url( add_query_arg([ 'post_type' => 'product', 'page' => 'product_attributes' ], 'edit.php' ) ) ),
					esc_html__( 'Add Swatch', 'pap' )
				);

            }

            return array_merge( $new_actions, $actions );
        }

        public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {

            $new_meta = [];

            if( WPAP_CONST_BASENAME === $plugin_file ) {

				$new_meta ['docs'] = sprintf(
                    '<a href="%1$s" target="_blank">📙 %2$s</a>',
					esc_url( 'plugins.gogul.pro/product-attribute-plus' ),
					esc_html__( 'Documentation', 'pap' )
                );


				$new_meta ['support'] = sprintf(
					'<a href="%1$s" target="_blank">🤚🏾 %2$s</a>',
					esc_url( '//wordpress.org/support/plugin/product-attribute-plus' ),
					esc_html__( 'Support', 'pap' )
				);
            }

            return array_merge( $plugin_meta, $new_meta );

        }

    }

}

if( !function_exists( 'woo_pa_plus_wp_plugin_action_links' ) ) {

    /**
     * Returns the instance of a class.
     */
    function woo_pa_plus_wp_plugin_action_links() {

        return Woo_Product_Attr_Plus_WP_Plugin_Action_Links::get_instance();
    }
}

woo_pa_plus_wp_plugin_action_links();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */