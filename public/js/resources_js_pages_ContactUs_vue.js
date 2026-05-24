"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pages_ContactUs_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ContactUs.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ContactUs.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************/
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



var _createNamespacedHelp = (0,vuex__WEBPACK_IMPORTED_MODULE_1__.createNamespacedHelpers)('inventory'),
    mapActions = _createNamespacedHelp.mapActions;

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      isLoading: false,
      contactData: {
        contact: "",
        message: "",
        email: "",
        newsletter: false
      }
    };
  },
  computed: {},
  methods: _objectSpread(_objectSpread({}, mapActions(['contactAction'])), {}, {
    clear: function clear() {
      this.contactData.contact = "";
      this.contactData.message = "";
      this.contactData.email = "";
      this.contactData.newsletter = false;
    },
    call: function call() {
      window.open('tel:+233557522685');
    },
    contact: function contact() {
      var _this = this;

      if (this.contactData.contact != "" && this.contactData.message != "") {
        this.contactAction(this.contactData).then(function (res) {
          _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].successAlert("Sent successfully");
          _this.isLoading = false;

          _this.clear();

          _this.$router.push({
            path: "/"
          });
        })["catch"](function (error) {
          _this.isLoading = false;
          _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].errorMessage(error);
        });
      } else {
        _helpers_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].errorAlert("Contact and Message are important for sending message");
      }
    }
  }),
  mounted: function mounted() {}
});

/***/ }),

/***/ "./resources/js/pages/ContactUs.vue":
/*!******************************************!*\
  !*** ./resources/js/pages/ContactUs.vue ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ContactUs_vue_vue_type_template_id_109060a5_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ContactUs.vue?vue&type=template&id=109060a5&scoped=true& */ "./resources/js/pages/ContactUs.vue?vue&type=template&id=109060a5&scoped=true&");
/* harmony import */ var _ContactUs_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ContactUs.vue?vue&type=script&lang=js& */ "./resources/js/pages/ContactUs.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ContactUs_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ContactUs_vue_vue_type_template_id_109060a5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ContactUs_vue_vue_type_template_id_109060a5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "109060a5",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/ContactUs.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/ContactUs.vue?vue&type=script&lang=js&":
/*!*******************************************************************!*\
  !*** ./resources/js/pages/ContactUs.vue?vue&type=script&lang=js& ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ContactUs_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ContactUs.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ContactUs.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ContactUs_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/ContactUs.vue?vue&type=template&id=109060a5&scoped=true&":
/*!*************************************************************************************!*\
  !*** ./resources/js/pages/ContactUs.vue?vue&type=template&id=109060a5&scoped=true& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ContactUs_vue_vue_type_template_id_109060a5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ContactUs_vue_vue_type_template_id_109060a5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ContactUs_vue_vue_type_template_id_109060a5_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ContactUs.vue?vue&type=template&id=109060a5&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ContactUs.vue?vue&type=template&id=109060a5&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ContactUs.vue?vue&type=template&id=109060a5&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/ContactUs.vue?vue&type=template&id=109060a5&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************/
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
                { staticClass: "mb-5" },
                [
                  _c("router-link", { attrs: { to: "/" } }, [
                    _c("img", {
                      staticClass: "img-fluid mb-3",
                      staticStyle: { "max-width": "4rem" },
                      attrs: { src: "assets/img/logo-square.svg", alt: "..." },
                    }),
                  ]),
                  _vm._v(" "),
                  _c("h2", [_vm._v("Welcome to Findme Africa")]),
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "form",
                {
                  staticClass: "form-contact",
                  on: {
                    submit: function ($event) {
                      $event.preventDefault()
                      return _vm.contact.apply(null, arguments)
                    },
                  },
                },
                [
                  _c("div", { staticClass: "mb-4" }, [
                    _c(
                      "label",
                      { staticClass: "form-label", attrs: { for: "contact" } },
                      [_vm._v(" Contact")]
                    ),
                    _c("span", { staticClass: "text-danger" }, [_vm._v("*")]),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.contactData.contact,
                          expression: "contactData.contact",
                        },
                      ],
                      staticClass: "form-control",
                      attrs: {
                        name: "contact",
                        id: "contact",
                        type: "text",
                        placeholder: "contact",
                        autocomplete: "off",
                        required: "",
                        "data-msg": "Please enter your contact",
                      },
                      domProps: { value: _vm.contactData.contact },
                      on: {
                        input: function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.contactData,
                            "contact",
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
                      { staticClass: "form-label", attrs: { for: "email" } },
                      [_vm._v(" Email")]
                    ),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.contactData.email,
                          expression: "contactData.email",
                        },
                      ],
                      staticClass: "form-control",
                      attrs: {
                        name: "email",
                        id: "email",
                        type: "email",
                        placeholder: "email",
                        autocomplete: "off",
                      },
                      domProps: { value: _vm.contactData.email },
                      on: {
                        input: function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.contactData,
                            "email",
                            $event.target.value
                          )
                        },
                      },
                    }),
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "mb-4" }, [
                    _vm._m(0),
                    _vm._v(" "),
                    _c("textarea", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.contactData.message,
                          expression: "contactData.message",
                        },
                      ],
                      staticClass: "form-control",
                      attrs: { name: "", id: "", cols: "30", rows: "4" },
                      domProps: { value: _vm.contactData.message },
                      on: {
                        input: function ($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.contactData,
                            "message",
                            $event.target.value
                          )
                        },
                      },
                    }),
                  ]),
                  _vm._v(" "),
                  _vm._m(1),
                  _vm._v(" "),
                  _c("div", { staticClass: "d-grid gap-2" }, [
                    _c(
                      "button",
                      {
                        staticClass: "btn btn btn-outline-primary btn-social",
                        on: { click: _vm.call },
                      },
                      [
                        _c("i", {
                          staticClass: "fa-2x fa fa-phone btn-social-icon",
                        }),
                        _vm._v("Call @ \n              "),
                        _c("span", {}, [_vm._v(" +233 557522685")]),
                      ]
                    ),
                    _vm._v(" "),
                    _vm._m(2),
                  ]),
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
    return _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col" }, [
        _c("label", { staticClass: "form-label", attrs: { for: "password" } }, [
          _vm._v(" Message"),
        ]),
        _c("span", { staticClass: "text-danger" }, [_vm._v("*")]),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "mb-4" }, [
      _c("div", { staticClass: "form-check" }, [
        _c("input", {
          staticClass: "form-check-input",
          attrs: { id: "loginRemember", type: "checkbox" },
        }),
        _vm._v(" "),
        _c(
          "label",
          {
            staticClass: "form-check-label text-muted",
            attrs: { for: "loginRemember" },
          },
          [
            _c("span", { staticClass: "text-sm" }, [
              _vm._v("Subscribe for newsletter"),
            ]),
          ]
        ),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      {
        staticClass: "btn btn btn-outline-muted btn-social",
        attrs: { type: "submit" },
      },
      [
        _c("i", { staticClass: "fa-2x fa fa-paper-plane btn-social-icon" }),
        _vm._v(" "),
        _c("span", {}, [_vm._v("Submit Message")]),
      ]
    )
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