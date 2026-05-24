"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_home_single_JoinGroup_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/home/single/JoinGroup.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/home/single/JoinGroup.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _helpers_helpers_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../helpers/helpers.js */ "./resources/js/helpers/helpers.js");
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



var _createNamespacedHelp = (0,vuex__WEBPACK_IMPORTED_MODULE_1__.createNamespacedHelpers)('single'),
    mapActions = _createNamespacedHelp.mapActions,
    mapGetters = _createNamespacedHelp.mapGetters;

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {},
  data: function data() {
    return {
      isLoading: false,
      formData: {
        id: this.$route.query.id,
        type: 'join group'
      }
    };
  },
  methods: _objectSpread(_objectSpread({}, mapActions(['joinGroupAction'])), {}, {
    join: function join() {
      var _this = this;

      this.joinGroupAction(this.formData).then(function (res) {
        _helpers_helpers_js__WEBPACK_IMPORTED_MODULE_0__["default"].successAlert("success joind");

        _this.$router.push({
          path: "/chat"
        });
      })["catch"](function (error) {
        _this.$router.push({
          path: "/404"
        });

        _helpers_helpers_js__WEBPACK_IMPORTED_MODULE_0__["default"].errorMessage(error);
      });
    }
  }),
  mounted: function mounted() {},
  created: function created() {// console.log(this.$route.query.id);
  },
  computed: {}
});

/***/ }),

/***/ "./resources/js/home/single/JoinGroup.vue":
/*!************************************************!*\
  !*** ./resources/js/home/single/JoinGroup.vue ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _JoinGroup_vue_vue_type_template_id_7853ea20___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./JoinGroup.vue?vue&type=template&id=7853ea20& */ "./resources/js/home/single/JoinGroup.vue?vue&type=template&id=7853ea20&");
/* harmony import */ var _JoinGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./JoinGroup.vue?vue&type=script&lang=js& */ "./resources/js/home/single/JoinGroup.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _JoinGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _JoinGroup_vue_vue_type_template_id_7853ea20___WEBPACK_IMPORTED_MODULE_0__.render,
  _JoinGroup_vue_vue_type_template_id_7853ea20___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/home/single/JoinGroup.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/home/single/JoinGroup.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/home/single/JoinGroup.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_JoinGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./JoinGroup.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/home/single/JoinGroup.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_JoinGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/home/single/JoinGroup.vue?vue&type=template&id=7853ea20&":
/*!*******************************************************************************!*\
  !*** ./resources/js/home/single/JoinGroup.vue?vue&type=template&id=7853ea20& ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_JoinGroup_vue_vue_type_template_id_7853ea20___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_JoinGroup_vue_vue_type_template_id_7853ea20___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_JoinGroup_vue_vue_type_template_id_7853ea20___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./JoinGroup.vue?vue&type=template&id=7853ea20& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/home/single/JoinGroup.vue?vue&type=template&id=7853ea20&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/home/single/JoinGroup.vue?vue&type=template&id=7853ea20&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/home/single/JoinGroup.vue?vue&type=template&id=7853ea20& ***!
  \**********************************************************************************************************************************************************************************************************************/
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
      {
        staticClass: "pt-7 pb-5 d-flex align-items-end dark-overlay bg-cover",
        staticStyle: {
          "min-height": "500px",
          "background-image":
            "url('assets/img/photo/photo-1493976040374-85c8e12f0c0e.jpg')",
        },
      },
      [
        _c("div", { staticClass: "container overlay-content" }, [
          _vm._m(0),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "calltoactions", attrs: { align: "right" } },
            [
              _c(
                "router-link",
                { staticClass: "btn btn-primary", attrs: { to: "/register" } },
                [_vm._v("Not a user sign up")]
              ),
              _vm._v(" "),
              _c(
                "a",
                {
                  staticClass: "btn btn-primary",
                  staticStyle: { "background-color": "green" },
                  attrs: { href: "" },
                  on: {
                    click: function ($event) {
                      $event.preventDefault()
                      return _vm.join.apply(null, arguments)
                    },
                  },
                },
                [_vm._v("Join now")]
              ),
            ],
            1
          ),
        ]),
      ]
    ),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "text-white mb-5 mb-5", attrs: { align: "center" } },
      [
        _c("h1", { staticClass: "text-shadow verified" }, [
          _vm._v("Welcome To Egal Groups"),
        ]),
      ]
    )
  },
]
render._withStripped = true



/***/ })

}]);