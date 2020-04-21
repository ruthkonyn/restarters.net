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

      $auth_list_item = $('.auth-list-item');
      $main_navigation_dropdown = $('.hamburger-dropdown-menu');

      if (response.authenticated === true) {
        ajaxSearchNotifications();

        if(response.is_admin && ! $('.auth-loaded').length) {
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

        if(response.menu && ! $('.auth-loaded').length) {
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

        // if ($auth_list_item.length) {
        //   $auth_menu_items.addClass('dropdown-menu-items');
        //   $auth_menu_items.css('display','');
        // }
      } else {
        $auth_list_item.find('a').attr('href', 'https://test-restarters.rstrt.org');
      }

      // Amend Main navigation dropdown links
      if( ! $('.auth-loaded').length) {
        $.each( response.menu.general, function( key, value ) {
          $main_navigation_dropdown.append(
            $('<li>').append(
              $('<a>').attr('href', value).text(key)
            )
          );
        });
      }
    },
  });

  $('body').addClass('auth-loaded');
}
