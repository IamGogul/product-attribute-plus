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
    }
  }]);
}();
new AdminWPAP();
})();

/******/ })()
;