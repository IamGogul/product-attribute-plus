export default class AdminWPAPProductAttrPage {
    constructor(options) {
        this.options = $.extend(true, {
            productAttrTypeSelector      : "#attribute_type",
            productAttrTypeAddFormFields : ".js-woo-pap-add-field",
            productAttrTypeEditFormFields: ".js-woo-pap-edit-field",
        }, options );

        this._init();
    }

    _init() {
        const _self = this;

        const {
            jQBodyEle                    : $jQBodyEle,
            productAttrTypeSelector      : $productAttrTypeSelector,
            productAttrTypeAddFormFields : $productAttrTypeAddFormFields,
            productAttrTypeEditFormFields: $productAttrTypeEditFormFields,
        } = _self.options;

        const $select     = $($productAttrTypeSelector,$jQBodyEle),
              $addFields  = $($productAttrTypeAddFormFields,$jQBodyEle),
              $editFields = $($productAttrTypeEditFormFields,$jQBodyEle);

        if( $select.length > 0 ) {
            $select.on("change", function(){
                let _this     = $(this),
                    _val = _this.val();

                switch( _val ) {
                    case 'product-attribute-plus-color-sw':
                        $addFields.show();
                        $editFields.show();
                    break;

                    case 'product-attribute-plus-image-sw':
                        $addFields.show();
                        $editFields.show();
                    break;

                    case 'product-attribute-plus-label-sw':
                        $addFields.show();
                        $editFields.show();
                    break;

                    default:
                        $addFields.hide();
                        $editFields.hide();
                    break;
                }
            }).trigger("change");
        }
    }
}