<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Woo_Product_Attr_Plus_WP_Plugin_Settings_Page' ) ) {

	/**
	 * Define the seetings page of the plugin.
	 */
    class Woo_Product_Attr_Plus_WP_Plugin_Settings_Page {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

        /**
         * Settings Tab ID
         */
        public $id = WPAP_CONST_SETTINGS_TAB_ID;

        /**
         * Settings Tab Label
         */
        public $label = WPAP_CONST_SETTINGS_TAB_NAME;

        /**
         * Inner Sections
         */
        public $sections = [];

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

            $this->sections = [
                '' => esc_html__( 'Variable Product', 'product-attribute-plus' ),
            ];

            add_filter( 'woocommerce_settings_tabs_array', [ $this, 'add_settings_page' ], 999 );
            add_action( 'woocommerce_settings_' . $this->id, [ $this, 'output_sections'] );
            add_action( 'woocommerce_settings_' . $this->id, [ $this, 'output'] );
            add_action( 'woocommerce_settings_save_' . $this->id, [ $this, 'save'] );

            do_action( 'woo-pa-plus-action/plugin/settings/loaded' );
        }

        /**
         * Add this page to settings.
         */
        public function add_settings_page( $pages ) {
            $pages[ $this->id ] = $this->label;

            return $pages;
        }

		/**
		 * Output sections.
		 */
		public function output_sections() {
            global $current_section;

            $sections = apply_filters( 'woocommerce_get_sections_' . $this->id,  $this->sections );

            if ( empty( $sections ) || 1 === count( $sections ) ) {
				return;
			}

            $array_keys = array_keys( $sections );

            echo '<ul class="subsubsub">';
                foreach ( $sections as $id => $label ) {
                    $url       = admin_url( 'admin.php?page=wc-settings&tab=' . $this->id . '&section=' . sanitize_title( $id ) );
                    $class     = ( $current_section === $id ? 'current' : '' );
                    $separator = ( end( $array_keys ) === $id ? '' : '|' );

                    printf('<li><a href="%s" class="%s">%s</a> %s</li>', esc_url($url), esc_attr($class), esc_html($label), esc_html($separator) );
                }
            echo '</ul><br class="clear" />';
        }

		/**
		 * Output the HTML for the settings.
		 */
		public function output() {
            global $current_section;

            $settings = $this->get_settings_for_section( $current_section );

            WC_Admin_Settings::output_fields( $settings );
        }

        public function get_settings_for_section( $section_id ) {
            $section_id = sanitize_title( str_replace( '-', '_', $section_id ) );

			if ( '' === $section_id ) {
				$method_name = 'get_settings_for_default_section';
			} else {
				$method_name = "get_settings_for_{$section_id}_section";
			}

            if ( method_exists( $this, $method_name ) ) {
                $settings = $this->$method_name();
                return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings, $section_id );
            }

            return false;
        }

        public function get_settings_for_default_section() {
            $settings = [
                [
                    'title' => esc_html__( 'Configure swatch settings for the variable product detail page.', 'product-attribute-plus' ),
                    'type'  => 'title',
                    'desc'  => '',
                    'id'    => 'variable_product_woo_pap_swatch_options',
                ],
                    [
                        'title'   => esc_html__( 'Manage Swatch', 'product-attribute-plus' ),
                        'desc'    => esc_html__( 'Toggle the display of swatches in the variable product detail page.', 'product-attribute-plus' ),
                        'id'      => 'woo_pap_manage_swatch_vproduct',
                        'default' => 'yes',
                        'type'    => 'checkbox',
                    ],
                    [
                        'title'    => esc_html__( 'Swatch Size', 'product-attribute-plus' ),
                        'desc'     => esc_html__( 'Select the size of the swatch to be displayed on the variable product detail page.', 'product-attribute-plus' ),
                        'id'       => 'woo_pap_vproduct_swatch_size',
                        'type'     => 'select',
                        'class'    => 'wc-enhanced-select',
                        'css'      => 'min-width:300px;',
                        'default'  => 'woo-pa-plus-swatch-size woo-pa-plus-swatch-size-small',
                        'options'  => woo_pa_plus_wp_plugin()->swatch_sizes,
                        'autoload' => false,
                        'class'    => 'woo-pap-manage-swatch-vproduct-field',
                    ],
                    [
                        'title'    => esc_html__( 'Swatch Shape', 'product-attribute-plus' ),
                        'desc'     => esc_html__( 'Select the shape of the swatch to be displayed on the variable product detail page.', 'product-attribute-plus' ),
                        'id'       => 'woo_pap_vproduct_swatch_shape',
                        'type'     => 'select',
                        'class'    => 'wc-enhanced-select',
                        'css'      => 'min-width:300px;',
                        'default'  => 'woo-pa-plus-swatch-shape woo-pa-plus-swatch-shape-square',
                        'options'  => woo_pa_plus_wp_plugin()->swatch_shapes,
                        'autoload' => false,
                        'class'    => 'woo-pap-manage-swatch-vproduct-field',
                    ],
                    [
                        'title'    => esc_html__( 'Swatch Border Color', 'product-attribute-plus' ),
                        'desc'     => esc_html__( 'Set the border color of the swatch.', 'product-attribute-plus' ),
                        'id'       => 'woo_pap_vproduct_swatch_border_color',
                        'type'     => 'color',
                        'css'      => 'width:6em;',
                        'default'  => '#dddddd',
                        'autoload' => false,
                        'desc_tip' => true,
                        'class'    => 'woo-pap-manage-swatch-vproduct-field ',
                    ],
                    [
                        'title'    => esc_html__( 'Swatch Hover Border Color', 'product-attribute-plus' ),
                        'desc'     => esc_html__( 'The border color of the swatch was set when hovered.', 'product-attribute-plus' ),
                        'id'       => 'woo_pap_vproduct_swatch_hover_border_color',
                        'type'     => 'color',
                        'css'      => 'width:6em;',
                        'default'  => '#000000',
                        'autoload' => false,
                        'desc_tip' => true,
                        'class'    => 'woo-pap-manage-swatch-vproduct-field ',
                    ],
                    [
                        'title'    => esc_html__( 'Active Swatch Border Color', 'product-attribute-plus' ),
                        'desc'     => esc_html__( 'Set the border color of the selected swatch.', 'product-attribute-plus' ),
                        'id'       => 'woo_pap_vproduct_swatch_active_border_color',
                        'type'     => 'color',
                        'css'      => 'width:6em;',
                        'default'  => '#ff0000',
                        'autoload' => false,
                        'desc_tip' => true,
                        'class'    => 'woo-pap-manage-swatch-vproduct-field ',
                    ],
                [
					'type' => 'sectionend',
					'id'   => 'variable_product_woo_pap_swatch_options',
                ],
            ];

            return apply_filters( 'woo-pa-plus-filter/plugin/settings/product-archive', $settings );
        }

		/**
		 * Save settings and trigger the 'woocommerce_update_options_'.id action.
		 */
		public function save() {
			$this->save_settings_for_current_section();
			$this->do_update_options_action();
        }

		/**
		 * Save settings for current section.
		 */
		protected function save_settings_for_current_section() {
			global $current_section;

            $settings = $this->get_settings_for_section( $current_section );
            WC_Admin_Settings::save_fields( $settings );
        }

		/**
		 * Trigger the 'woocommerce_update_options_'.id action.
		 *
		 */
		protected function do_update_options_action( $section_id = null ) {
			global $current_section;

			if ( is_null( $section_id ) ) {
				$section_id = $current_section;
			}

			if ( $section_id ) {
				do_action( 'woocommerce_update_options_' . $this->id . '_' . $section_id );
			}
		}

    }

}

if( !function_exists( 'woo_pa_plus_wp_plugin_settings_page' ) ) {

    /**
     * Returns the instance of a class.
     */
    function woo_pa_plus_wp_plugin_settings_page() {

        return Woo_Product_Attr_Plus_WP_Plugin_Settings_Page::get_instance();
    }
}

woo_pa_plus_wp_plugin_settings_page();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */