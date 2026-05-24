"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pages_Register_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Register.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Register.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./../helpers/helpers */ "./resources/js/helpers/helpers.js");
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
    mapActions = _createNamespacedHelp.mapActions,
    mapGetters = _createNamespacedHelp.mapGetters;

var _createNamespacedHelp2 = (0,vuex__WEBPACK_IMPORTED_MODULE_1__.createNamespacedHelpers)('inventory'),
    mapActionsForInventory = _createNamespacedHelp2.mapActions;

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      isLoading: false,
      numStatus: 0,
      userStatus: 0,
      passStatus: 0,
      showMapStatus: 0,
      showNamesStatus: 0,
      vuePhoneProps: {
        clearable: true,
        fetchCountry: true,
        required: true,
        defaultCountry: "GH",
        preferredCountries: ["NG", "GH"],
        noExample: false,
        translations: {
          countrySelectorLabel: "Country code",
          countrySelectorError: "Error",
          phoneNumberLabel: "Enter your phone",
          example: "Example:"
        }
      },
      vueTelProps: {
        // mode: "international",
        defaultCountry: "GH",
        placeholder: "Enter a phone number",
        required: true,
        preferredCountries: ["GH", "NG"]
      },
      categories: [],
      userName: {
        name: '',
        country_code: ''
      },
      user: {
        email: "",
        password: "",
        password2: "",
        phone: '',
        country: '',
        first_name: '',
        middle_name: '',
        last_name: '',
        gh_card_id: '',
        remember_me: false,
        country_code: '',
        dial_code: ''
      }
    };
  },
  computed: _objectSpread({}, mapGetters(['getUserName'])),
  methods: _objectSpread(_objectSpread({}, mapActions(['registerAction', 'userNameAction'])), {}, {
    showPassword: function showPassword() {
      _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].showPassword(document.getElementById("password"));
    },
    validateNumber: function validateNumber(num) {
      // Validate lowercase letters
      var lowerCaseLetters = /[a-z]/g;

      if (num.match(lowerCaseLetters)) {
        return false;
      } // Validate capital letters


      var upperCaseLetters = /[A-Z]/g;

      if (num.match(upperCaseLetters)) {
        return false;
      } // Validate Special caracter


      var specialChar = /(_|[^\w\d ])/;

      if (num.match(specialChar)) {
        return false;
      }

      return true;
    },
    checkNumber: function checkNumber(_ref) {
      var number = _ref.number,
          isValid = _ref.isValid,
          country = _ref.country;
      // console.log(number, isValid, country);
      this.numStatus = 0; // this.user.country = country.name
      // this.user.dial_code = country.dialCode
      // this.user.country_code = country.iso2

      this.user.country = country ? country.name : '';
      this.user.dial_code = country ? country.dialCode : '';
      this.user.country_code = country ? country.iso2 : '';
      var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;

      if (this.user.phone != '') {
        if (this.user.phone.length < 9) {
          document.getElementById("num_val").style.display = "block";
          $('#num_error').html('invalid contact');
          this.numStatus = 1;
        } else {
          // if(re.test(this.user.phone)){
          if (this.validateNumber(this.user.phone)) {
            document.getElementById("num_val").style.display = "none";
            $('#num_error').html(''); // console.log('numbers')

            this.numStatus = 0;
          } else {
            document.getElementById("num_val").style.display = "block";
            $('#num_error').html('invalid contact');
            this.numStatus = 1;
          }
        }
      } else {
        document.getElementById("guess").style.display = "none";
        $('#guess_msg').html('');
        this.numStatus = 0;
      } // console.log(this.user.countryCode, this.user.dialCode, this.user.country);

    },
    showNames: function showNames() {
      if (this.showNamesStatus == 0) {
        document.getElementById("names").style.display = "block";
        this.showNamesStatus = 1;
      } else {
        document.getElementById("names").style.display = "none";
        this.showNamesStatus = 0;
      }
    },
    checkName: function checkName(type) {},
    ///////for pass validations
    // When the user starts to type something inside the password field
    keyUp: function keyUp() {
      // var myInput = document.getElementById("password");
      var myInput = this.user.password;
      var length = document.getElementById("length"); // Validate length

      if (myInput.length >= 8) {
        document.getElementById("pass_min").style.display = "none";
        $('#pass_error').html('');
        this.passStatus = 0;
      } else if (myInput.length == 0) {
        document.getElementById("pass_min").style.display = "none";
        $('#pass_error').html('');
        this.passStatus = 1;
      } else {
        document.getElementById("pass_min").style.display = "block";
        $('#pass_error').html('password must be up to 8 characters!!!');
        this.passStatus = 1;
      }
    },
    //end pass validation
    registerUser: function registerUser() {
      var _this = this;

      if (this.user.password == this.user.password2) {
        if (this.userStatus == 0) {
          if (this.numStatus == 0) {
            if (this.passStatus == 0) {
              var data = this.user;
              this.registerAction(data).then(function (res) {
                _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].successAlert("Account created");

                _this.clear();

                _this.isLoading = false;

                _this.$router.push({
                  path: "/index"
                });
              })["catch"](function (error) {
                _this.isLoading = false;
                _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].errorMessage(error);
              });
            } else {
              _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].errorAlert("Password not valid");
            }
          } else {
            _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].errorAlert("Contact not valid");
          }
        } else {
          _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].errorAlert("Card ID not accepted please recheck again");
        }
      } else {
        _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].errorAlert("Please confirm your password");
      }
    },
    clear: function clear() {
      this.user.first_name = '';
      this.user.last_name = '';
      this.user.middle_name = '';
      this.user.email = "";
      this.user.password = "";
      this.user.phone = '';
      this.user.country = '';
      this.user.gh_card_id = '';
      this.user.remember_me = false;
      this.userStatus = 0;
      this.numStatus = 0;
      this.passStatus = 0;
    }
  }),
  created: function created() {},
  mounted: function mounted() {}
});

/***/ }),

/***/ "./resources/js/pages/Register.vue":
/*!*****************************************!*\
  !*** ./resources/js/pages/Register.vue ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Register_vue_vue_type_template_id_364a2fac_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Register.vue?vue&type=template&id=364a2fac&scoped=true& */ "./resources/js/pages/Register.vue?vue&type=template&id=364a2fac&scoped=true&");
/* harmony import */ var _Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Register.vue?vue&type=script&lang=js& */ "./resources/js/pages/Register.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Register_vue_vue_type_template_id_364a2fac_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Register_vue_vue_type_template_id_364a2fac_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "364a2fac",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/Register.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Register.vue?vue&type=script&lang=js&":
/*!******************************************************************!*\
  !*** ./resources/js/pages/Register.vue?vue&type=script&lang=js& ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Register.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Register.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/Register.vue?vue&type=template&id=364a2fac&scoped=true&":
/*!************************************************************************************!*\
  !*** ./resources/js/pages/Register.vue?vue&type=template&id=364a2fac&scoped=true& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_template_id_364a2fac_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_template_id_364a2fac_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Register_vue_vue_type_template_id_364a2fac_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Register.vue?vue&type=template&id=364a2fac&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Register.vue?vue&type=template&id=364a2fac&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Register.vue?vue&type=template&id=364a2fac&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Register.vue?vue&type=template&id=364a2fac&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************/
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
              _c(
                "div",
                { staticClass: "mb-1" },
                [
                  _c("router-link", { attrs: { to: "/" } }, [
                    _c("img", {
                      staticClass: "img-fluid mb-4",
                      staticStyle: { "max-width": "4rem" },
                      attrs: { src: "assets/img/logo-square.svg", alt: "..." },
                    }),
                  ]),
                  _vm._v(" "),
                  _c("h2", [_vm._v("Sign up")]),
                  _vm._v(" "),
                  _c("p", { staticClass: "text-muted" }, [
                    _vm._v("Welcome to Egal ghana ..."),
                  ]),
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "form",
                {
                  staticClass: "form-validate",
                  on: {
                    submit: function ($event) {
                      $event.preventDefault()
                      return _vm.registerUser.apply(null, arguments)
                    },
                  },
                },
                [
                  _c("div", { staticClass: "mb-1" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.user.email,
                          expression: "user.email",
                        },
                      ],
                      staticClass: "form-control",
                      attrs: {
                        name: "email",
                        id: "email",
                        type: "email",
                        placeholder: "name@address.com",
                        autocomplete: "off",
                        "data-msg": "Please enter your email",
                      },
                      domProps: { value: _vm.user.email },
                      on: {
                        input: function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.user, "email", $event.target.value)
                        },
                      },
                    }),
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "mb-1" },
                    [
                      _c(
                        "vue-tel-input",
                        _vm._b(
                          {
                            staticClass: "form-control",
                            on: { validate: _vm.checkNumber },
                            model: {
                              value: _vm.user.phone,
                              callback: function ($$v) {
                                _vm.$set(_vm.user, "phone", $$v)
                              },
                              expression: "user.phone",
                            },
                          },
                          "vue-tel-input",
                          _vm.vueTelProps,
                          false
                        )
                      ),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _vm._m(0),
                  _vm._v(" "),
                  _c("div", { staticClass: "mb-1" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.user.gh_card_id,
                          expression: "user.gh_card_id",
                        },
                      ],
                      staticClass: "form-control",
                      attrs: {
                        name: "gh_card_id",
                        id: "gh_card_id",
                        type: "text",
                        placeholder: "Ghana Card ID",
                        autocomplete: "off",
                        required: "",
                        "data-msg": "Please enter your Ghana Card ID",
                      },
                      domProps: { value: _vm.user.gh_card_id },
                      on: {
                        change: function ($event) {
                          return _vm.checkName(1)
                        },
                        input: function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.user, "gh_card_id", $event.target.value)
                        },
                      },
                    }),
                  ]),
                  _vm._v(" "),
                  _vm._m(1),
                  _vm._v(" "),
                  _c("div", { staticClass: "mb-1" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.user.password,
                          expression: "user.password",
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
                      domProps: { value: _vm.user.password },
                      on: {
                        keyup: _vm.keyUp,
                        change: _vm.keyUp,
                        input: function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.user, "password", $event.target.value)
                        },
                      },
                    }),
                  ]),
                  _vm._v(" "),
                  _vm._m(2),
                  _vm._v(" "),
                  _c("div", { staticClass: "mb-1" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.user.password2,
                          expression: "user.password2",
                        },
                      ],
                      staticClass: "form-control",
                      attrs: {
                        name: "loginPassword2",
                        id: "loginPassword2",
                        placeholder: "Password",
                        type: "password",
                        required: "",
                        "data-msg": "Please enter your password",
                      },
                      domProps: { value: _vm.user.password2 },
                      on: {
                        input: function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.user, "password2", $event.target.value)
                        },
                      },
                    }),
                  ]),
                  _vm._v(" "),
                  _vm._m(3),
                  _vm._v(" "),
                  _c("hr", {
                    staticClass: "my-3 hr-text letter-spacing-2",
                    attrs: { "data-content": "OR" },
                  }),
                  _vm._v(" "),
                  _vm._m(4),
                  _vm._v(" "),
                  _c("hr", { staticClass: "my-4" }),
                  _vm._v(" "),
                  _vm._m(5),
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
      _vm._m(6),
    ]),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      {
        staticClass: "row",
        staticStyle: { display: "none" },
        attrs: { id: "num_val" },
      },
      [_c("p", { staticClass: "text-warning", attrs: { id: "num_error" } })]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      {
        staticClass: "row",
        staticStyle: { display: "none" },
        attrs: { id: "guess" },
      },
      [
        _c("p", { staticClass: "text-warning", attrs: { id: "guess_msg" } }),
        _vm._v(" "),
        _c("p", { staticClass: "text-warning", attrs: { id: "guess_name" } }),
      ]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      {
        staticClass: "row",
        staticStyle: { display: "none" },
        attrs: { id: "pass_min" },
      },
      [_c("p", { staticClass: "text-warning", attrs: { id: "pass_error" } })]
    )
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "d-grid" }, [
      _c("button", { staticClass: "btn btn-lg btn-primary" }, [
        _vm._v("Sign up"),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "d-grid gap-2" }, [
      _c("button", { staticClass: "btn btn btn-outline-primary btn-social" }, [
        _c("i", { staticClass: "fa-2x fa-facebook-f fab btn-social-icon" }),
        _vm._v("Connect "),
        _c("span", { staticClass: "d-none d-sm-inline" }, [
          _vm._v("with Facebook"),
        ]),
      ]),
      _vm._v(" "),
      _c("button", { staticClass: "btn btn btn-outline-muted btn-social" }, [
        _c("i", { staticClass: "fa-2x fa-google fab btn-social-icon" }),
        _vm._v("Connect "),
        _c("span", { staticClass: "d-none d-sm-inline" }, [
          _vm._v("with Google"),
        ]),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", { staticClass: "text-sm text-muted" }, [
      _vm._v("By signing up you agree to Directory's "),
      _c("a", { attrs: { href: "#" } }, [_vm._v("Terms and Conditions")]),
      _vm._v(" and "),
      _c("a", { attrs: { href: "#" } }, [_vm._v("Privacy Policy")]),
      _vm._v("."),
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