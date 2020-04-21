// API call to current site - check for user authenticated
function checkAuth() {
  $.ajax({
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    xhrFields: {
      withCredentials: true
    },
    type: 'GET',
    url: 'https://test-restarters.rstrt.org' + '/test/check-auth',
    datatype: 'json',
    success: function(response) {
      var response = response.data;

      if (response.authenticated === true) {
        ajaxSearchNotifications();

        $main_navigation_dropdown = $('.hamburger-dropdown-menu');
        $main_navigation_dropdown.empty();

        if(response.is_admin) {
          $('body').addClass('is_admin');

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

        $.each( response.menu.general, function( key, value ) {
          $main_navigation_dropdown.append(
            $('<li>').append(
              $('<a>').attr('href', value).text(key)
            )
          );
        });

        if(response.menu) {
          $auth_menu_items = $('.user-dropdown-menu');
          $auth_menu_items.empty();
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
      }

    },
  });
}
