import PublicWPAPUtils from "./utils";
import PublicWPAPSingleProduct from "./single-product";

class PublicWPAP {
    constructor(options) {
        this.options = $.extend(true, {
            pluginName   : woo_pa_plus_plugin_L10n.pluginName,
            pluginVersion: woo_pa_plus_plugin_L10n.pluginVersion,
        }, options );

        this._init();
    }

    _init() {
        const _self = this;

        _self.options.utils     = new PublicWPAPUtils();
        _self.options.jQBodyEle = $("body");
        _self.options.bodyEle   = document.querySelector('body');

        new PublicWPAPSingleProduct( _self.options );
    }
}

new PublicWPAP();