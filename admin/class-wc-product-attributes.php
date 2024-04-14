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
		 * Additional Product Attribute types
		 */
		public $product_attr_types;

		/**
		 * Product Attribute size
		 */
		public $swatch_sizes;

		/**
		 * Product Attribute shape
		 */
		public $swatch_shapes;

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

			$this->product_attr_types = woo_pa_plus_wp_plugin()->product_attr_types;
			$this->swatch_shapes      = woo_pa_plus_wp_plugin()->swatch_shapes;
			$this->swatch_sizes       = woo_pa_plus_wp_plugin()->swatch_sizes;

			add_filter( 'product_attributes_type_selector', [ $this, 'add_attribute_types' ] );

			/**
			 * Add additional fields on new product attribute add form
			 */
			add_action( 'woocommerce_after_add_attribute_fields', [ $this, 'add_attribute_fields' ] );
			add_action( 'woocommerce_attribute_added', [ $this, 'add_attribute_meta' ], 10, 1 );

			/**
			 * Add additional fields on new product attribute edit form
			 */
			add_action( 'woocommerce_after_edit_attribute_fields', [ $this, 'edit_attribute_fields' ] );
			add_action( 'woocommerce_attribute_updated', [ $this, 'update_attribute_meta' ], 10, 1 );

            do_action( 'woo-pa-plus-action/plugin/product-attributes/loaded' );

        }

        /**
         * Add extra Product Attribute types
         * New Attributes - Color, Image, Label And Radio
         */
        public function add_attribute_types( $types ) {
            return array_merge( $types, $this->product_attr_types );
        }

		public function add_attribute_fields() {
			/**
			 * Shape
			 */
			printf('
				<div class="form-field js-woo-pap-add-field attribute_pap_shape-add-field">
					<label for="attribute_pap_shape">%1$s</label>
					<select name="attribute_pap_shape" id="attribute_pap_shape" class="regular-text"> %2$s </select>
					<p class="description"> %3$s </p>
				</div>',
				esc_html__( 'Swatch Shape', 'pap' ),
				$this->_swatch_shape_options(),
				esc_html__( 'Determines the shape of the swatch to be displayed.', 'pap' )
			);

			/**
			 * Size
			 */
			printf('
				<div class="form-field js-woo-pap-add-field attribute_pap_size-add-field">
					<label for="attribute_pap_size">%1$s</label>
					<select name="attribute_pap_size" id="attribute_pap_size" class="regular-text"> %2$s </select>
					<p class="description"> %3$s </p>
				</div>',
				esc_html__( 'Swatch Size', 'pap' ),
				$this->_swatch_size_options(),
				esc_html__( 'Determines the size of the swatch to be displayed.', 'pap' )
			);

		}

		public function add_attribute_meta( $id ) {
            /**
             * current user has the specified capability to manage options able to update the settings
             */
            if( current_user_can( 'manage_options' ) ) {
				$verify_nonce = wp_verify_nonce( $_POST['_wpnonce'], 'woocommerce-add-new_attribute' );
				if( $verify_nonce ) {
					if( isset( $_POST['attribute_pap_shape'] ) ) {
						$key = sprintf('_woo_pap_shape_%d', $id );
						update_option( $key, sanitize_text_field( $_POST['attribute_pap_shape'] ) );
					}

					if( isset( $_POST['attribute_pap_size'] ) ) {
						$key = sprintf('_woo_pap_size_%d', $id );
						update_option( $key, sanitize_text_field( $_POST['attribute_pap_size'] ) );
					}
				}
			}
		}

		public function edit_attribute_fields() {

			$edit = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0;

			if ( $edit > 0 ) {
				$pap_shape_key = sprintf('_woo_pap_shape_%d', $edit );
				$pap_size_key  = sprintf('_woo_pap_size_%d', $edit );

				/**
				 * Shape
				 */
				printf('
					<tr class="form-field js-woo-pap-edit-field attribute_pap_shape-field">
						<th scope="row" valign="top">
							<label for="attribute_pap_shape">%1$s</label>
						</th>
						<td>
							<select name="attribute_pap_shape" id="attribute_pap_shape" class="regular-text"> %2$s </select>
							<p class="description"> %3$s </p>
						</td>
					</tr>',
					esc_html__( 'Swatch Shape', 'pap' ),
					$this->_swatch_shape_options( get_option( $pap_shape_key ) ),
					esc_html__( 'Determines the shape of the swatch to be displayed.', 'pap' )
				);

				/**
				 * Size
				 */
				printf('
					<tr class="form-field js-woo-pap-edit-field attribute_pap_size-field">
						<th scope="row" valign="top">
							<label for="attribute_pap_size">%1$s</label>
						</th>
						<td>
							<select name="attribute_pap_size" id="attribute_pap_size" class="regular-text"> %2$s </select>
							<p class="description"> %3$s </p>
						</td>
					</tr>',
					esc_html__( 'Swatch Size', 'pap' ),
					$this->_swatch_size_options( get_option( $pap_size_key ) ),
					esc_html__( 'Determines the shape of the swatch to be displayed.', 'pap' )
				);
			}

		}

		public function update_attribute_meta( $edit ) {
            /**
             * current user has the specified capability to manage options able to update the settings
             */
            if( current_user_can( 'manage_options' ) ) {
				$verify_nonce = wp_verify_nonce( $_POST['_wpnonce'], 'woocommerce-save-attribute_' . $edit );
				if( $verify_nonce ) {
					if( isset( $_POST['attribute_pap_shape'] ) ) {
						$key = sprintf('_woo_pap_shape_%d', $edit );
						update_option( $key, sanitize_text_field( $_POST['attribute_pap_shape'] ) );
					}

					if( isset( $_POST['attribute_pap_size'] ) ) {
						$key = sprintf('_woo_pap_size_%d', $edit );
						update_option( $key, sanitize_text_field( $_POST['attribute_pap_size'] ) );
					}
				}
			}
		}

		/**
		 * Swatch Shapes util function
		 */
		public function _swatch_shape_options( $selected = '' ) {
			$select_options = '';
			$options[ 'global' ] = esc_html__( 'Global ( Plugin Settings )', 'pap' );

			foreach( $this->swatch_shapes as $shape_key => $shape_value  ) {
				$options[ $shape_key ] = $shape_value;
			}

			foreach( $options as $key => $value ) {
				$select_options .= sprintf(
					'<option value="%1$s" %2$s>%3$s</option>',
					$key,
					( $selected == $key ? 'selected' : '' ),
					$value
				);
			}

			return $select_options;
		}

		/**
		 * Swatch Sizes util function
		 */
		public function _swatch_size_options( $selected = '' ) {
			$select_options = '';
			$options[ 'global' ] = esc_html__( 'Global ( Plugin Settings )', 'pap' );

			foreach( $this->swatch_sizes as $size_key => $size_value  ) {
				$options[ $size_key ] = $size_value;
			}

			foreach( $options as $key => $value ) {
				$select_options .= sprintf(
					'<option value="%1$s" %2$s>%3$s</option>',
					$key,
					( $selected == $key ? 'selected' : '' ),
					$value
				);
			}

			return $select_options;
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