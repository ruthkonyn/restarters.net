function navigateUrl(item) {
  if(item.value) {
    location.href = document.location.origin + item.value;
  }
}

setTimeout(function() {
  var options = document.querySelectorAll(".messages-dropdown-123 option");
  for(const option of options) {
    const url = option.dataset.url;
    const location = window.location.href;
    const lastPart = location.substr(location.lastIndexOf('/') + 1);
    if (lastPart == url) {
      option.setAttribute("selected", "");
      break;
    }
  }
}, 1000);

setTimeout(function() {
  if (window.location.href.indexOf("messages") > -1) {
    var inbox_tab = document.querySelector('.inbox');
    inbox_tab.classList.add('active');
  } else {
    var forum_tab = document.querySelector('.forum');
    forum_tab.classList.add('active');
  }

  $('.custom-header-links .talk').addClass('active');
}, 300);

function addActive(tab) {
  var alreadyActive = document.querySelector('.active');
  alreadyActive.classList.remove('active');
  tab.classList.add('active');
}

function toggleNotifications() {
  $('.notification-icon').click(function(e) {
    e.preventDefault();
    // If item is already active then close all.
    $('a.dropdown-active').not('.toggle-notifications-menu').removeClass('dropdown-active');
    $('.user-dropdown-menu-items').hide();
    $('.hamburger-dropdown-menu-items').hide();
    // Show items.
    $('.toggle-notifications-menu').toggleClass('dropdown-active');
    $('.toggle-notifications-menu').parents().children('.dropdown-menu-items').toggle();
  });
}

function hamburgerMenu() {
  var html = "<div class='hamburger-dropdown-menu-items' style='display: none;'><ul><li><a href='https://talk.restarters.net/about'> About</a></li><li><a href='https://talk.restarters.net/guidelines'>Guidelines</a></li><li><a href='https://talk.restarters.net/tos'>Terms of use</a></li><li><a href='https://talk.restarters.net/privacy'>Privacy</a></li><li><a href='https://talk.restarters.net/c/help' target='_blank' rel='noopener noreferrer'>Help &amp; Feedback</a></li><li><a href='https://therestartproject.org/faq' target='_blank' rel='noopener noreferrer'>FAQs</a></li><li><a href='https://therestartproject.org' target='_blank' rel='noopener noreferrer'>therestartproject.org</a></li></ul></div>";
  $(html).insertAfter('.d-header-icons');

  $('.restarters-hamburger-toggle').click(function(e) {
    e.preventDefault();
    $('a.dropdown-active').not('.toggle-hamburger-menu').removeClass('dropdown-active');
    $('.user-dropdown-menu-items').hide();
    $('.notification-menu-items').hide();
    $('.toggle-hamburger-menu').toggleClass('dropdown-active');
    $('.hamburger-dropdown-menu-items').toggle();
  });
}

function userMenu() {
  var html = "<div class='user-dropdown-menu-items' style='display: none;'><ul><li><a class='my-profile-url' href=''>My profile &amp; settings</a></li><li class='admin-dropdown-spacer' display='none'></li><li class='dropdown-spacer'></li><li><a href='https://test-restarters.rstrt.org/logout'>Logout</a></li></ul></div>";
  $(html).insertAfter('.d-header-icons');

  $('.restarters-user-toggle').click(function(e) {
    e.preventDefault();
    $('a.dropdown-active').not('.toggle-user-menu').removeClass('dropdown-active');
    $('.hamburger-dropdown-menu-items').hide();
    $('.notification-menu-items').hide();
    $('.toggle-user-menu').toggleClass('dropdown-active');
    $('.user-dropdown-menu-items').toggle();
  });
}


setTimeout(function() {
  checkAuth();
  hamburgerMenu();
  toggleNotifications();
  ajaxSearchNotifications();
}, 300);

function ajaxSearchNotifications() {
  // $base_url = window.location.host;

  var html = '<a href="#" class="toggle-notifications-menu">' +
  '<svg class="notification-bell"><span class="bell-icon-active" style="display: none;"></svg></a><ul class="dropdown-menu-items notification-menu-items"></ul></span>';

  $('.notification-icon').append(html);

  $('.notification-menu-items').hide();
  $('.toggle-notifications-menu .bell-icon-active').hide();

  $url = 'https://test-restarters.rstrt.org' + '/test/discourse/notifications';

  $.ajax({
    headers: {
      // 'X-CSRF-TOKEN': $("input[name='_token']").val(),
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    xhrFields: {
      withCredentials: true
    },
    type: 'GET',
    url: $url,
    datatype: 'json',
    success: function(response) {
      console.log('Success: connected to Discourse.');

      // Response failed
      if (response.message == 'failed') {
        console.log('Success: failed to find any new notifications.');
        return false;
      }

      // If notifications exist then we can create a cookie
      var $notifications = response.notifications;

      if ($notifications.length > 0) {
        console.log('Success: notifications found on Discourse.');

        $('.notification-menu-items').show();
        $('.toggle-notifications-menu .bell-icon-active').show();

        $.each($notifications, function(index, $notification) {
          $('.notification-menu-items').append(
            $('<li>').append(
              $('<a>').attr('href', 'https://test-restarters.rstrt.org/notifications/' + $notification.id).text($notification.data.title)
            ).attr('class', 'notifcation-text')
          );
        });
      } else {
        $('.notification-menu-items').append(
          $('<p class="admin-menu-header">').text('No notifications')
        );
      }
    },
  });
}

// API call to current site - check for user authenticated
function checkAuth() {
  $url = 'https://test-restarters.rstrt.org' + '/test/check-auth';

  $notifications_list_item = $('.notifications-list-item').hide();
  $auth_menu_items = $('.auth-menu-items').hide();
  $auth_menu_items.removeClass('dropdown-menu-items');

  $.ajax({
    headers: {
      // 'X-CSRF-TOKEN': $("input[name='_token']").val(),
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    xhrFields: {
      withCredentials: true
    },
    type: 'GET',
    url: $url,
    datatype: 'json',
    success: function(response) {
      $auth_list_item = $('.auth-list-item');

      if (response.authenticated !== null && response.authenticated !== undefined) {
        if ($notifications_list_item.length) {
          $notifications_list_item.css('display','');
        }

        if ($auth_list_item.length) {
          $auth_menu_items.addClass('dropdown-menu-items');
          $auth_menu_items.css('display','');
        }

        if ($('.my-profile-url').length) {
          $('.my-profile-url').attr('href', '/my/preferences/account');
        }
        
        userMenu();

        if(response.is_admin) {
          $('.admin-dropdown-spacer').show();
          var html =  "<p class='admin-menu-header'>Administrator</p><ul><li><a href=''>Brands</a></li><li><a href=''>Skills</a></li><li><a href='/g'>Groups</a></li><li><a href='/tags'>Tags</a></li><li><a href='/categories'>Categories</a></li><li><a href='/u'>Users</a></li><li><a href=''>Roles</a></li><li><a href=''>Translations</a></li><li><a href='/admin'>Talk Admin Panel</a></li><li><a href='/admin/site_settings/category/required'>Talk Site Settings</a></li><li><a href=''>Repair Directory</a></li></ul>";
          $(html).insertAfter('.admin-dropdown-spacer');
        }

      } else {
        $auth_list_item.find('a').attr('href', 'https://test-restarters.rstrt.org');
      }
    },
  });
}
