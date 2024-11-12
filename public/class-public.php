<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'WCPAPLUS_WP_Plugin_Public' ) ) {

	/**
	 * Define the functionality for the public-facing area of the plugin.
	 */
    class WCPAPLUS_WP_Plugin_Public {

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

			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 10 );
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_vars' ], 20 );

			$this->load_modules();

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

		public function enqueue_scripts() {

			/**
			 * Style
			 */
				wp_enqueue_style(
					WPAP_CONST_SAN_PLUGIN_NAME,
					WPAP_CONST_URL . 'assets/public/css/style' . WPAP_CONST_DEBUG_SUFFIX . '.css',
					[],
					WPAP_CONST_VERSION,
					'all'
				);

			/**
			 * Script
			 */
				wp_enqueue_script(
					WPAP_CONST_SAN_PLUGIN_NAME,
					WPAP_CONST_URL . 'assets/public/js/public' . WPAP_CONST_DEBUG_SUFFIX . '.js',
					[ 'wc-add-to-cart-variation','jquery' ],
					WPAP_CONST_VERSION,
					[ 'strategy'  => 'defer', 'in_footer' => true, ]
				);

			/**
			 * Localize
			 */
				$localize = [
					'ajax'                    => esc_url( admin_url('admin-ajax.php') ),
					'pluginName'              => WPAP_CONST_PLUGIN_NAME,
					'pluginSanName'           => WPAP_CONST_SAN_PLUGIN_NAME,
					'pluginVersion'           => WPAP_CONST_VERSION,
					"is_singular_product"     => is_singular( 'product'),
				];
				wp_localize_script( 'jquery', 'woo_pa_plus_plugin_L10n', apply_filters( 'woo-pa-plus-filter/plugin/l10n', $localize ) );

		}

		public function enqueue_vars() {
			$static_css_vars_stylesheet = prod_attr_plus_is_var_style_exists();

			if( is_null( $static_css_vars_stylesheet ) ) {
				/**
				 * CSS Variables
				 */
				$vars = '';

				/**
				 * Single Variable Product
				 */
					$vproduct_swatch_border_color        = get_option( 'woo_pap_vproduct_swatch_border_color', '#dddddd' );
					$vproduct_swatch_active_border_color = get_option( 'woo_pap_vproduct_swatch_active_border_color', '#ff0000' );
					$vproduct_swatch_hover_border_color  = get_option( 'woo_pap_vproduct_swatch_hover_border_color', '#000000' );

					$vars .= sprintf('--woo-pap-swatch-border-color:%1$s;%2$s', $vproduct_swatch_border_color, "\n" );
					$vars .= sprintf('--woo-pap-swatch-active-border-color:%1$s;%2$s', $vproduct_swatch_active_border_color, "\n" );
					$vars .= sprintf('--woo-pap-swatch-hover-border-color:%1$s;%2$s', $vproduct_swatch_hover_border_color, "\n" );

				if( !empty( $vars ) ) {
					$css = sprintf(
						/* translators: %s: woo-pa-plus-css-vars.css - a stylesheet file name */
						esc_html__('/* Create a file %s in active theme and add the below css in it. */', 'product-attribute-plus' ),
						'woo-pa-plus-css-vars.css'
					);

					$css .= sprintf('%1$s :root{%1$s%2$s}', "\n", $vars );
					wp_add_inline_style( WPAP_CONST_SAN_PLUGIN_NAME, $css );
				}
			} else {
				wp_enqueue_style( 'woo-pa-plus-css-vars', $static_css_vars_stylesheet, [], WPAP_CONST_VERSION, 'all' );
			}
		}

        /**
         * Load the required dependencies.
         */
		public function load_modules() {

            require_once WPAP_CONST_DIR . 'public/class-wc-single-variable-product.php';

		}

    }

}

if( !function_exists( 'woo_pa_plus_wp_plugin_public' ) ) {

    /**
     * Returns the instance of a class.
     */
    function woo_pa_plus_wp_plugin_public() {

        return WCPAPLUS_WP_Plugin_Public::get_instance();
    }
}

woo_pa_plus_wp_plugin_public();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */