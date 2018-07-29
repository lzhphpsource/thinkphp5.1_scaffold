webpackHotUpdate("index/index",{

/***/ "./webpack/src/pages/index/router.js":
/*!*******************************************!*\
  !*** ./webpack/src/pages/index/router.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nObject.defineProperty(exports, \"__esModule\", {\n  value: true\n});\n\nvar _vue = __webpack_require__(/*! vue */ \"vue\");\n\nvar _vue2 = _interopRequireDefault(_vue);\n\nvar _vueRouter = __webpack_require__(/*! vue-router */ \"./node_modules/vue-router/dist/vue-router.esm.js\");\n\nvar _vueRouter2 = _interopRequireDefault(_vueRouter);\n\nvar _router = __webpack_require__(/*! ../../utils/router */ \"./webpack/src/utils/router.js\");\n\nvar _router2 = _interopRequireDefault(_router);\n\nfunction _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }\n\n_vue2.default.use(_vueRouter2.default);\n\n// 用户\n\n// 顶级路由\nvar route = new _router2.default('index');\n\nroute.reg(['index', '/'], 'index').meta({ title: 'title' });\n\nroute.reg('/users', 'user/index').meta({ title: '用户' });\n\nroute.reg('/login', 'login').meta({ title: '登录' });\n\nvar r = new _vueRouter2.default({\n  routes: route.data\n});\n\nexports.default = r;//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi93ZWJwYWNrL3NyYy9wYWdlcy9pbmRleC9yb3V0ZXIuanMuanMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9zcmMvcGFnZXMvaW5kZXgvcm91dGVyLmpzP2Y2NDAiXSwic291cmNlc0NvbnRlbnQiOlsiaW1wb3J0IFZ1ZSBmcm9tICd2dWUnXG5pbXBvcnQgVnVlUm91dGVyIGZyb20gJ3Z1ZS1yb3V0ZXInXG5pbXBvcnQgS2VSb3V0ZXIgZnJvbSAnLi4vLi4vdXRpbHMvcm91dGVyJ1xuXG5WdWUudXNlKFZ1ZVJvdXRlcilcblxuXG4vLyDnlKjmiLdcblxuLy8g6aG257qn6Lev55SxXG5jb25zdCByb3V0ZSA9IG5ldyBLZVJvdXRlcignaW5kZXgnKVxuXG5yb3V0ZS5yZWcoWydpbmRleCcsICcvJ10sICdpbmRleCcpLm1ldGEoeyB0aXRsZTogJ3RpdGxlJyB9KVxuXG5yb3V0ZS5yZWcoJy91c2VycycsICd1c2VyL2luZGV4JykubWV0YSh7IHRpdGxlOiAn55So5oi3JyB9KVxuXG5yb3V0ZS5yZWcoJy9sb2dpbicsICdsb2dpbicpLm1ldGEoeyB0aXRsZTogJ+eZu+W9lScgfSlcblxuXG5jb25zdCByID0gbmV3IFZ1ZVJvdXRlcih7XG4gIHJvdXRlczogcm91dGUuZGF0YVxufSlcblxuXG5leHBvcnQgZGVmYXVsdCByXG4iXSwibWFwcGluZ3MiOiI7Ozs7OztBQUFBO0FBQ0E7OztBQUFBO0FBQ0E7OztBQUFBO0FBQ0E7Ozs7O0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBREE7QUFDQTtBQUlBIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./webpack/src/pages/index/router.js\n");

/***/ })

})