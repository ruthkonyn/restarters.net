// API call to current site - check for user authenticated

function checkAuth() {
  $url = 'https://test-restarters.rstrt.org' + '/test/check-auth';

  if( ! $('.auth-loaded-1').length ) {
    $notifications_list_item = $('.notifications-list-item').hide();
    $auth_menu_items = $('.user-dropdown-menu-items').hide();
    $auth_menu_items.removeClass('dropdown-menu-items');
    $('body').addClass('auth-loaded-1');
  }

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

      if( ! $('.auth-loaded-2').length ) {
        console.log('d-header-icons 1');
        var html = "<div class='hamburger-dropdown-menu-items' style='display: none;'><ul class='hamburger-dropdown-menu'></ul></div>";
        $(html).insertAfter('.d-header-icons');
        $('body').addClass('auth-loaded-2');
      }

      $main_navigation_dropdown = $('.hamburger-dropdown-menu');

      if (response.authenticated === true) {
        // $main_navigation_dropdown.attr('style', 'display:block');
        hamburgerMenu();
        //categoriesMenu();
        ajaxSearchNotifications();
        userMenu();

        // if ($notifications_list_item.length) {
        //   $notifications_list_item.css('display','');
        // }

        if(response.is_admin && ! $('.auth-loaded-3').length) {
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
          $('body').addClass('auth-loaded-3');
        }

        if(response.menu && ! $('.auth-loaded-4').length) {
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
          $('body').addClass('auth-loaded-4');
        }

        // if ($notifications_list_item.length) {
        //   $notifications_list_item.css('display','');
        // }

        if ($auth_list_item.length) {
          $auth_menu_items.addClass('dropdown-menu-items');
          $auth_menu_items.css('display','');
        }

        isLoggedIn();

      } else {
        $auth_list_item.find('a').attr('href', 'https://test-restarters.rstrt.org');
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

  // $('body').addClass('auth-loaded');
}

function userMenu() {
  if( ! $('.auth-loaded-5').length) {
    console.log('d-header-icons 2');
    var html = "<div class='user-dropdown-menu-items'><ul class='user-dropdown-menu'></ul></div>";
    $(html).insertAfter('.d-header-icons');

    $('body').addClass('auth-loaded-5');
  }

  $('.restarters-user-toggle').click(function(e) {
    e.preventDefault();
    $('a.dropdown-active').not('.toggle-user-menu').removeClass('dropdown-active');
    $('.hamburger-dropdown-menu-items').hide();
    $('.notification-menu-items').hide();
    $('.toggle-user-menu').toggleClass('dropdown-active');
    $('.user-dropdown-menu-items').toggle();
  });
}
