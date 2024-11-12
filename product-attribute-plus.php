<?php
/**
 * Product Attribute Plus : Free WooCommerce Product Attribute ( Color, Image and Label Swatch ) Extender
 *
 * Plugin Name: Product Attribute Plus
 * Plugin URI:  https://wordpress.org/plugins/product-attribute-plus
 * Description: A free WooCommerce extender plugin that expands product attribute options. It adds Color, Label, and Image Swatches along side the standard dropdown menu.
 * Version: 1.0.0
 * Author: 🎖️ M Gogul Saravanan
 * Author URI: https://profiles.wordpress.org/iamgogul/
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: product-attribute-plus
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Debug
 */
if( !function_exists( 'prod_attr_plus_debug' ) ) {
	function prod_attr_plus_debug( $arg = NULL ) {
		echo '<pre>';
		var_dump( $arg );
		echo '</pre>';
	}
}

/**
 * Check whether a plugin installed.
 */
if( !function_exists( 'woo_pa_plus_is_plugin_active' ) ) {
	function woo_pa_plus_is_plugin_active( $plugin_file_path = NULL ) {
		$plugins = get_plugins();
		return isset( $plugins[ $plugin_file_path ] );
	}
}

/**
 * Get attribute's properties
 */
if( !function_exists( 'woo_pa_plus_get_tax_attribute' ) ) {
	function woo_pa_plus_get_tax_attribute( $taxonomy ) {
		global $wpdb;
		$attr = substr($taxonomy, 3);

		// phpcs:disable WordPress.DB.PreparedSQL.NotPrepared
		$query = $wpdb->prepare(
			"SELECT attribute_id, attribute_name, attribute_label, attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = %s",
			$attr
		);

		// phpcs:disable WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery,  WordPress.DB.DirectDatabaseQuery.NoCaching
		$attr = $wpdb->get_row($query);

		return $attr;
	}
}

/**
 * woo-pa-plus-css-vars.css
 * Check woo-pa-plus-css-vars.css exists in a active theme.
 */
if( !function_exists( 'woo_pa_plus_is_var_style_exists' ) ) {
	function woo_pa_plus_is_var_style_exists() {
		$stylesheet = get_stylesheet_directory() . '/woo-pa-plus-css-vars.css';

		if( file_exists( $stylesheet ) ) {
			return get_theme_file_uri(  'woo-pa-plus-css-vars.css' );
		}

		return;
	}
}

if( !class_exists( 'Woo_Product_Attr_Plus_WP_Plugin' ) ) {

    final class Woo_Product_Attr_Plus_WP_Plugin {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		/**
		 * Additional Product Attribute types
		 */
		public $product_attr_types;

		/**
		 * Swatch Sizes
		 */
		public $swatch_sizes = [];

		/**
		 * Swatch Shapes
		 */
		public $swatch_shapes = [];

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

        public function __construct() {

			$this->product_attr_types = apply_filters( 'woo-pa-plus-filter/plugin/product-attr-types', [
				'woo-pa-plus-color-sw' => esc_html__( 'Color Swatch', 'product-attribute-plus' ),
				'woo-pa-plus-image-sw' => esc_html__( 'Image Swatch', 'product-attribute-plus' ),
				'woo-pa-plus-label-sw' => esc_html__( 'Label Swatch', 'product-attribute-plus' ),
				'woo-pa-plus-radio'    => esc_html__( 'Radio Button', 'product-attribute-plus' ),
			]);

			$this->swatch_sizes = apply_filters( 'woo-pa-plus-filter/plugin/swatch/sizes', [
                'woo-pa-plus-swatch-size woo-pa-plus-swatch-size-tiny'   => esc_html__( 'Tiny', 'product-attribute-plus' ),
                'woo-pa-plus-swatch-size woo-pa-plus-swatch-size-small'  => esc_html__( 'Small', 'product-attribute-plus' ),
                'woo-pa-plus-swatch-size woo-pa-plus-swatch-size-medium' => esc_html__( 'Medium', 'product-attribute-plus' ),
                'woo-pa-plus-swatch-size woo-pa-plus-swatch-size-large'  => esc_html__( 'Large', 'product-attribute-plus' ),
                'woo-pa-plus-swatch-size woo-pa-plus-swatch-size-xlarge' => esc_html__( 'Extra Large', 'product-attribute-plus' ),
			]);

			$this->swatch_shapes = apply_filters( 'woo-pa-plus-filter/plugin/swatch/shapes', [
                'woo-pa-plus-swatch-shape woo-pa-plus-swatch-shape-bevel'          => esc_html__( 'Bevel', 'product-attribute-plus' ),
                'woo-pa-plus-swatch-shape woo-pa-plus-swatch-shape-circle'         => esc_html__( 'Circle', 'product-attribute-plus' ),
                'woo-pa-plus-swatch-shape woo-pa-plus-swatch-shape-hexagon'        => esc_html__( 'Hexagon', 'product-attribute-plus' ),
                'woo-pa-plus-swatch-shape woo-pa-plus-swatch-shape-pentagon'       => esc_html__( 'Pentagon', 'product-attribute-plus' ),
                'woo-pa-plus-swatch-shape woo-pa-plus-swatch-shape-rabbet'         => esc_html__( 'Rabbet', 'product-attribute-plus' ),
                'woo-pa-plus-swatch-shape woo-pa-plus-swatch-shape-rounded-square' => esc_html__( 'Rounded Square', 'product-attribute-plus' ),
                'woo-pa-plus-swatch-shape woo-pa-plus-swatch-shape-square'         => esc_html__( 'Square', 'product-attribute-plus' ),
			]);

            $this->define_constants();
            $this->load_dependencies();

			// HPOS	Compatibility
			add_action( 'before_woocommerce_init', [ $this, 'wc_features_support' ] );

			// Register activation and deactivation hook.
			register_activation_hook( __FILE__, [ $this, 'activate_plugin' ] );
			register_deactivation_hook( __FILE__, [ $this, 'deactivate_plugin' ] );

            do_action( 'woo-pa-plus-action/plugin/loaded' );
        }

		/**
		 * Define plugin required constants
		 */
		private function define_constants() {
            $this->define( 'WPAP_CONST_FILE', __FILE__ );

			if( ! function_exists('get_plugin_data') ){
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

            $plugin_data = get_plugin_data( WPAP_CONST_FILE );

            $this->define( 'WPAP_CONST_PLUGIN_NAME', sanitize_text_field( $plugin_data['Name'] ) );
            $this->define( 'WPAP_CONST_SAN_PLUGIN_NAME', sanitize_title( $plugin_data['Name'] ) );
            $this->define( 'WPAP_CONST_VERSION', sanitize_text_field( $plugin_data['Version'] ) );
            $this->define( 'WPAP_CONST_DIR', trailingslashit( plugin_dir_path( WPAP_CONST_FILE ) ) );
			$this->define( 'WPAP_CONST_URL', trailingslashit( plugin_dir_url( WPAP_CONST_FILE ) ) );
			$this->define( 'WPAP_CONST_BASENAME', plugin_basename( WPAP_CONST_FILE ) );
			$this->define( 'WPAP_CONST_DEBUG_SUFFIX', ( defined( 'WPAP_SCRIPT_DEBUG' ) && WPAP_SCRIPT_DEBUG ? '' : '.min' ) );

            $this->define( 'WPAP_CONST_SETTINGS_TAB_ID', 'woo-pa-plus-settings' );
            $this->define( 'WPAP_CONST_SETTINGS_TAB_NAME', esc_html__( '🎖️ Swatches', 'product-attribute-plus' ) );

        }

		/**
		 * Define constant if not already set.
		 */
		private function define( $name, $value ) {
			if( !defined( $name ) ) {
				define( $name, $value );
            }
        }

		/**
		 * Load the required dependencies for this plugin.
		 */
		private function load_dependencies() {
            if( !$this->check_requirement() ) {
                return;
            }

			/**
             * Include internationalization functionality of the plugin.
             */
			require_once WPAP_CONST_DIR . 'i18n/class-i18n.php';

			/**
			 * Include the functionality for the admin-facing area of the plugin.
			 */
			require_once WPAP_CONST_DIR . 'admin/class-admin.php';

			/**
			 * Include the functionality for the public-facing area of the plugin.
			 */
			require_once WPAP_CONST_DIR . 'public/class-public.php';

        }

		/**
		 * Check whether basic provision reached.
		 */
		private function check_requirement() {
			if ( ! function_exists('is_plugin_active') ){
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

            if( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

                add_action( 'admin_notices', function(){
					$message = sprintf(
						/* translators: %s: html tags */
                        esc_html__( 'The %1$s Product Attribute Plus %2$s plugin requires %1$sWooCommerce%2$s plugin. Kindly install and activate it.', 'product-attribute-plus' ),
                        '<strong>',
                        '</strong>'
                    );

                    $button           = '';
                    $is_woo_installed = woo_pa_plus_is_plugin_active( 'woocommerce/woocommerce.php' );

                    if( $is_woo_installed && current_user_can( 'activate_plugins' ) ) {
						$button = sprintf( '<a href="%1$s" class="button-primary">%2$s</a>',
                            wp_nonce_url( admin_url(
                                add_query_arg( [
									'action'        => 'activate',
									'plugin'        => 'woocommerce/woocommerce.php',
									'plugin_status' => 'all',
									'paged'         => '1' ],
									'plugins.php'
								) ),
								'activate-plugin_woocommerce/woocommerce.php'
							),
							esc_html__( 'Activate WooCommerce', 'product-attribute-plus' )
						);
					} else if( $is_woo_installed && current_user_can( 'install_plugins' ) ) {
						$button = sprintf( '<a href="%1$s" class="button-primary">%2$s</a>',
							wp_nonce_url( self_admin_url(
								add_query_arg( [
									'action' => 'install-plugin',
									'plugin' => 'woocommerce' ],
									'update.php'
								) ),
								'install-plugin_woocommerce'
							),
							esc_html__( 'Install WooCommerce', 'product-attribute-plus' )
                        );
                    }

					printf(
						'<div class="notice notice-info is-dismissible"> <p> %1$s </p> <p> %2$s </p> </div>',
						wp_kses_post( $message ), /* sanitized & filtered var $message  */
						wp_kses_post( $button ), /* sanitized & filtered var $button */
					);
                });

				return false;
            }

            return true;
        }

		/**
		 * Check whether WooCommerce plugin installed.
		 */
		public function is_woocommerce_installed() {
			$plugins = get_plugins();
			return isset( $plugins['woocommerce/woocommerce.php'] );
		}

		public function wc_features_support() {
			if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
				\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', WPAP_CONST_FILE, true );
			}
		}

		/**
		 * The code that runs during plugin activation.
		 */
		public static function activate_plugin() {}

		/**
		 * The code that runs during plugin deactivation.
		 */
		public static function deactivate_plugin() {}

    }
}

if( !function_exists( 'woo_pa_plus_wp_plugin' ) ) {
    /**
     * Returns instance of the WooCommerce Product Attributes Plus WP Plugin class.
     */
    function woo_pa_plus_wp_plugin() {
        return Woo_Product_Attr_Plus_WP_Plugin::get_instance();
    }
}

woo_pa_plus_wp_plugin();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */