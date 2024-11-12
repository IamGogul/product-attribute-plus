<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'Woo_Product_Attr_Plus_WP_Plugin_Product_Attribute_Type' ) ) {

	/**
	 * Define all actions and hooks that occur in the admin product attributes edit page.
     * edit.php?post_type=product&page=product_attributes
	 */
    class Woo_Product_Attr_Plus_WP_Plugin_Product_Attribute_Type {

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

			$this->product_attr_types = prod_attr_plus_wp_plugin()->product_attr_types;

            add_action( 'admin_init', [ $this, 'taxonomies_init' ] );

            add_action( 'woo-pa-plus-action/plugin/product-attribute-type-field', [ $this, 'print_attribute_field' ], 10, 3 );

            add_action( 'created_term', [ $this, 'save_term_meta' ], 10, 4 );
            add_action( 'edit_term', [ $this, 'save_term_meta' ], 10, 4 );

            do_action( 'woo-pa-plus-action/plugin/product-attributes-type/loaded' );

        }

        /**
         * Call admin hooks to add, edit and display taxonomies
         * Add form field in both add and edit term screen
         */
        public function taxonomies_init() {

            $attr_taxonomies = wc_get_attribute_taxonomies();

            if ( empty( $attr_taxonomies ) ) {
                return;
            }

            foreach( $attr_taxonomies as $taxonomy ) {

                // Manage Columns
                    add_filter( 'manage_edit-pa_' . $taxonomy->attribute_name . '_columns', [ $this, 'add_attribute_columns' ] );
                    add_filter( 'manage_pa_' . $taxonomy->attribute_name . '_custom_column', [ $this, 'add_attribute_column_content' ], 10, 3 );

                // Add Form Fields
                    add_action('pa_' . $taxonomy->attribute_name. '_add_form_fields', [ $this, 'add_attribute_fields' ]  );
                    add_action('pa_' . $taxonomy->attribute_name. '_edit_form_fields', [ $this, 'edit_attribute_fields' ], 10, 2 );

            }

        }

        /**
         * Add custom column to attribute list table
         *
         */
        public function add_attribute_columns( $columns ) {

            $new_columns = [];

            if( !empty( $columns ) ) {
                $new_columns['cb']    = $columns['cb'];
                $new_columns['thumb'] = '';
                unset( $columns['cb'] );
            }

            return array_merge( $new_columns, $columns );

        }

        /**
         * Provide thumbnail HTML depend on attribute type
         */
        public function add_attribute_column_content( $columns, $column, $term_id ) {
            // phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
            $attribute       = prod_attr_plus_get_tax_attribute( $_REQUEST['taxonomy'] );
            $attribute_type  = $attribute->attribute_type;
            $attribute_value = get_term_meta( $term_id, $attribute_type, true );

            switch ( $attribute_type ) {

                case 'woo-pa-plus-color-sw':
                    $field = sprintf(
                        '<div class="woo-pa-plus-attr-col %s" style="background-color:%s;"></div>',
                        esc_attr( $attribute_type ),
                        esc_attr( $attribute_value )
                    );

                    // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo apply_filters( 'woo-pa-plus-filter/plugin/attr-col-content/woo-pa-plus-color-sw', wp_kses_post( $field ) );
                break;

                case 'woo-pa-plus-image-sw':
                    $image = $attribute_value ? wp_get_attachment_image_src( $attribute_value, [ 100, 100 ] ) : '';
                    $image = $image ? $image[0] : WPAP_CONST_URL . 'assets/admin/images/placeholder.png';

                    $field = sprintf(
                        '<div class="woo-pa-plus-attr-col %s" style="background-image:url(%s);"></div>',
                        esc_attr( $attribute_type ),
                        esc_url( $image )
                    );

                    // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo apply_filters( 'woo-pa-plus-filter/plugin/attr-col-content/woo-pa-plus-image-sw', wp_kses_post( $field ) );
                break;

                case 'woo-pa-plus-label-sw':
                    $field = sprintf(
                        '<div class="woo-pa-plus-attr-col %s">%s</div>',
                        esc_attr( $attribute_type ),
                        esc_attr( $attribute_value )
                    );

                    // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo apply_filters( 'woo-pa-plus-filter/plugin/attr-col-content/woo-pa-plus-label-sw', wp_kses_post( $field ) );
                break;

            }
        }

        /**
         * Hook to add fields to add attribute screen
         */
        public function add_attribute_fields( $taxonomy ) {
            $mode              = 'add';
            $attribute         = prod_attr_plus_get_tax_attribute( $taxonomy );
            $attribute_value   = '';

            if( is_null( $attribute ) ) {
                return;
            }

            do_action( 'woo-pa-plus-action/plugin/product-attribute-type-field', $attribute->attribute_type, $attribute_value, $mode );
        }

        /**
         * Hook to Add fields to edit attribute screen
         */
        public function edit_attribute_fields( $term, $taxonomy ) {
            $mode      = 'edit';
            $attribute = prod_attr_plus_get_tax_attribute( $taxonomy );

            if( is_null( $attribute ) ) {
                return;
            }

            $attribute_value = get_term_meta( $term->term_id, $attribute->attribute_type, true );

            do_action( 'woo-pa-plus-action/plugin/product-attribute-type-field', $attribute->attribute_type, $attribute_value, $mode );
        }

        /**
         * Prints field on attribute screen
         */
        public function print_attribute_field( $attribute_type, $attribute_value, $mode ) {

            if( is_null( $attribute_type ) ) {
                return;
            }

            if( !in_array( $attribute_type, [ 'woo-pa-plus-color-sw', 'woo-pa-plus-image-sw', 'woo-pa-plus-label-sw' ] ) ) {
                return;
            }

            if( 'edit' == $mode ) {
                printf(
                    '<input type="hidden" name="post_type" value="%1$s"/>',
                    esc_attr( $_GET['post_type'] ) // phpcs:disable WordPress.Security.NonceVerification.Recommended
                );
            }

            /**
             * Swatch
             * phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
             */
            printf(
                '<%1s class="form-field">%2s<label for="term-%3s">%4s</label>%5s',
                'edit' == $mode ? 'tr' : 'div',
                'edit' == $mode ? '<th>' : '',
                esc_attr( $attribute_type ),
                $this->product_attr_types[$attribute_type],
                'edit' == $mode ? '</th> <td>' : ''
            );

            switch( $attribute_type ) {
                case 'woo-pa-plus-color-sw':
                    printf(
                        '<input type="text" id="term-%1$s" class="woo-pa-plus-color-picker" name="%1$s" value="%2$s"/>',
                        esc_attr( $attribute_type ),
                        esc_attr( $attribute_value )
                    );
                break;

                case 'woo-pa-plus-image-sw':
                    if( 'edit' == $mode && !empty( $attribute_value ) ) {
                        $image = $attribute_value ? wp_get_attachment_image_src( $attribute_value, [ 100, 100 ] ) : '';
                        $image = $image ? $image[0] : '';

                        printf(
                            '<div class="woo-pa-plus-sw-image-img-holder">
                                <div class="kfwoo-sw-image-img">
                                    <img src="%1$s"/>
                                    <a href="javascript:void(0);" class="attribute-screen woo-pa-plus-sw-image-img-remove" title="%2$s"></a>
                                </div>
                            </div>',
                            esc_url( $image ),
                            esc_attr__( 'Remove Image', 'product-attribute-plus' ),
                        );
                    }

                    printf(
                        '<div class="woo-pa-plus-sw-image-img-picker">
                            <input type="hidden" readonly id="term-%1$s" class="woo-pa-plus-sw-image-id" name="%1$s" value="%2$s"/>
                            <button data-title="%3$s" data-button="%4$s" data-remove="%5$s" class="button button-secondary attribute-screen woo-pa-plus-sw-image-button %6$s">%7$s</button>
                        </div>',
                        esc_attr( $attribute_type ),
                        esc_attr( $attribute_value ),
                        esc_attr__( 'Choose an Image', 'product-attribute-plus' ),
                        esc_attr__( 'Set Image', 'product-attribute-plus' ),
                        esc_attr__( 'Remove Image', 'product-attribute-plus' ),
                        'edit' == ( $mode && !empty( $attribute_value ) ) ? 'hidden' : '',
                        esc_attr__( 'Add Image', 'product-attribute-plus' ),
                    );
                break;

                case 'woo-pa-plus-label-sw':
                    printf(
                        '<input type="text" id="term-%1$s" class="regular-text woo-pa-plus-label" name="%1$s" value="%2$s"/>',
                        esc_attr( $attribute_type ),
                        esc_attr( $attribute_value )
                    );
                break;
            }

            print( 'edit' == $mode ? '</td> </tr>' : '</div>' );

        }

        /**
         * Save term meta
         * @param int    $term_id  Term ID.
         * @param int    $tt_id    Term taxonomy ID.
         * @param string $taxonomy Taxonomy slug.
         * @param array  $args     Arguments passed to wp_insert_term().
         */
        public function save_term_meta( $term_id, $tt_id, $taxonomy, $args ) {

            $attribute = prod_attr_plus_get_tax_attribute( $taxonomy );

            if( is_null( $attribute )) {
                return;
            }

            if( isset( $args['post_type'] ) && 'product' == $args['post_type'] ) {

                $attribute_type = $attribute->attribute_type;

                if( array_key_exists( $attribute_type, $this->product_attr_types ) ) {

                    if( isset( $args[ $attribute_type ] ) ) {

                        update_term_meta( $term_id, $attribute_type, sanitize_text_field( $args[ $attribute_type ] ) );

                    }

                }
            }

        }

    }

}

if( !function_exists( 'woo_pa_plus_wp_plugin_product_attribute_type' ) ) {

    /**
     * Returns the instance of a class.
     */
    function woo_pa_plus_wp_plugin_product_attribute_type() {

        return Woo_Product_Attr_Plus_WP_Plugin_Product_Attribute_Type::get_instance();
    }
}

woo_pa_plus_wp_plugin_product_attribute_type();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */