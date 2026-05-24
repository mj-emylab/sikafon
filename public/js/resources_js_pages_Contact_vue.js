"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pages_Contact_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Contact.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Contact.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************/
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
        name: "",
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
      this.contactData.name = "";
      this.contactData.newsletter = false;
    },
    call: function call() {
      window.open('tel:+233557522685');
    },
    contact: function contact() {
      var _this = this;

      if (this.contactData.name != "" && this.contactData.contact != "" && this.contactData.message != "") {
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

/***/ "./resources/js/pages/Contact.vue":
/*!****************************************!*\
  !*** ./resources/js/pages/Contact.vue ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Contact_vue_vue_type_template_id_01b3a6b2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Contact.vue?vue&type=template&id=01b3a6b2&scoped=true& */ "./resources/js/pages/Contact.vue?vue&type=template&id=01b3a6b2&scoped=true&");
/* harmony import */ var _Contact_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Contact.vue?vue&type=script&lang=js& */ "./resources/js/pages/Contact.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Contact_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Contact_vue_vue_type_template_id_01b3a6b2_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Contact_vue_vue_type_template_id_01b3a6b2_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "01b3a6b2",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/Contact.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Contact.vue?vue&type=script&lang=js&":
/*!*****************************************************************!*\
  !*** ./resources/js/pages/Contact.vue?vue&type=script&lang=js& ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Contact_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Contact.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Contact.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Contact_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/Contact.vue?vue&type=template&id=01b3a6b2&scoped=true&":
/*!***********************************************************************************!*\
  !*** ./resources/js/pages/Contact.vue?vue&type=template&id=01b3a6b2&scoped=true& ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Contact_vue_vue_type_template_id_01b3a6b2_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Contact_vue_vue_type_template_id_01b3a6b2_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Contact_vue_vue_type_template_id_01b3a6b2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Contact.vue?vue&type=template&id=01b3a6b2&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Contact.vue?vue&type=template&id=01b3a6b2&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Contact.vue?vue&type=template&id=01b3a6b2&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Contact.vue?vue&type=template&id=01b3a6b2&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************/
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
  return _c("div", [
    _c(
      "section",
      { staticClass: "hero py-6 py-lg-7 text-white dark-overlay" },
      [
        _c("img", {
          staticClass: "bg-image",
          attrs: {
            src: "assets/img/photo/photo-1522143049013-2519756a52d4.jpg",
            alt: "How can we help you today?",
          },
        }),
        _vm._v(" "),
        _c("div", { staticClass: "container overlay-content" }, [
          _c(
            "ol",
            {
              staticClass:
                "breadcrumb text-white justify-content-center no-border mb-0",
            },
            [
              _c(
                "li",
                { staticClass: "breadcrumb-item" },
                [_c("router-link", { attrs: { to: "/" } }, [_vm._v("Home")])],
                1
              ),
              _vm._v(" "),
              _c("li", { staticClass: "breadcrumb-item active" }, [
                _vm._v("Contact"),
              ]),
            ]
          ),
          _vm._v(" "),
          _c("h1", { staticClass: "hero-heading" }, [
            _vm._v("How can we help you today?"),
          ]),
        ]),
      ]
    ),
    _vm._v(" "),
    _c("section", { staticClass: "py-6" }, [
      _c("div", { staticClass: "container" }, [
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col-md-4 text-center text-md-start mb-4 mb-md-0" },
            [
              _c("div", { staticClass: "icon-rounded mb-4 bg-primary-light" }, [
                _c(
                  "svg",
                  { staticClass: "svg-icon w-2rem h-2rem text-primary" },
                  [_c("use", { attrs: { "xlink:href": "#map-location-1" } })]
                ),
              ]),
              _vm._v(" "),
              _c("h3", { staticClass: "h5" }, [_vm._v("Address")]),
              _vm._v(" "),
              _vm._m(0),
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-4 text-center text-md-start mb-4 mb-md-0" },
            [
              _c("div", { staticClass: "icon-rounded mb-4 bg-primary-light" }, [
                _c(
                  "svg",
                  { staticClass: "svg-icon w-2rem h-2rem text-primary" },
                  [_c("use", { attrs: { "xlink:href": "#landline-1" } })]
                ),
              ]),
              _vm._v(" "),
              _c("h3", { staticClass: "h5" }, [_vm._v("Call center")]),
              _vm._v(" "),
              _c("p", { staticClass: "text-muted" }, [
                _vm._v("Available 8am - 5pm work days."),
              ]),
              _vm._v(" "),
              _vm._m(1),
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-4 text-center text-md-start mb-4 mb-md-0" },
            [
              _c("div", { staticClass: "icon-rounded mb-4 bg-primary-light" }, [
                _c(
                  "svg",
                  { staticClass: "svg-icon w-2rem h-2rem text-primary" },
                  [_c("use", { attrs: { "xlink:href": "#mail-1" } })]
                ),
              ]),
              _vm._v(" "),
              _c("h3", { staticClass: "h5" }, [_vm._v("Electronic support")]),
              _vm._v(" "),
              _c("p", { staticClass: "text-muted" }, [
                _vm._v(
                  "Please feel free to write an email to us or to use our electronic ticketing system."
                ),
              ]),
              _vm._v(" "),
              _vm._m(2),
            ]
          ),
        ]),
      ]),
    ]),
    _vm._v(" "),
    _c("section", { staticClass: "py-6 bg-gray-100" }, [
      _c("div", { staticClass: "container" }, [
        _c("h2", { staticClass: "h4 mb-5" }, [_vm._v("Contact form")]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-md-7 mb-5 mb-md-0" }, [
            _c(
              "form",
              {
                staticClass: "form",
                on: {
                  submit: function ($event) {
                    $event.preventDefault()
                    return _vm.contact.apply(null, arguments)
                  },
                },
              },
              [
                _c("div", { staticClass: "controls" }, [
                  _c("div", { staticClass: "row" }, [
                    _c("div", { staticClass: "col-sm-6" }, [
                      _c("div", { staticClass: "mb-4" }, [
                        _c(
                          "label",
                          { staticClass: "form-label", attrs: { for: "name" } },
                          [_vm._v("Your name *")]
                        ),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.contactData.name,
                              expression: "contactData.name",
                            },
                          ],
                          staticClass: "form-control",
                          attrs: {
                            type: "text",
                            name: "name",
                            id: "name",
                            placeholder: "Enter your name",
                            required: "required",
                          },
                          domProps: { value: _vm.contactData.name },
                          on: {
                            input: function ($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.contactData,
                                "name",
                                $event.target.value
                              )
                            },
                          },
                        }),
                      ]),
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-sm-6" }, [
                      _c("div", { staticClass: "mb-4" }, [
                        _c(
                          "label",
                          {
                            staticClass: "form-label",
                            attrs: { for: "contact" },
                          },
                          [_vm._v("Your lastname *")]
                        ),
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
                            type: "text",
                            name: "contact",
                            id: "contact",
                            placeholder: "Enter your contact",
                            required: "required",
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
                    ]),
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "mb-4" }, [
                    _c(
                      "label",
                      { staticClass: "form-label", attrs: { for: "email" } },
                      [_vm._v("Your email *")]
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
                        type: "email",
                        name: "email",
                        placeholder: "Enter your  email",
                        required: "required",
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
                    _c(
                      "label",
                      { staticClass: "form-label", attrs: { for: "message" } },
                      [_vm._v("Your message for us *")]
                    ),
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
                      attrs: {
                        rows: "4",
                        name: "message",
                        id: "message",
                        placeholder: "Enter your message",
                        required: "required",
                      },
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
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-outline-primary",
                      attrs: { type: "submit" },
                    },
                    [_vm._v("Send message")]
                  ),
                ]),
              ]
            ),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-5" }, [
            _c("div", { staticClass: "ps-lg-4 text-sm" }, [
              _c("p", { staticClass: "text-muted" }, [
                _vm._v(
                  "We are always available at working hours(8am-5pm) work days. "
                ),
              ]),
              _vm._v(" "),
              _c("p", { staticClass: "text-muted" }, [
                _vm._v(
                  "An enquiry sent outside of working hours might not get immediate response. "
                ),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "social" }, [
                _c("ul", { staticClass: "list-inline" }, [
                  _c("li", { staticClass: "list-inline-item" }, [
                    _c(
                      "a",
                      {
                        attrs: { href: "", target: "_blank" },
                        on: {
                          click: function ($event) {
                            $event.preventDefault()
                          },
                        },
                      },
                      [_c("i", { staticClass: "fab fa-twitter" })]
                    ),
                  ]),
                  _vm._v(" "),
                  _c("li", { staticClass: "list-inline-item" }, [
                    _c(
                      "a",
                      {
                        attrs: { href: "", target: "_blank" },
                        on: {
                          click: function ($event) {
                            $event.preventDefault()
                          },
                        },
                      },
                      [_c("i", { staticClass: "fab fa-facebook" })]
                    ),
                  ]),
                  _vm._v(" "),
                  _c("li", { staticClass: "list-inline-item" }, [
                    _c(
                      "a",
                      {
                        attrs: { href: "", target: "_blank" },
                        on: {
                          click: function ($event) {
                            $event.preventDefault()
                          },
                        },
                      },
                      [_c("i", { staticClass: "fab fa-instagram" })]
                    ),
                  ]),
                  _vm._v(" "),
                  _c("li", { staticClass: "list-inline-item" }, [
                    _c(
                      "a",
                      {
                        attrs: { href: "", target: "_blank" },
                        on: {
                          click: function ($event) {
                            $event.preventDefault()
                          },
                        },
                      },
                      [_c("i", { staticClass: "fab fa-pinterest" })]
                    ),
                  ]),
                  _vm._v(" "),
                  _c("li", { staticClass: "list-inline-item" }, [
                    _c(
                      "a",
                      {
                        attrs: { href: "", target: "_blank" },
                        on: {
                          click: function ($event) {
                            $event.preventDefault()
                          },
                        },
                      },
                      [_c("i", { staticClass: "fab fa-vimeo" })]
                    ),
                  ]),
                ]),
              ]),
            ]),
          ]),
        ]),
      ]),
    ]),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", { staticClass: "text-muted" }, [
      _vm._v("East Legon "),
      _c("br"),
      _vm._v(" Banana Street, Accra"),
      _c("br"),
      _vm._v(", "),
      _c("strong", [_vm._v("Ghana")]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", { staticClass: "text-muted" }, [
      _c("strong", [_vm._v("+233 20 823 6182/+233 55 533 3455")]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("ul", { staticClass: "list-unstyled text-muted" }, [
      _c("li", [_vm._v("info@egal.com")]),
      _vm._v(" "),
      _c("li", [_vm._v("egal.ghana@gmail.com")]),
    ])
  },
]
render._withStripped = true



/***/ })

}]);