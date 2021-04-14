/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/AlertMessage.js":
/*!**************************************!*\
  !*** ./resources/js/AlertMessage.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

window.VaildSubmitMessage = function (title, text) {
  swal.fire({
    title: title,
    icon: 'error',
    confirmButtonText: '知道了',
    allowOutsideClick: false,
    text: text
  });
};

window.MessageObject = {
  VaildSubmitMessage: function VaildSubmitMessage(title, text) {
    swal.fire({
      title: title,
      icon: 'error',
      confirmButtonText: '知道了',
      allowOutsideClick: false,
      text: text
    });
  },
  SuccessMessage: function SuccessMessage(title) {
    swal.fire({
      title: title,
      icon: 'success',
      timer: 2000,
      showConfirmButton: false
    });
  },
  Waiting: function Waiting(title) {
    swal.fire({
      icon: 'info',
      title: title,
      allowOutsideClick: false,
      showConfirmButton: false,
      onOpen: function onOpen() {
        swal.showLoading();
      }
    });
  },
  WarningMessage: function WarningMessage(title) {
    swal.fire({
      title: title,
      icon: 'warning',
      timer: 2000,
      showConfirmButton: false
    });
  },
  ErrorMessage: function ErrorMessage(title, text) {
    var _this = this;

    swal.fire({
      icon: 'error',
      title: title,
      text: text,
      confirmButtonText: '確認',
      allowOutsideClick: false
    }).then(function (result) {
      if (result.isConfirmed) {
        _this.SystemReload();
      }
    });
  },
  SystemReload: function SystemReload() {
    swal.fire({
      title: '系統重新整理中,請稍候',
      timer: 2000,
      timerProgressBar: true,
      didOpen: function didOpen() {
        swal.showLoading();
      },
      willClose: function willClose() {
        window.location.reload();
      }
    });
  },
  SystemError: function SystemError() {
    swal.fire({
      title: '系統異常',
      text: "於2秒後進行重整",
      icon: 'warning',
      timer: 2000,
      showConfirmButton: false
    });
    setTimeout(function () {
      window.location.reload();
    }, 2000);
  },
  OtherMessage: function OtherMessage(icon, title, text) {
    var ButtonText = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : "ok";
    swal.fire({
      icon: icon,
      title: title,
      text: text,
      confirmButtonText: ButtonText,
      allowOutsideClick: false
    });
  },
  checkMessage: function checkMessage(title, text, something) {
    swal.fire({
      icon: 'warning',
      title: title,
      text: text,
      confirmButtonText: '確認',
      allowOutsideClick: false
    }).then(function (result) {
      if (result.isConfirmed) {
        something();
      }
    });
  }
};

/***/ }),

/***/ 1:
/*!********************************************!*\
  !*** multi ./resources/js/AlertMessage.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Applications/XAMPP/xamppfiles/htdocs/campus2/resources/js/AlertMessage.js */"./resources/js/AlertMessage.js");


/***/ })

/******/ });