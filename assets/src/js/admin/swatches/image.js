export default class AdminWPAPImageSwatch {
    constructor(options) {
        const _self = this;

        _self.options = $.extend(true, {
            imgSwatchBtn      : ".attribute-screen.product-attribute-plus-sw-image-button",
            imgSwatchRemoveBtn: ".attribute-screen.product-attribute-plus-sw-image-img-remove",
        }, options );

        $(document).ready(function(){
            _self.options.jQBodyEle = $("body");
            _self._init();
        });

        $(document).ajaxComplete( _self._ajaxComplete );
    }

    _init() {
        const _self = this;

        const {
            imgSwatchBtn      : $imgSwatchBtn,
            imgSwatchRemoveBtn: $imgSwatchRemoveBtn,
        } = _self.options;

        _self._imgSwatchBtnHandler( $imgSwatchBtn );
        _self._imgSwatchRemoveHandler( $imgSwatchRemoveBtn );
    }

    _imgSwatchBtnHandler( $ele ) {
        var $frame;

        $("body").on("click", $ele, function($event){
            $event.preventDefault();

            var $el = $( this );

			// If the media frame already exists, reopen it.
			if ( $frame ) {
				$frame.open();
				return;
			}

			// Create the media frame.
			$frame = wp.media({
				title 	 : $el.data( 'title' ),
				multiple : false,
				library  : {
					type : 'image'
				},
				button 	 : {
					text : $el.data( 'button' )
				}
			});

            // When an image is selected, run a callback.
            $frame.on("select", function(){
				var $attachment       = $frame.state().get( 'selection' ).first().toJSON(),
                    $attachment_image = $attachment.sizes.thumbnail ? $attachment.sizes.thumbnail.url : $attachment.url;

                var $attachment_id = $attachment.id,
                    $image_html    = '<div class="product-attribute-plus-sw-image-img-holder">' +
                        '<div class="product-attribute-plus-sw-image-img">' +
                            '<img src="'+$attachment_image+'"/>' +
                            '<a href="javascript:void(0);" class="attribute-screen product-attribute-plus-sw-image-img-remove" title="' + $el.data('remove') + '"></a>' +
                        '</div>';
                    '</div>';

                $el.siblings( 'input.product-attribute-plus-sw-image-id' ).val( $attachment_id );
                $( $image_html ).insertBefore( $el.parent() );

				setTimeout(function(){
					$el.addClass('hidden');
				}, 10);
			});

            // Finally, open the modal.
			$frame.open();
        });
    }

    _imgSwatchRemoveHandler( $ele ) {
        $("body").on("click", $ele, function($event){
            $event.preventDefault();
            var $el        = $( this ),
                $imgPicker = $el.parents(".product-attribute-plus-sw-image-img-holder").next(".product-attribute-plus-sw-image-img-picker");

            $imgPicker.find(".product-attribute-plus-sw-image-id").val("");
            $imgPicker.find(".product-attribute-plus-sw-image-button").removeClass("hidden");
            $el.parents(".product-attribute-plus-sw-image-img-holder").remove();
        });
    }

    _ajaxComplete( event, request, options ) {
		if( !options.hasOwnProperty( 'data') ) {
			return;
		}

        console.log( options.data );

        if( 0 <= options.data.indexOf('product-attribute-plus-image-sw') ) {

			if ( request && 4 === request.readyState && 200 === request.status
				&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

				var $res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
				if ( ! $res || $res.errors ) {
					return;
				}

                $('input.product-attribute-plus-sw-image-id' ).val('');
                $('.product-attribute-plus-sw-image-img-holder').remove();
                $('.product-attribute-plus-sw-image-button').removeClass("hidden");
			}
        }
    }
}