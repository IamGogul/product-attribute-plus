import AdminWPAPSettingsDependency from "./dependency";

export default class AdminWPAPVariableProductSettings {
    constructor(options) {
        this.options = $.extend(true, {
            vProductSettingsHandler  : "#product_attr_plus_manage_swatch_vproduct",
            vProductSettingsSelector : ".product-attribute-plus-manage-swatch-vproduct-field",
        }, options );

        this._init();
    }

    _init() {
        const _self = this;

        _self._swatchHandler();
    }

    _swatchHandler() {
        const _self = this;
        const {
            jQBodyEle              : $jQBodyEle,
            vProductSettingsHandler : $vProductSettingsHandler,
            vProductSettingsSelector: $vProductSettingsSelector,
        } = _self.options;

        const $ele = $($vProductSettingsHandler,$jQBodyEle);

        if( $ele.length > 0 ) {
            let dependencyClass = new AdminWPAPSettingsDependency();
            dependencyClass._handler( $ele, $vProductSettingsSelector );
        }
    }
}