"use strict";
 var $ = jQuery.noConflict();
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/source/js/admin/product-attributes-page/index.js":
/*!*****************************************************************!*\
  !*** ./assets/source/js/admin/product-attributes-page/index.js ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ AdminWPAPProductAttrPage)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var AdminWPAPProductAttrPage = /*#__PURE__*/function () {
  function AdminWPAPProductAttrPage(options) {
    _classCallCheck(this, AdminWPAPProductAttrPage);
    this.options = $.extend(true, {
      productAttrTypeSelector: "#attribute_type",
      productAttrTypeAddFormFields: ".js-woo-pap-add-field",
      productAttrTypeEditFormFields: ".js-woo-pap-edit-field"
    }, options);
    this._init();
  }
  return _createClass(AdminWPAPProductAttrPage, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $jQBodyEle = _self$options.jQBodyEle,
        $productAttrTypeSelector = _self$options.productAttrTypeSelector,
        $productAttrTypeAddFormFields = _self$options.productAttrTypeAddFormFields,
        $productAttrTypeEditFormFields = _self$options.productAttrTypeEditFormFields;
      var $select = $($productAttrTypeSelector, $jQBodyEle),
        $addFields = $($productAttrTypeAddFormFields, $jQBodyEle),
        $editFields = $($productAttrTypeEditFormFields, $jQBodyEle);
      if ($select.length > 0) {
        $select.on("change", function () {
          var _this = $(this),
            _val = _this.val();
          switch (_val) {
            case 'woo-pa-plus-color-sw':
              $addFields.show();
              $editFields.show();
              break;
            case 'woo-pa-plus-image-sw':
              $addFields.show();
              $editFields.show();
              break;
            case 'woo-pa-plus-label-sw':
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
  }]);
}();


/***/ }),

/***/ "./assets/source/js/admin/settings/dependency.js":
/*!*******************************************************!*\
  !*** ./assets/source/js/admin/settings/dependency.js ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ AdminWPAPSettingsDependency)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var AdminWPAPSettingsDependency = /*#__PURE__*/function () {
  function AdminWPAPSettingsDependency(options) {
    _classCallCheck(this, AdminWPAPSettingsDependency);
    this.options = $.extend(true, {}, options);
  }
  return _createClass(AdminWPAPSettingsDependency, [{
    key: "_handler",
    value: function _handler($handlerEle, $childEle) {
      $handlerEle.on("change", function () {
        var _this = $(this),
          _settings = _this.closest("tbody").find($childEle).closest("tr"),
          _state = _this.is(":checked");
        if (_state) {
          _settings.show();
        } else {
          _settings.hide();
        }
      }).trigger("change");
    }
  }]);
}();


/***/ }),

/***/ "./assets/source/js/admin/settings/variable-product.js":
/*!*************************************************************!*\
  !*** ./assets/source/js/admin/settings/variable-product.js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ AdminWPAPVariableProductSettings)
/* harmony export */ });
/* harmony import */ var _dependency__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./dependency */ "./assets/source/js/admin/settings/dependency.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }

var AdminWPAPVariableProductSettings = /*#__PURE__*/function () {
  function AdminWPAPVariableProductSettings(options) {
    _classCallCheck(this, AdminWPAPVariableProductSettings);
    this.options = $.extend(true, {
      vProductSettingsHandler: "#woo_pap_manage_swatch_vproduct",
      vProductSettingsSelector: ".woo-pap-manage-swatch-vproduct-field"
    }, options);
    this._init();
  }
  return _createClass(AdminWPAPVariableProductSettings, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      _self._swatchHandler();
    }
  }, {
    key: "_swatchHandler",
    value: function _swatchHandler() {
      var _self = this;
      var _self$options = _self.options,
        $jQBodyEle = _self$options.jQBodyEle,
        $vProductSettingsHandler = _self$options.vProductSettingsHandler,
        $vProductSettingsSelector = _self$options.vProductSettingsSelector;
      var $ele = $($vProductSettingsHandler, $jQBodyEle);
      if ($ele.length > 0) {
        var dependencyClass = new _dependency__WEBPACK_IMPORTED_MODULE_0__["default"]();
        dependencyClass._handler($ele, $vProductSettingsSelector);
      }
    }
  }]);
}();


/***/ }),

/***/ "./assets/source/js/admin/swatches/color.js":
/*!**************************************************!*\
  !*** ./assets/source/js/admin/swatches/color.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ AdminWPAPColorSwatch)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var AdminWPAPColorSwatch = /*#__PURE__*/function () {
  function AdminWPAPColorSwatch(options) {
    _classCallCheck(this, AdminWPAPColorSwatch);
    var _self = this;
    _self.options = $.extend(true, {
      colorSwatch: ".woo-pa-plus-color-picker"
    }, options);
    $(document).ready(function () {
      _self._swatch();
    });
    $(document).ajaxComplete(_self._ajaxComplete);
  }
  return _createClass(AdminWPAPColorSwatch, [{
    key: "_swatch",
    value: function _swatch() {
      var _self = this;
      var $colorSwatch = _self.options.colorSwatch;
      var $ele = $($colorSwatch);
      if ($ele.length > 0) {
        $ele.wpColorPicker();
      }
    }
  }, {
    key: "_ajaxComplete",
    value: function _ajaxComplete(event, request, options) {
      if (!options.hasOwnProperty('data')) {
        return;
      }
      if (0 <= options.data.indexOf('woo-pa-plus-color-sw')) {
        if (request && 4 === request.readyState && 200 === request.status && options.data && 0 <= options.data.indexOf('action=add-tag')) {
          var $res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
          if (!$res || $res.errors) {
            return;
          }
        }
        $(".wp-color-result").removeAttr('style');
        $(".wp-picker-clear").trigger('click');
      }
    }
  }]);
}();


/***/ }),

/***/ "./assets/source/js/admin/swatches/image.js":
/*!**************************************************!*\
  !*** ./assets/source/js/admin/swatches/image.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ AdminWPAPImageSwatch)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var AdminWPAPImageSwatch = /*#__PURE__*/function () {
  function AdminWPAPImageSwatch(options) {
    _classCallCheck(this, AdminWPAPImageSwatch);
    var _self = this;
    _self.options = $.extend(true, {
      imgSwatchBtn: ".attribute-screen.woo-pa-plus-sw-image-button",
      imgSwatchRemoveBtn: ".attribute-screen.woo-pa-plus-sw-image-img-remove"
    }, options);
    $(document).ready(function () {
      _self.options.jQBodyEle = $("body");
      _self._init();
    });
    $(document).ajaxComplete(_self._ajaxComplete);
  }
  return _createClass(AdminWPAPImageSwatch, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      var _self$options = _self.options,
        $imgSwatchBtn = _self$options.imgSwatchBtn,
        $imgSwatchRemoveBtn = _self$options.imgSwatchRemoveBtn;
      _self._imgSwatchBtnHandler($imgSwatchBtn);
      _self._imgSwatchRemoveHandler($imgSwatchRemoveBtn);
    }
  }, {
    key: "_imgSwatchBtnHandler",
    value: function _imgSwatchBtnHandler($ele) {
      var $frame;
      $("body").on("click", $ele, function ($event) {
        $event.preventDefault();
        var $el = $(this);

        // If the media frame already exists, reopen it.
        if ($frame) {
          $frame.open();
          return;
        }

        // Create the media frame.
        $frame = wp.media({
          title: $el.data('title'),
          multiple: false,
          library: {
            type: 'image'
          },
          button: {
            text: $el.data('button')
          }
        });

        // When an image is selected, run a callback.
        $frame.on("select", function () {
          var $attachment = $frame.state().get('selection').first().toJSON(),
            $attachment_image = $attachment.sizes.thumbnail ? $attachment.sizes.thumbnail.url : $attachment.url;
          var $attachment_id = $attachment.id,
            $image_html = '<div class="woo-pa-plus-sw-image-img-holder">' + '<div class="woo-pa-plus-sw-image-img">' + '<img src="' + $attachment_image + '"/>' + '<a href="javascript:void(0);" class="attribute-screen woo-pa-plus-sw-image-img-remove" title="' + $el.data('remove') + '"></a>' + '</div>';
          '</div>';
          $el.siblings('input.woo-pa-plus-sw-image-id').val($attachment_id);
          $($image_html).insertBefore($el.parent());
          setTimeout(function () {
            $el.addClass('hidden');
          }, 10);
        });

        // Finally, open the modal.
        $frame.open();
      });
    }
  }, {
    key: "_imgSwatchRemoveHandler",
    value: function _imgSwatchRemoveHandler($ele) {
      $("body").on("click", $ele, function ($event) {
        $event.preventDefault();
        var $el = $(this),
          $imgPicker = $el.parents(".woo-pa-plus-sw-image-img-holder").next(".woo-pa-plus-sw-image-img-picker");
        $imgPicker.find(".woo-pa-plus-sw-image-id").val("");
        $imgPicker.find(".woo-pa-plus-sw-image-button").removeClass("hidden");
        $el.parents(".woo-pa-plus-sw-image-img-holder").remove();
      });
    }
  }, {
    key: "_ajaxComplete",
    value: function _ajaxComplete(event, request, options) {
      if (!options.hasOwnProperty('data')) {
        return;
      }
      console.log(options.data);
      if (0 <= options.data.indexOf('woo-pa-plus-image-sw')) {
        if (request && 4 === request.readyState && 200 === request.status && options.data && 0 <= options.data.indexOf('action=add-tag')) {
          var $res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
          if (!$res || $res.errors) {
            return;
          }
          $('input.woo-pa-plus-sw-image-id').val('');
          $('.woo-pa-plus-sw-image-img-holder').remove();
          $('.woo-pa-plus-sw-image-button').removeClass("hidden");
        }
      }
    }
  }]);
}();


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*****************************************!*\
  !*** ./assets/source/js/admin/index.js ***!
  \*****************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _product_attributes_page__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./product-attributes-page */ "./assets/source/js/admin/product-attributes-page/index.js");
/* harmony import */ var _settings_variable_product__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./settings/variable-product */ "./assets/source/js/admin/settings/variable-product.js");
/* harmony import */ var _swatches_color__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./swatches/color */ "./assets/source/js/admin/swatches/color.js");
/* harmony import */ var _swatches_image__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./swatches/image */ "./assets/source/js/admin/swatches/image.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }




var AdminWPAP = /*#__PURE__*/function () {
  function AdminWPAP(options) {
    _classCallCheck(this, AdminWPAP);
    this.options = $.extend(true, {
      pluginName: woo_pa_plus_plugin_L10n.pluginName,
      pluginVersion: woo_pa_plus_plugin_L10n.pluginVersion
    }, options);
    this._init();
  }
  return _createClass(AdminWPAP, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      _self.options.jQBodyEle = $("body");
      _self.options.bodyEle = document.querySelector('body');
      new _product_attributes_page__WEBPACK_IMPORTED_MODULE_0__["default"](_self.options);
      new _swatches_color__WEBPACK_IMPORTED_MODULE_2__["default"](_self.options);
      new _swatches_image__WEBPACK_IMPORTED_MODULE_3__["default"](_self.options);
      new _settings_variable_product__WEBPACK_IMPORTED_MODULE_1__["default"](_self.options);
    }
  }]);
}();
new AdminWPAP();
})();

/******/ })()
;