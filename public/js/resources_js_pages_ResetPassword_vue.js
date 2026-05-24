"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pages_ResetPassword_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ResetPassword.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ResetPassword.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helpers/helpers */ "./resources/js/helpers/helpers.js");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



var _createNamespacedHelp = (0,vuex__WEBPACK_IMPORTED_MODULE_1__.createNamespacedHelpers)('auth'),
    mapActions = _createNamespacedHelp.mapActions;

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      isLoading: false,
      passStatus1: 0,
      passStatus2: 0,
      passStatus3: 0,
      passStatus4: 0,
      passStatus5: 0,
      changePassword: {
        confirmPassword: '',
        password: '',
        findmeId: ''
      }
    };
  },
  methods: _objectSpread(_objectSpread({}, mapActions(['savePasswordResetDetails'])), {}, {
    showPassword: function showPassword() {
      _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].showPassword(document.getElementById("pass"));
    },
    submitPassword: function submitPassword() {
      var _this = this;

      this.changePassword.findmeId = 'e-' + this.changePassword.findmeId;

      if (this.passStatus1 != 1 && this.passStatus2 != 1 && this.passStatus3 != 1 && this.passStatus4 != 1 && this.passStatus5 != 1) {
        if (this.changePassword.confirmPassword == this.changePassword.password) {
          this.isLoading = true;
          var user = this.changePassword;
          this.savePasswordResetDetails(user).then(function (res) {
            _this.isLoading = false;
            _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].successAlert("Updated");

            _this.$router.push({
              path: "/index"
            });
          })["catch"](function (error) {
            _this.isLoading = false;
            _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].errorMessage(error);
          });
        } else {
          return _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].errorAlert("Confirm password don't match");
        }
      } else {
        return _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].errorAlert("Invalid password");
      }
    },
    // When the user clicks on the password field, show the message box
    focus: function focus() {
      document.getElementById("message").style.display = "block";
    },
    // When the user clicks outside of the password field, hide the message box
    blur: function blur() {
      document.getElementById("message").style.display = "none";
    },
    // When the user starts to type something inside the password field
    keyUp: function keyUp() {
      // var myInput = document.getElementById("password");
      var myInput = this.changePassword.password;
      var letter = document.getElementById("letter");
      var capital = document.getElementById("capital");
      var number = document.getElementById("number");
      var length = document.getElementById("length");
      var special = document.getElementById("special"); // Validate lowercase letters

      var lowerCaseLetters = /[a-z]/g;

      if (myInput.match(lowerCaseLetters)) {
        letter.classList.remove("invalid");
        letter.classList.add("valid");
        this.passStatus1 = 0;
      } else {
        letter.classList.remove("valid");
        letter.classList.add("invalid");
        this.passStatus1 = 1;
      } // Validate capital letters


      var upperCaseLetters = /[A-Z]/g;

      if (myInput.match(upperCaseLetters)) {
        capital.classList.remove("invalid");
        capital.classList.add("valid");
        this.passStatus2 = 0;
      } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");
        this.passStatus2 = 1;
      } // Validate numbers


      var numbers = /[0-9]/g;

      if (myInput.match(numbers)) {
        number.classList.remove("invalid");
        number.classList.add("valid");
        this.passStatus3 = 0;
      } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
        this.passStatus3 = 1;
      } // Validate length


      if (myInput.length >= 8) {
        length.classList.remove("invalid");
        length.classList.add("valid");
        this.passStatus4 = 0;
      } else {
        length.classList.remove("valid");
        length.classList.add("invalid");
        this.passStatus4 = 1;
      } // Validate Special caracter


      var specialChar = /(_|[^\w\d ])/;

      if (myInput.match(specialChar)) {
        special.classList.remove("invalid");
        special.classList.add("valid");
        this.passStatus5 = 0;
      } else {
        special.classList.remove("valid");
        special.classList.add("invalid");
        this.passStatus5 = 1;
      }
    },
    //end pass validation
    clear: function clear() {
      this.changePassword.password = "";
      this.changePassword.findmeId = '';
      this.passStatus1 = 0;
      this.passStatus2 = 0;
      this.passStatus3 = 0;
      this.passStatus4 = 0;
      this.passStatus5 = 0;
    },
    reset: function reset() {}
  }),
  created: function created() {}
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ResetPassword.vue?vue&type=style&index=0&id=31fcdd5e&scoped=true&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ResetPassword.vue?vue&type=style&index=0&id=31fcdd5e&scoped=true&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n#message[data-v-31fcdd5e] {\n  display:none;\n  background: #f1f1f1;\n  color: #000;\n  position: relative;\n  padding: 20px;\n  margin-top: 10px;\n}\n#message p[data-v-31fcdd5e] {\n  padding: 10px 35px;\n  font-size: 18px;\n}\n\n/* Add a green text color and a checkmark when the requirements are right */\n.valid[data-v-31fcdd5e] {\n  color: green;\n}\n.valid[data-v-31fcdd5e]:before {\n  position: relative;\n  left: -35px;\n  content: \"✔\";\n}\n\n/* Add a red text color and an \"x\" when the requirements are wrong */\n.invalid[data-v-31fcdd5e] {\n  color: red;\n}\n.invalid[data-v-31fcdd5e]:before {\n  position: relative;\n  left: -35px;\n  content: \"✖\";\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ResetPassword.vue?vue&type=style&index=0&id=31fcdd5e&scoped=true&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ResetPassword.vue?vue&type=style&index=0&id=31fcdd5e&scoped=true&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_style_index_0_id_31fcdd5e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ResetPassword.vue?vue&type=style&index=0&id=31fcdd5e&scoped=true&lang=css& */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ResetPassword.vue?vue&type=style&index=0&id=31fcdd5e&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_style_index_0_id_31fcdd5e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_style_index_0_id_31fcdd5e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/pages/ResetPassword.vue":
/*!**********************************************!*\
  !*** ./resources/js/pages/ResetPassword.vue ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ResetPassword_vue_vue_type_template_id_31fcdd5e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ResetPassword.vue?vue&type=template&id=31fcdd5e&scoped=true& */ "./resources/js/pages/ResetPassword.vue?vue&type=template&id=31fcdd5e&scoped=true&");
/* harmony import */ var _ResetPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ResetPassword.vue?vue&type=script&lang=js& */ "./resources/js/pages/ResetPassword.vue?vue&type=script&lang=js&");
/* harmony import */ var _ResetPassword_vue_vue_type_style_index_0_id_31fcdd5e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ResetPassword.vue?vue&type=style&index=0&id=31fcdd5e&scoped=true&lang=css& */ "./resources/js/pages/ResetPassword.vue?vue&type=style&index=0&id=31fcdd5e&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _ResetPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ResetPassword_vue_vue_type_template_id_31fcdd5e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ResetPassword_vue_vue_type_template_id_31fcdd5e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "31fcdd5e",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/ResetPassword.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/ResetPassword.vue?vue&type=script&lang=js&":
/*!***********************************************************************!*\
  !*** ./resources/js/pages/ResetPassword.vue?vue&type=script&lang=js& ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ResetPassword.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ResetPassword.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/ResetPassword.vue?vue&type=style&index=0&id=31fcdd5e&scoped=true&lang=css&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/pages/ResetPassword.vue?vue&type=style&index=0&id=31fcdd5e&scoped=true&lang=css& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_style_index_0_id_31fcdd5e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ResetPassword.vue?vue&type=style&index=0&id=31fcdd5e&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ResetPassword.vue?vue&type=style&index=0&id=31fcdd5e&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/pages/ResetPassword.vue?vue&type=template&id=31fcdd5e&scoped=true&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/pages/ResetPassword.vue?vue&type=template&id=31fcdd5e&scoped=true& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_template_id_31fcdd5e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_template_id_31fcdd5e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ResetPassword_vue_vue_type_template_id_31fcdd5e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ResetPassword.vue?vue&type=template&id=31fcdd5e&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ResetPassword.vue?vue&type=template&id=31fcdd5e&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ResetPassword.vue?vue&type=template&id=31fcdd5e&scoped=true&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ResetPassword.vue?vue&type=template&id=31fcdd5e&scoped=true& ***!
  \********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "container-fluid px-3" }, [
    _c("div", { staticClass: "row min-vh-100" }, [
      _c(
        "div",
        { staticClass: "col-md-8 col-lg-6 col-xl-5 d-flex align-items-center" },
        [
          _c(
            "div",
            { staticClass: "w-100 py-5 px-md-5 px-xxl-6 position-relative" },
            [
              _vm._m(0),
              _vm._v(" "),
              _c(
                "form",
                {
                  staticClass: "form-validate",
                  on: {
                    submit: function ($event) {
                      $event.preventDefault()
                      return _vm.submitPassword.apply(null, arguments)
                    },
                  },
                },
                [
                  _c("div", { staticClass: "mb-4" }, [
                    _c(
                      "label",
                      { staticClass: "form-label", attrs: { for: "findMeId" } },
                      [_vm._v("Please Enter Your FindMe ID")]
                    ),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.changePassword.findmeId,
                          expression: "changePassword.findmeId",
                        },
                      ],
                      staticClass: "form-control",
                      attrs: {
                        name: "findMeId",
                        id: "findMeId",
                        type: "text",
                        placeholder: "findme ID",
                        autocomplete: "off",
                        required: "",
                        "data-msg": "Please enter your findme ID without (e-)",
                      },
                      domProps: { value: _vm.changePassword.findmeId },
                      on: {
                        input: function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.changePassword,
                            "findmeId",
                            $event.target.value
                          )
                        },
                      },
                    }),
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "mb-4" }, [
                    _c(
                      "label",
                      { staticClass: "form-label", attrs: { for: "password" } },
                      [_vm._v("Please Enter Your New Password")]
                    ),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.changePassword.password,
                          expression: "changePassword.password",
                        },
                      ],
                      staticClass: "form-control",
                      attrs: {
                        name: "password",
                        id: "password",
                        placeholder: "Password",
                        type: "password",
                        required: "",
                        "data-msg": "Please enter your password",
                      },
                      domProps: { value: _vm.changePassword.password },
                      on: {
                        keyup: _vm.keyUp,
                        change: _vm.keyUp,
                        blur: _vm.blur,
                        focus: _vm.focus,
                        input: function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.changePassword,
                            "password",
                            $event.target.value
                          )
                        },
                      },
                    }),
                  ]),
                  _vm._v(" "),
                  _vm._m(1),
                  _vm._v(" "),
                  _c("div", { staticClass: "mb-4" }, [
                    _c(
                      "label",
                      { staticClass: "form-label", attrs: { for: "confPass" } },
                      [_vm._v("Confirm Your New Password")]
                    ),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.changePassword.confirmPassword,
                          expression: "changePassword.confirmPassword",
                        },
                      ],
                      staticClass: "form-control",
                      attrs: {
                        name: "confPass",
                        id: "confPass",
                        placeholder: "Confirm Password",
                        type: "password",
                        required: "",
                        "data-msg": "Please confirm your password",
                      },
                      domProps: { value: _vm.changePassword.confirmPassword },
                      on: {
                        input: function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.changePassword,
                            "confirmPassword",
                            $event.target.value
                          )
                        },
                      },
                    }),
                  ]),
                  _vm._v(" "),
                  _vm._m(2),
                ]
              ),
              _vm._v(" "),
              _c(
                "router-link",
                {
                  staticClass: "close-absolute me-md-5 me-xl-6 pt-5",
                  attrs: { to: "/" },
                },
                [
                  _c("svg", { staticClass: "svg-icon w-3rem h-3rem" }, [
                    _c("use", { attrs: { "xlink:href": "#close-1" } }),
                  ]),
                ]
              ),
            ],
            1
          ),
        ]
      ),
      _vm._v(" "),
      _vm._m(3),
    ]),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "mb-5" }, [
      _c("img", {
        staticClass: "img-fluid mb-3",
        staticStyle: { "max-width": "4rem" },
        attrs: { src: "assets/img/logo-square.svg", alt: "..." },
      }),
      _vm._v(" "),
      _c("h2", [_vm._v("Hi ")]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "row", attrs: { id: "message" } }, [
      _c("h3", [_vm._v("Password must contain the following:")]),
      _vm._v(" "),
      _c("p", { staticClass: "invalid", attrs: { id: "letter" } }, [
        _vm._v("A "),
        _c("b", [_vm._v("lowercase")]),
        _vm._v(" letter"),
      ]),
      _vm._v(" "),
      _c("p", { staticClass: "invalid", attrs: { id: "capital" } }, [
        _vm._v("A "),
        _c("b", [_vm._v("capital (uppercase)")]),
        _vm._v(" letter"),
      ]),
      _vm._v(" "),
      _c("p", { staticClass: "invalid", attrs: { id: "number" } }, [
        _vm._v("A "),
        _c("b", [_vm._v("number")]),
      ]),
      _vm._v(" "),
      _c("p", { staticClass: "invalid", attrs: { id: "length" } }, [
        _vm._v("Minimum "),
        _c("b", [_vm._v("8 characters")]),
      ]),
      _vm._v(" "),
      _c("p", { staticClass: "invalid", attrs: { id: "special" } }, [
        _vm._v("A "),
        _c("b", [_vm._v(" special character")]),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "d-grid" }, [
      _c("button", { staticClass: "btn btn-lg btn-primary" }, [
        _vm._v("Submit"),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "col-md-4 col-lg-6 col-xl-7 d-none d-md-block" },
      [
        _c("div", {
          staticClass: "bg-cover h-100 me-n3",
          staticStyle: {
            "background-image":
              "url(assets/img/photo/photo-1497436072909-60f360e1d4b1.jpg)",
          },
        }),
      ]
    )
  },
]
render._withStripped = true



/***/ })

}]);