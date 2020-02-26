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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(4);


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

$(document).ready(function () {
  __webpack_require__(2);
  __webpack_require__(3);

  console.log('Global js ready!');

  // Keep hash within URL when toggling between Bootstrap Panes/Tabs
  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    window.location.hash = $(this).attr('href');
  });

  $("form[id$='-search']").submit(function (e) {
    if ($('#formHash').length) {
      $('#formHash').val(window.location.hash);
    } else {
      $(this).append($('<input>', {
        type: 'hidden',
        id: 'formHash',
        name: 'formHash',
        val: window.location.hash
      }));
    }
  });
});

// Change Bootstrap Pane/Tab view onload where hash is within URL
window.onload = function () {
  var hash = window.location.hash;

  if ($('#formHash').length) {
    var hash = $('#formHash').val();
  }

  if (hash != '' || hash != undefined) {
    var $element = $('a[href="' + hash + '"]');
    if ($element.length == 1) {
      $element.tab('show');
    }
  }
};

/***/ }),
/* 2 */
/***/ (function(module, exports) {

$('.toggle-dropdown-menu').click(function () {

  // If item is already active then close all.
  if ($(this).hasClass('dropdown-active')) {
    $('.toggle-dropdown-menu').each(function () {
      $(this).removeClass('dropdown-active');
      $(this).parents().children('.dropdown-menu-items').hide();
    });

    return false;
  }

  // Close all existing items except current.
  $('.toggle-dropdown-menu').not(this).each(function () {
    $(this).removeClass('dropdown-active');
    $(this).parents().children('.dropdown-menu-items').hide();
  });

  // Show items.
  $(this).toggleClass('dropdown-active');
  $(this).parents().children('.dropdown-menu-items').toggle();
});

/***/ }),
/* 3 */
/***/ (function(module, exports) {

// API call to current site - check for notifications
function ajaxSearchNotifications() {
  // $base_url = window.location.host;

  $url = '/notifications/discourse/';

  if (user != 'undefined') {
    $url = $url + user.username + '/' + user.id;
  }

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $("input[name='_token']").val()
    },
    type: 'GET',
    url: $url,
    datatype: 'json',
    success: function success(response) {
      console.log('Success: connected to Discourse.');

      if (response.message == 'cookies_set') {
        console.log('Success: notification cookie is currently set.');

        return false;
      }

      // Response failed
      if (response.message == 'failed') {
        console.log('Success: failed to find any new notifications.');
        return false;
      }

      // If notifications exist then we can create a cookie
      var $notifications = JSON.parse(response.notifications);

      if ($notifications.length > 0) {
        console.log('Success: notifications found on Discourse.');
      }
    }
  });
}

ajaxSearchNotifications();

/***/ }),
/* 4 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);