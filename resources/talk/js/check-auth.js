// API call to current site - check for user authenticated
function checkAuth() {
  $url = 'https://test-restarters.rstrt.org' + '/test/check-auth';

  userMenu();

  $notifications_list_item = $('.notifications-list-item').hide();
  $auth_menu_items = $('.user-dropdown-menu-items').hide();
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

      var response = response.data;

      if (response.authenticated !== null && response.authenticated !== undefined) {
        hamburgerMenu();
        categoriesMenu();
        ajaxSearchNotifications();

        if ($notifications_list_item.length) {
          $notifications_list_item.css('display','');
        }

        $('.d-header-icons').attr('style', 'display:block');

        var html = "<div class='hamburger-dropdown-menu-items' style='display: none;'><ul class='hamburger-dropdown-menu'></ul></div>";
        $(html).insertAfter('.d-header-icons');

        if(response.is_admin) {
          $main_navigation_dropdown = $('.hamburger-dropdown-menu');
          $('.toggle-hamburger-menu svg').removeClass('restarters-hamburger');
          $('.toggle-hamburger-menu svg').addClass('restarters-hamburger-admin');

          $.each( response.menu.reporting, function( key, value ) {
            var spacer_condition = key.includes('spacer');

            var header_condition = key.includes('header');

            if (header_condition) {
              $main_navigation_dropdown.append(
                $('<li>').attr('class', 'dropdown-menu-header').text(value)
              );
            } else if (spacer_condition) {
              $main_navigation_dropdown.append(
                $('<li>').attr('class', 'dropdown-spacer')
              );
            } else {
              $main_navigation_dropdown.append(
                $('<li>').append(
                  $('<a>').attr('href', value).text(key)
                )
              );
            }
          });
        }

        if(response.menu) {
          $auth_menu_items = $('.user-dropdown-menu');
          $.each( response.menu.user, function( key, value ) {
            var spacer_condition = key.includes('spacer');

            var header_condition = key.includes('header');

            if (header_condition) {
              $auth_menu_items.append(
                $('<li>').attr('class', 'dropdown-menu-header').text(value)
              );
            } else if (spacer_condition) {
              $auth_menu_items.append(
                $('<li>').attr('class', 'dropdown-spacer')
              );
            } else {
              $auth_menu_items.append(
                $('<li>').append(
                  $('<a>').attr('href', value).text(key)
                )
              );
            }
          });
        }
        if ($notifications_list_item.length) {
          $notifications_list_item.css('display','');
        }

        if ($auth_list_item.length) {
          $auth_menu_items.addClass('dropdown-menu-items');
          $auth_menu_items.css('display','');
        }
      } else {
        $auth_list_item.find('a').attr('href', 'https://test-restarters.rstrt.org');
        $('.d-header-icons').attr('style', 'display:none');
      }

      // Amend Main navigation dropdown links
      $.each( response.menu.general, function( key, value ) {
        $main_navigation_dropdown.append(
          $('<li>').append(
            $('<a>').attr('href', value).text(key)
          )
        );
      });
    },
  });
}

function userMenu() {
  var html = "<div class='user-dropdown-menu-items'><ul class='user-dropdown-menu'></ul></div>";
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
