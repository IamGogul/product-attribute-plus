export default class AdminWPAPSettingsDependency {
    constructor(options) {
        this.options = $.extend(true, {
        }, options );

    }

    _handler( $handlerEle, $childEle ) {
        $handlerEle
            .on("change",function(){
                let _this     = $(this),
                    _settings = _this.closest( "tbody" ).find( $childEle ).closest( "tr" ),
                    _state    = _this.is( ":checked" );

                if( _state ) {
                    _settings.show();
                } else {
                    _settings.hide();
                }
            }).trigger("change");
    }
}