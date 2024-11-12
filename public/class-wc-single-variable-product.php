<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if( !class_exists( 'WCPAPLUS_WP_Plugin_Single_Variable_Product' ) ) {

	/**
	 * The class responsible for defining all actions and hooks that occur in the single variable product.
     *
	 */
    class WCPAPLUS_WP_Plugin_Single_Variable_Product {

		/**
		 * A reference to an instance of this class.
		 */
		private static $instance = null;

        private $args;

		/**
		 * Additional Product Attribute types
		 */
		public $product_attr_types;

		/**
		 * Returns the instance.
		 */
		public static function get_instance( $args ) {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self( $args );
            }

			return self::$instance;

		}

		/**
		 * Constructor
		 */
        public function __construct( $args ) {

            $this->args = $args;

			$this->product_attr_types = prod_attr_plus_wp_plugin()->product_attr_types;

			add_action( 'woocommerce_before_variations_form', [ $this, 'start_capture' ]);
			add_action( 'woocommerce_after_variations_form', [ $this, 'stop_capture' ]);

            add_filter( 'woo-pa-plus-filter/plugin/variable/product/swatch', [ $this, 'swatch_html' ],10, 7 );
        }

		/**
		 *  Start capturing the variation form
		 */
		public function start_capture() {
			ob_start();
		}

		/**
		 * Stop capturing and print the variation form
		 */
		public function stop_capture() {
			global $product;

            $args = $this->args;
			$form = ob_get_contents();

			if( $form ) {

				ob_end_clean();
			}

            if ( $product->is_type( 'variable' ) ) {

                $attributes = $product->get_variation_attributes();

                foreach( $attributes as $attribute_name => $options ) {
					$attribute      = prod_attr_plus_get_tax_attribute( $attribute_name );
					$attribute_type = $attribute->attribute_type;

					// Generate request variable name.
					$key      = 'attribute_' . sanitize_title( $attribute_name );

					// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
					$selected = isset( $_REQUEST[ $key ] ) ? wc_clean( $_REQUEST[ $key ] ) : $product->get_variation_default_attribute( $attribute_name );

					if( !is_null( $attribute ) ) { // custom attributes throws null
						if( array_key_exists( $attribute_type,  $this->product_attr_types ) ) {

                            $pap_shape_key = sprintf('_woo_pap_shape_%d', $attribute->attribute_id );
                            $pap_size_key  = sprintf('_woo_pap_size_%d', $attribute->attribute_id );

                            /**
                             * Shape
                             * Update Shape type of an attribute base on its own.
                             */
                            $shape = get_option( $pap_shape_key, false );
                            if( $shape && $shape !== 'global' ) {
                                $args['shape'] = $shape;
                            }

                            /**
                             * Size
                             * Update Size type of an attribute base on its own.
                             */
                            $size = get_option( $pap_size_key, false );
                            if( $size && $size !== 'global' ) {
                                $args['size'] = $size;
                            }

							// Get terms if this is a taxonomy - ordered. We need the names too.
							$terms  = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'all' ) );
							$swatch = apply_filters(
                                'woo-pa-plus-filter/plugin/variable/product/swatch',
                                '',
                                $attribute_type,
                                $attribute_name,
                                $terms,
                                $options,
                                $selected,
                                $args
                            );

							// update variation form
							$form = preg_replace(
								'/<select id="(' . sanitize_title( $attribute_name ) . ')" class="([^"]*)" name="([^"]+)" data-attribute_name="([^"]+)"[^>]*>/',
								$swatch . '<select id="\\1" class="\\2 woo-pa-plus-variation-select" name="\\3" data-attribute_name="\\4" style="display: none;">',
								$form
							);
                        }
                    }
                }

            }

			// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
            print( $form );
        }

		/**
		 * Print HTML of swatches
		 */
		public function swatch_html( $html, $attribute_type, $attribute_name, $terms, $options, $selected, $settings ) {

			$class = [
				'woo-pa-plus-swatch',
				$attribute_type,
				$settings['size'],
				$settings['shape'],
			];

			if( $attribute_type === 'woo-pa-plus-radio' ) {
				unset( $class[2], $class[3] );
			}

			$class = implode( ' ', $class );
            $html .= sprintf( '<ul class="%1$s" data-attribute="%2$s">', esc_attr( $class ), $attribute_name  );

            switch ( $attribute_type ) {
                case 'woo-pa-plus-color-sw':
                    foreach( $terms as $term ) {
						$term_id   = $term->term_id;
						$term_slug = $term->slug;

                        if ( in_array( $term_slug, $options, true ) ) {
                            $class = ( $selected == $term_slug ) ? 'selected' : '';

							$html .= sprintf(
								'<li class="%1$s">
									<div class="woo-pa-plus-sw-wrap">
										<span class="woo-pa-plus-swatch-attribute woo-pa-plus-swatch-attr-%2$s" data-value="%3$s" data-name="%4$s" style="background-color:%5$s;"></span>
									</div>
								</li>',
								esc_attr( $class ),
								esc_attr( $term_id ),
								esc_attr( $term->slug ),
								esc_attr( $term->name ),
								esc_attr( get_term_meta( $term_id, $attribute_type, true ) ),
							);
                        }
                    }
                break;

                case 'woo-pa-plus-image-sw':
                    foreach( $terms as $term ) {
						$term_id   = $term->term_id;
						$term_slug = $term->slug;

                        if ( in_array( $term_slug, $options, true ) ) {
                            $class = ( $selected == $term_slug ) ? 'selected' : '';
							$image = get_term_meta( $term_id, $attribute_type, true );

							$html .= sprintf(
								'<li class="%1$s">
									<div class="woo-pa-plus-sw-wrap">
										<span class="woo-pa-plus-swatch-attribute woo-pa-plus-swatch-attr-%2$s" data-value="%3$s" data-name="%4$s">%5$s</span>
									</div>
								</li>',
								esc_attr( $class ),
								esc_attr( $term_id ),
								esc_attr( $term->slug ),
								esc_attr( $term->name ),
								$image ? wp_get_attachment_image( $image ) : '<img src="'. esc_url( WPAP_CONST_URL . 'assets/admin/images/placeholder.png' ).'" alt="'. esc_attr( $attribute_type ) .'"/>'
							);
                        }
                    }
				break;

                case 'woo-pa-plus-label-sw':
                    foreach( $terms as $term ) {
						$term_id   = $term->term_id;
						$term_slug = $term->slug;

                        if ( in_array( $term_slug, $options, true ) ) {
                            $class = ( $selected == $term_slug ) ? 'selected' : '';

							$html .= sprintf(
								'<li class="%1$s">
									<div class="woo-pa-plus-sw-wrap">
										<span class="woo-pa-plus-swatch-attribute woo-pa-plus-swatch-attr-%2$s" data-value="%3$s" data-name="%4$s">%5$s</span>
									</div>
								</li>',
								esc_attr( $class ),
								esc_attr( $term_id ),
								esc_attr( $term->slug ),
								esc_attr( $term->name ),
								esc_attr( get_term_meta( $term_id, $attribute_type, true ) ),
							);
                        }
                    }
				break;

                case 'woo-pa-plus-radio':
                    foreach( $terms as $term ) {
						$term_id   = $term->term_id;
						$term_slug = $term->slug;

                        if ( in_array( $term_slug, $options, true ) ) {
                            $class = ( $selected == $term_slug ) ? 'selected' : '';

							$html .= sprintf(
								'<li class="%1$s">
									<div class="woo-pa-plus-sw-wrap">
										<span class="woo-pa-plus-swatch-attribute woo-pa-plus-swatch-attr-%2$s" data-value="%3$s" data-name="%4$s">
											%4$s
										</span>
									</div>
								</li>',
								esc_attr( $class ),
								esc_attr( $term_id ),
								esc_attr( $term->slug ),
								esc_attr( $term->name ),
								esc_attr( $attribute_name )
							);
                        }
                    }
				break;
            }

            $html .= sprintf( '</ul>' );

            return $html;
        }

    }

}

if( !function_exists( 'woo_pa_plus_wp_plugin_single_variable_product' ) ) {

    /**
     * Returns the instance of a class.
     */
    function woo_pa_plus_wp_plugin_single_variable_product() {

        $vproduct = get_option( 'woo_pap_manage_swatch_vproduct', 'yes' );

        if( 'yes' == $vproduct ) {

            $args = [
				'size'  => get_option( 'woo_pap_vproduct_swatch_size', 'woo-pa-plus-swatch-size woo-pa-plus-swatch-size-small' ),
				'shape' => get_option( 'woo_pap_vproduct_swatch_shape', 'woo-pa-plus-swatch-shape woo-pa-plus-swatch-shape-square' ),
            ];

            return WCPAPLUS_WP_Plugin_Single_Variable_Product::get_instance( $args );
        }
    }
}

woo_pa_plus_wp_plugin_single_variable_product();
/* Omit closing PHP tag to avoid "Headers already sent" issues. */