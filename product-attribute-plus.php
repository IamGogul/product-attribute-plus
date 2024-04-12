<?php
/**
 * Product Attribute Plus : Free WooCommerce Product Attribute ( Color, Image and Label Swatch ) Extender
 *
 * Plugin Name: Product Attribute Plus
 * Plugin URI:  https://wordpress.org/plugins/product-attribute-plus
 * Description: A free WooCommerce extender plugin that expands product attribute options. It ads Color, Label, and Image Swatches alongside the standard dropdown menu.
 * Version: 1.0.0
 * Author: M Gogul Saravanan
 * Author URI: https://profiles.wordpress.org/iamgogul/
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: pap
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Debug
 */
if( !function_exists( 'woo_pa_plus_debug' ) ) {
	function woo_pa_plus_debug( $arg = NULL ) {
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

if( !class_exists( 'Woo_Product_Attr_Plus_WP_Plugin' ) ) {

    final class Woo_Product_Attr_Plus_WP_Plugin {

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

        public function __construct() {
            $this->define_constants();
            $this->load_dependencies();

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
			$this->define( 'WPAP_CONST_DEBUG_SUFFIX', ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' ) );
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
                    /* translators: %s: html tags */
                    $message = sprintf(
                        esc_html__( 'The %1$s Product Attribute Plus %2$s plugin requires %1$sWooCommerce%2$s plugin. Kindly install and activate it.', 'pap' ),
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
							esc_html__( 'Activate WooCommerce', 'pap' )
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
							esc_html__( 'Install WooCommerce', 'pap' )
                        );
                    }

					printf(
						'<div class="notice notice-info is-dismissible"> <p> %1$s </p> <p> %2$s </p> </div>',
						wp_kses_post( $message ), /* sanitized & filtered var $message  */
						wp_kses_post( $button ), /* sanitized & filtered var $button */
					);
                });
            }

            return true;
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