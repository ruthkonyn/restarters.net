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
    if ( $(this).hasClass('dropdown-active')) {
      $('.notification-icon').each(function() {
        $(this).removeClass('dropdown-active');
        $(this).parents().children('.dropdown-menu-items').hide();
      });

      return false;
    }

    // Show items.
    $('.toggle-notifications-menu').toggleClass('dropdown-active');
    $('.toggle-notifications-menu').parents().children('.dropdown-menu-items').toggle();
  });
}

function hamburgerMenu() {
  var html = "<div class='hamburger-dropdown-menu-items' style='display: none;'><li><a href='https://talk.restarters.net/about'> About</a></li><li><a href='https://talk.restarters.net/guidelines'>Guidelines</a></li><li><a href='https://talk.restarters.net/tos'>Terms of use</a></li><li><a href='https://talk.restarters.net/privacy'>Privacy</a></li><li><a href='https://talk.restarters.net/c/help' target='_blank' rel='noopener noreferrer'>Help &amp; Feedback</a></li><li><a href='https://therestartproject.org/faq' target='_blank' rel='noopener noreferrer'>FAQs</a></li><li><a href='https://therestartproject.org' target='_blank' rel='noopener noreferrer'>therestartproject.org</a></li></div>";
  $(html).insertAfter('.d-header-icons');

  $('.restarters-hamburger-toggle').click(function(e) {
    $('.toggle-hamburger-menu').toggleClass('dropdown-active');
    $('.hamburger-dropdown-menu-items').toggle();
  });
}

function userMenu() {
  var html = "<div class='user-dropdown-menu-items' style='display: none;'><li><a href='https://talk.restarters.net/about'> About</a></li><li><a href='https://talk.restarters.net/guidelines'>Guidelines</a></li><li><a href='https://talk.restarters.net/tos'>Terms of use</a></li><li><a href='https://talk.restarters.net/privacy'>Privacy</a></li><li><a href='https://talk.restarters.net/c/help' target='_blank' rel='noopener noreferrer'>Help &amp; Feedback</a></li><li><a href='https://therestartproject.org/faq' target='_blank' rel='noopener noreferrer'>FAQs</a></li><li><a href='https://therestartproject.org' target='_blank' rel='noopener noreferrer'>therestartproject.org</a></li></div>";
  $(html).insertAfter('.d-header-icons');

  $('.restarters-user-toggle').click(function(e) {
    $('.toggle-user-menu').toggleClass('dropdown-active');
    $('.user-dropdown-menu-items').toggle();
  });
}


setTimeout(function() {
  hamburgerMenu();
  userMenu();
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
      }
    },
  });
}
