export default class PublicWPAPSingleProduct {
    constructor(options) {
        this.options = $.extend(true, {
            singleProduct              : $("body.single-product"),
            resetSingleProductVariation: "a.reset_variations",
        }, options );

        this._init();
    }

    _init() {
        const _self = this;

        _self._swatchSelect();
        _self._resetVariation();
        _self._wc_update_variation_vals();
    }

    _swatchSelect() {
        const _self = this;

        const {
            singleProduct: $singleProduct,
            utils        : $utils,
        } = _self.options;

        $singleProduct.on("click","form.variations_form .woo-pa-plus-swatch-attribute",function(){
            var $this      = $(this),
                $attribute = $this.closest("[data-attribute]").data("attribute"),
                $select    = document.getElementById( $attribute ), // $("select#"+$attribute ), - it has issues in other languages ( jquery selector doesn't accepts special chars )
                $select    = $( $select ),
                $name      = $this.data("name"),
                $value     = $this.data("value"),
                $li        = $this.parents("li");

            let $hasSelected = $utils._isBool( $utils._hasState( $li, 'selected' ) );

            if( $hasSelected ) {
                $utils._removeState( $li, 'selected' );
                $select.val(" ");
            } else {
                let $siblings = $utils._setStateAndSiblings( $li, 'selected' );
                $utils._removeState( $siblings, 'selected' );

                $select.val($value);
            }

            $select.trigger("change");
        });
    }

    _resetVariation() {
        const _self = this;
        const {
            singleProduct              : $singleProduct,
            resetSingleProductVariation: $resetSingleProductVariation,
            utils                      : $utils,
        } = _self.options;

        $singleProduct.on("click",$resetSingleProductVariation,function(){
            var $selected = $(this).closest('form.variations_form').find("ul.woo-pa-plus-swatch li.selected");
            $utils._removeState( $selected, 'selected' );
        });
    }

    _wc_update_variation_vals() {
        const _self = this;
        const {
            singleProduct: $singleProduct,
            utils        : $utils,
        } = _self.options;

        $singleProduct.find("form.variations_form").on('woocommerce_update_variation_values', function(){
            $(this).find("ul.woo-pa-plus-swatch").each(function(){
				var	$this      = this,
					$attribute = $($this).data("attribute"),
					$select    = document.getElementById( $attribute ), // $("select#"+$attribute ), - it has issues in other languages ( jquery selector doesn't accepts special chars )
					$options   = $($select).find("option"),
					$eq   	   = $($select).find("option").eq(1),
					$li 	   = $($this).find("li"),
					$current   = $($select).find("option:selected"),
					$selects   = [],
					$selected  = '';

                $options.each(function(){
                    if ($(this).val() !== '') {
                        $selects.push( $(this).val() );
                        $selected = $current ? $current.val() : $eq.val();
                    }
                });

                $li.each(function(){
					var $this = this,
						$value = $($this).find(".woo-pa-plus-swatch-attribute").attr("data-value");

                    $($this).removeClass("selected woo-pa-plus-li-disabled").addClass("woo-pa-plus-li-disabled");

                    if( $selects.indexOf( $value ) !== -1 ) {
                        $($this).removeClass("woo-pa-plus-li-disabled");
						if( $value == $selected ) {
							$($this).addClass("selected");
						}
                    }
                });
            });
        });
    }
}