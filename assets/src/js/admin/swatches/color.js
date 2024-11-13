export default class AdminWPAPColorSwatch {
    constructor(options) {
        const _self = this;

        _self.options = $.extend(true, {
            colorSwatch : ".product-attribute-plus-color-picker",
        }, options );

        $(document).ready(function(){
            _self._swatch();
        });

        $(document).ajaxComplete( _self._ajaxComplete );
    }

    _swatch() {
        const _self = this;

        const {
            colorSwatch: $colorSwatch,
        } = _self.options;

        const $ele = $($colorSwatch);

        if( $ele.length > 0 ) {
            $ele.wpColorPicker();
        }
    }

    _ajaxComplete( event, request, options ) {
		if( !options.hasOwnProperty( 'data') ) {
			return;
		}

        if( 0 <= options.data.indexOf('product-attribute-plus-color-sw') ) {

			if ( request && 4 === request.readyState && 200 === request.status
				&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

				var $res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
				if ( ! $res || $res.errors ) {
					return;
				}
			}

            $(".wp-color-result").removeAttr('style');
            $(".wp-picker-clear").trigger('click');
        }
    }
}