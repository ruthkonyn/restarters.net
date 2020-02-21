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
module.exports = __webpack_require__(5);


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

$(document).ready(function () {

  __webpack_require__(2);
  __webpack_require__(3);
  __webpack_require__(4);

  console.log('ready!');

  // Change controller for collapse text
  $('.collapse-plus-and-minus-controller').click(function () {
    $(this).text(function (i, old) {
      return old == $(this).attr('data-close-text') ? $(this).attr('data-open-text') : $(this).attr('data-close-text');
    });
  });

  // Initialize tooltips
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
});

// Change tab view onload where hash is within URL
// TODO: Double check this works...
window.onload = function () {
  var hash = window.location.hash;
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

$('.entireRowClickable').click(function () {
  window.location = $(this).find('a').attr('href');
}).hover(function () {
  $(this).toggleClass('hoverablePointer');
});

/***/ }),
/* 4 */
/***/ (function(module, exports) {

function searchEventsByGroup() {
  $group_id = $(".change-group :selected").val();

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $("input[name='_token']").val()
    },
    type: 'GET',
    url: '/api/events/' + $group_id,
    datatype: 'json',
    success: function success(response) {
      $('.change-events option').remove();
      $events = JSON.parse(response.events);

      $.each($events, function ($event_id, $event_name) {
        var data = {
          id: $event_id,
          text: $event_name
        };

        var newOption = new Option(data.text, data.id, false, false);
        $('.change-events').append(newOption).trigger('change');
      });

      console.log('Success: Found ' + $('.change-events option').length + ' events.');
    }
  });
}

$(document).on('change', '.change-group', function () {
  searchEventsByGroup();
});

$(document).on('change', '.change-events', function () {
  $('.change-event-url').attr('href', '/party/view/' + $(this).val());
});

searchEventsByGroup();

/***/ }),
/* 5 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);