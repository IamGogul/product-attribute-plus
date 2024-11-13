import AdminWPAPProductAttrPage from "./product-attributes-page";
import AdminWPAPVariableProductSettings from "./settings/variable-product";
import AdminWPAPColorSwatch from "./swatches/color";
import AdminWPAPImageSwatch from "./swatches/image";

class AdminWPAP {
    constructor(options) {
        this.options = $.extend(true, {
            pluginName   : product_attribute_plus_l10n.pluginName,
            pluginVersion: product_attribute_plus_l10n.pluginVersion,
        }, options );

        this._init();
    }

    _init() {
        const _self = this;

        _self.options.jQBodyEle = $("body");
        _self.options.bodyEle   = document.querySelector('body');

        new AdminWPAPProductAttrPage( _self.options );

        new AdminWPAPColorSwatch( _self.options );
        new AdminWPAPImageSwatch( _self.options );

        new AdminWPAPVariableProductSettings( _self.options );
    }
}

new AdminWPAP();