<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Woo_Product_Attr_Plus_WP_Plugin_Products' ) ) {

	/**
	 * The class responsible for defining all actions and hooks that occur in the admin product add and edit page.
     * ?post_type=product
	 */
    class Woo_Product_Attr_Plus_WP_Plugin_Products {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

		/**
		 * Additional Product Attribute types
		 */
		public $product_attr_types;

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

            add_action( 'woocommerce_product_option_terms', [ $this, 'wc_product_option_terms' ], 10, 3 );

            do_action( 'woo-pa-plus-action/plugin/admin/product/loaded' );
        }

        /**
         * Hook to display custom attribute terms.
         * @param $attribute_taxonomy Attribute taxonomy object.
         * @param number $i Attribute index.
         * @param WC_Product_Attribute $attribute Attribute object.
         */
        public function wc_product_option_terms( $attribute_taxonomy, $index, $attribute ) {

            $attribute_name = $attribute_taxonomy->attribute_name;
            $attribute_type = $attribute_taxonomy->attribute_type;

            if( !array_key_exists( $attribute_type, $this->product_attr_types ) ) {
                return;
            }

            global $thepostid;

            // woCommerce 3.5.0 doesn't supports global $thepostid
            if( is_null( $thepostid ) && isset( $_POST['post_id'] )  ) {
                $thepostid = $_POST['post_id'];
            }

            $taxonomy_name     = wc_attribute_taxonomy_name( $attribute_name );
            $attribute_orderby = ! empty( $attribute_taxonomy->attribute_orderby ) ? $attribute_taxonomy->attribute_orderby : 'name';

            printf('<select
                name                      = attribute_values[%1$s][]
                multiple                  = "multiple"
                class                     = "multiselect attribute_values wc-taxonomy-term-search"
                data-return_id            = "id"
                data-minimum_input_length = "0"
                data-limit                = "50"
                data-placeholder          = "%2$s"
                data-orderby              = "%3$s"
                data-taxonomy             = "%4$s">',
                esc_attr( $index ),
                esc_attr__( 'Select terms', 'pap'),
                esc_attr( $attribute_orderby ),
                esc_attr( $attribute->get_taxonomy() )
            );

                $selected_terms = $attribute->get_terms();
                if ( $selected_terms ) {
                    foreach ( $selected_terms as $selected_term ) {
                        printf(
                            '<option value="%1$s" %2$s> %3$s</option>',
                            esc_attr( $selected_term->term_id ),
                            selected( has_term( absint( $selected_term->term_id ), $taxonomy_name, $thepostid  ), true, false ),
                            esc_html( apply_filters( 'woocommerce_product_attribute_term_name', $selected_term->name, $selected_term ) )
                        );
                    }
                }


            printf( '</select>' );

            printf( '
                <button class="button plus select_all_attributes"> %1$s </button>
                <button class="button minus select_no_attributes"> %2$s </button>
                <!-- <button class="button fr plus js-woo-pap-add-new-attribute" data-type="%3$s" data-taxonomy="%4$s">%5$s</button> -->',
                esc_html__( 'Select all', 'pap' ),
                esc_html__( 'Select none', 'pap' ),
                esc_attr( $attribute_type ),
                esc_attr( $attribute->get_taxonomy() ),
                esc_html__( 'Add new', 'pap' )
            );

        }

    }

}

if( !function_exists( 'woo_pa_plus_wp_plugin_products' ) ) {

    /**
     * Returns the instance of a class.
     */
    function woo_pa_plus_wp_plugin_products() {

        return Woo_Product_Attr_Plus_WP_Plugin_Products::get_instance();
    }
}

woo_pa_plus_wp_plugin_products();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */