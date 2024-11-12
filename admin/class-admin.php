<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'WCPAPLUS_WP_Plugin_Admin' ) ) {

	/**
	 * Define the functionality for the admin-facing area of the plugin.
	 */
    class WCPAPLUS_WP_Plugin_Admin {

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

			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ], 100 );

            $this->load_modules();
            do_action( 'woo-pa-plus-action/plugin/admin/loaded' );

        }

		public function enqueue_scripts() {
			$load_css = $lode_js = false;
			$screen   = get_current_screen();
			$js_deps  = [ 'jquery' ];
			$css_deps = [ 'wp-color-picker' ];
			$localize = [
				'ajax'          => esc_url( admin_url('admin-ajax.php') ),
				'pluginName'    => WPAP_CONST_PLUGIN_NAME,
				'pluginSanName' => WPAP_CONST_SAN_PLUGIN_NAME,
				'pluginVersion' => WPAP_CONST_VERSION,
            ];

			if( $screen->id == 'product_page_product_attributes' ) {
				$lode_js = true;
			}

			if( strpos( $screen->id, 'edit-pa_' ) !== false ) {
				$load_css = $lode_js = true;
				$js_deps  = [ 'jquery', 'wp-color-picker' ];
				wp_enqueue_media();
			}

			if( $screen->id == 'woocommerce_page_wc-settings' ) {
				$lode_js = true;
				$js_deps = ['woocommerce_settings'];
			}

			if( $load_css ) {
				wp_enqueue_style(
					WPAP_CONST_PLUGIN_NAME,
					WPAP_CONST_URL . 'assets/admin/css/style' . WPAP_CONST_DEBUG_SUFFIX . '.css',
					$css_deps,
					WPAP_CONST_VERSION,
					'all'
				);
			}

			if( $lode_js ) {
				wp_enqueue_script(
					WPAP_CONST_PLUGIN_NAME,
					WPAP_CONST_URL . 'assets/admin/js/admin' . WPAP_CONST_DEBUG_SUFFIX . '.js',
					$js_deps,
					WPAP_CONST_VERSION,
					true
				);
			}

			wp_localize_script( 'jquery', 'woo_pa_plus_plugin_L10n',apply_filters( 'woo-pa-plus-filter/plugin/admin/L10n', $localize )  );
		}

        public function load_modules() {

            require_once WPAP_CONST_DIR . 'admin/class-action-links.php';

			require_once WPAP_CONST_DIR . 'admin/class-wc-settings-page.php';

            require_once WPAP_CONST_DIR . 'admin/class-wc-product-attributes.php';

            require_once WPAP_CONST_DIR . 'admin/class-wc-product-attribute-type.php';

            require_once WPAP_CONST_DIR . 'admin/class-wc-product.php';

        }

    }

}

if( !function_exists( 'prod_attr_plus_wp_plugin_admin' ) ) {

    /**
     * Returns the instance of a class.
     */
    function prod_attr_plus_wp_plugin_admin() {

        return WCPAPLUS_WP_Plugin_Admin::get_instance();
    }
}

prod_attr_plus_wp_plugin_admin();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */