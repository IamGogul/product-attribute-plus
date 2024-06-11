"use strict";
 var $ = jQuery.noConflict();
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/js/public/single-product.js":
/*!************************************************!*\
  !*** ./assets/src/js/public/single-product.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ PublicWPAPSingleProduct)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var PublicWPAPSingleProduct = /*#__PURE__*/function () {
  function PublicWPAPSingleProduct(options) {
    _classCallCheck(this, PublicWPAPSingleProduct);
    this.options = $.extend(true, {
      singleProduct: $("body.single-product"),
      resetSingleProductVariation: "a.reset_variations"
    }, options);
    this._init();
  }
  return _createClass(PublicWPAPSingleProduct, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      _self._swatchSelect();
      _self._resetVariation();
      _self._wc_update_variation_vals();
    }
  }, {
    key: "_swatchSelect",
    value: function _swatchSelect() {
      var _self = this;
      var _self$options = _self.options,
        $singleProduct = _self$options.singleProduct,
        $utils = _self$options.utils;
      $singleProduct.on("click", "form.variations_form .woo-pa-plus-swatch-attribute", function () {
        var $this = $(this),
          $attribute = $this.closest("[data-attribute]").data("attribute"),
          $select = document.getElementById($attribute),
          // $("select#"+$attribute ), - it has issues in other languages ( jquery selector doesn't accepts special chars )
          $select = $($select),
          $name = $this.data("name"),
          $value = $this.data("value"),
          $li = $this.parents("li");
        var $hasSelected = $utils._isBool($utils._hasState($li, 'selected'));
        if ($hasSelected) {
          $utils._removeState($li, 'selected');
          $select.val(" ");
        } else {
          var $siblings = $utils._setStateAndSiblings($li, 'selected');
          $utils._removeState($siblings, 'selected');
          $select.val($value);
        }
        $select.trigger("change");
      });
    }
  }, {
    key: "_resetVariation",
    value: function _resetVariation() {
      var _self = this;
      var _self$options2 = _self.options,
        $singleProduct = _self$options2.singleProduct,
        $resetSingleProductVariation = _self$options2.resetSingleProductVariation,
        $utils = _self$options2.utils;
      $singleProduct.on("click", $resetSingleProductVariation, function () {
        var $selected = $(this).closest('form.variations_form').find("ul.woo-pa-plus-swatch li.selected");
        $utils._removeState($selected, 'selected');
      });
    }
  }, {
    key: "_wc_update_variation_vals",
    value: function _wc_update_variation_vals() {
      var _self = this;
      var _self$options3 = _self.options,
        $singleProduct = _self$options3.singleProduct,
        $utils = _self$options3.utils;
      $singleProduct.find("form.variations_form").on('woocommerce_update_variation_values', function () {
        $(this).find("ul.woo-pa-plus-swatch").each(function () {
          var $this = this,
            $attribute = $($this).data("attribute"),
            $select = document.getElementById($attribute),
            // $("select#"+$attribute ), - it has issues in other languages ( jquery selector doesn't accepts special chars )
            $options = $($select).find("option"),
            $eq = $($select).find("option").eq(1),
            $li = $($this).find("li"),
            $current = $($select).find("option:selected"),
            $selects = [],
            $selected = '';
          $options.each(function () {
            if ($(this).val() !== '') {
              $selects.push($(this).val());
              $selected = $current ? $current.val() : $eq.val();
            }
          });
          $li.each(function () {
            var $this = this,
              $value = $($this).find(".woo-pa-plus-swatch-attribute").attr("data-value");
            $($this).removeClass("selected woo-pa-plus-li-disabled").addClass("woo-pa-plus-li-disabled");
            if ($selects.indexOf($value) !== -1) {
              $($this).removeClass("woo-pa-plus-li-disabled");
              if ($value == $selected) {
                $($this).addClass("selected");
              }
            }
          });
        });
      });
    }
  }]);
}();


/***/ }),

/***/ "./assets/src/js/public/utils.js":
/*!***************************************!*\
  !*** ./assets/src/js/public/utils.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ PublicWPAPUtils)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var PublicWPAPUtils = /*#__PURE__*/function () {
  function PublicWPAPUtils(options) {
    _classCallCheck(this, PublicWPAPUtils);
    this.options = $.extend(true, {}, options);
  }
  return _createClass(PublicWPAPUtils, [{
    key: "_console",
    value: function _console($arg) {
      console.log($arg);
    }
  }, {
    key: "_isBool",
    value: function _isBool($arg) {
      switch ($arg) {
        case true:
        case "true":
        case "TRUE":
        case 1:
        case "1":
        case "on":
        case "ON":
        case "yes":
        case "YES":
          return true;
        default:
          return false;
      }
    }
  }, {
    key: "_setState",
    value: function _setState($ele, $state) {
      $($ele).addClass($state);
    }
  }, {
    key: "_setStateAndSiblings",
    value: function _setStateAndSiblings($ele, $state) {
      return $($ele).addClass($state).siblings();
    }
  }, {
    key: "_removeState",
    value: function _removeState($ele, $state) {
      $($ele).removeClass($state);
    }
  }, {
    key: "_hasState",
    value: function _hasState($ele, $state) {
      return $($ele).hasClass($state);
    }
  }, {
    key: "_toggleState",
    value: function _toggleState($ele, $state) {
      $($ele).toggleClass($state);
    }
  }, {
    key: "_setCookie",
    value: function _setCookie($name, $value, $days) {
      var $secureFlag = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;
      var $sameSiteFlag = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : 'None';
      return function ($days) {
        var $expires = "";
        var $days = $days ? $days : 7;
        console.log($days);
        console.log($secureFlag);
        console.log($sameSiteFlag);
        if ($days) {
          var date = new Date();
          date.setTime(date.getTime() + $days * 24 * 60 * 60 * 1000);
          $expires = "; expires=" + date.toUTCString();
        }

        // Add Secure attribute if the secureFlag is true
        var $secureAttribute = $secureFlag ? '; Secure' : '';

        // Add SameSite attribute
        var $sameSiteAttribute = "; SameSite=".concat($sameSiteFlag);
        document.cookie = $name + "=" + $value + $expires + "; path=/" + $secureAttribute + $sameSiteAttribute;
      }($days);
    }
  }, {
    key: "_getCookie",
    value: function _getCookie($name) {
      var nameEQ = $name + "=";
      var cookies = document.cookie.split(';');
      for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        while (cookie.charAt(0) == ' ') {
          cookie = cookie.substring(1, cookie.length);
        }
        if (cookie.indexOf(nameEQ) == 0) {
          return cookie.substring(nameEQ.length, cookie.length);
        }
      }
      return null;
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
/*!***************************************!*\
  !*** ./assets/src/js/public/index.js ***!
  \***************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils */ "./assets/src/js/public/utils.js");
/* harmony import */ var _single_product__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./single-product */ "./assets/src/js/public/single-product.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }


var PublicWPAP = /*#__PURE__*/function () {
  function PublicWPAP(options) {
    _classCallCheck(this, PublicWPAP);
    this.options = $.extend(true, {
      pluginName: woo_pa_plus_plugin_L10n.pluginName,
      pluginVersion: woo_pa_plus_plugin_L10n.pluginVersion
    }, options);
    this._init();
  }
  return _createClass(PublicWPAP, [{
    key: "_init",
    value: function _init() {
      var _self = this;
      _self.options.utils = new _utils__WEBPACK_IMPORTED_MODULE_0__["default"]();
      _self.options.jQBodyEle = $("body");
      _self.options.bodyEle = document.querySelector('body');
      new _single_product__WEBPACK_IMPORTED_MODULE_1__["default"](_self.options);
    }
  }]);
}();
new PublicWPAP();
})();

/******/ })()
;