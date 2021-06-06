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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/Validation.js":
/*!************************************!*\
  !*** ./resources/js/Validation.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

window.ValidateForm = function () {
  var section = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;
  var count = 0;
  count += ValidateInput(section);
  count += ValidateRadio(section);
  count += ValidateCheckBox(section);
  count += ValidateSelector(section);
  count += ValidateMulitSelector(section);
  count += ValidateFile(section);
  count += ValidateTextArea(section);

  if (count != 0) {
    MessageObject.VaildSubmitMessage("驗證發生錯誤", "必填欄位一定要填");
    return false;
  }

  return true;
};

function ValidateInput() {
  var section = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;
  var lists = section.getElementsByClassName("necessary");
  var count = 0;

  for (var i = 0; i < lists.length; i++) {
    if (lists[i].value === "" || lists[i].value === "error") {
      lists[i].classList.add("is-invalid");
      count++;
    } else {
      lists[i].classList.remove("is-invalid");
    }
  }

  return count;
}

function ValidateRadio() {
  var section = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;
  var radios = section.getElementsByClassName("necessaryRadio");
  var Valid = false;

  for (var i = 0; i < radios.length; i++) {
    if (radios[i].checked == true) {
      Valid = true;
      $(".type-block").removeClass("error");
    }
  }

  if (!Valid) {
    $(".type-block").addClass("error");
  }

  if (radios.length > 0) {
    count = Valid === true ? 0 : 1;
  } else {
    count = 0;
  }

  return count;
}

function ValidateCheckBox() {
  var section = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;
  var checkboxs = section.getElementsByClassName("necessaryCheckBox");
  var Valid = false;

  for (var i = 0; i < checkboxs.length; i++) {
    if (checkboxs[i].checked == true) {
      Valid = true;
      $(".check-block").removeClass("error");
    }
  }

  if (!Valid) {
    $(".check-block").addClass("error");
  }

  if (checkboxs.length > 0) {
    count = Valid === true ? 0 : 1;
  } else {
    count = 0;
  }

  return count;
}

function ValidateSelector() {
  var section = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;
  var selectors = section.getElementsByClassName("necessarySelect");
  var count = 0;

  for (var i = 0; i < selectors.length; i++) {
    if (selectors[i].options[selectors[i].selectedIndex].value == 0 || selectors[i].options[selectors[i].selectedIndex].disabled) {
      selectors[i].classList.add("is-invalid");
      count++;
    } else {
      console.log(selectors[i].options[selectors[i].selectedIndex]);
      selectors[i].classList.remove("is-invalid");
    }
  }

  return count;
}

function ValidateMulitSelector() {
  var section = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;
  var selectors = section.getElementsByClassName("necessaryMulitSelect");
  var count = 0;

  for (var i = 0; i < selectors.length; i++) {
    if (selectors[i].options[selectors[i].selectedIndex].value == 0 || selectors[i].options[selectors[i].selectedIndex].disabled) {
      selectors[i].classList.add("is-invalid");
      count++;
    } else {
      console.log(selectors[i].options[selectors[i].selectedIndex]);
      selectors[i].classList.remove("is-invalid");
    }
  }

  if (count != 0) {
    if ($(".tags").find(".error").length == 0) {
      $('.tags').append('<h4 class="error"><span class="badge badge-pill badge-error">請記得按新增Tag</span></h4>');
    }
  }

  return count;
}

function ValidateFile() {
  var section = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;
  var files = section.getElementsByClassName("necessaryFile");
  var count = 0;
  $.each(files, function (index, input) {
    if (input.value == "") {
      $(this).parent(".preview").addClass("error");
      count++;
    } else {
      $(this).parent(".preview").removeClass("error");
    }
  });
  return count;
}

function ValidateTextArea() {
  var section = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;
  var textareas = section.getElementsByClassName("necessaryTextArea");
  var count = 0;

  for (var i = 0; i < textareas.length; i++) {
    if (textareas[i].value.trim() == "" || textareas[i].value === "error") {
      textareas[i].classList.add("is-invalid");
      count++;
    } else {
      textareas[i].classList.remove("is-invalid");
    }
  }

  return count;
}

/***/ }),

/***/ 2:
/*!******************************************!*\
  !*** multi ./resources/js/Validation.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Applications/XAMPP/xamppfiles/htdocs/campus2/resources/js/Validation.js */"./resources/js/Validation.js");


/***/ })

/******/ });