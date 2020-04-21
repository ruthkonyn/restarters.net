// API call to current site - check for user authenticated

function checkAuth() {
  $url = 'https://test-restarters.rstrt.org' + '/test/check-auth';

  if( ! $('.auth-loaded-1').length ) {
    $notifications_list_item = $('.notifications-list-item').hide();
    $auth_menu_items = $('.user-dropdown-menu-items').hide();
    $auth_menu_items.removeClass('dropdown-menu-items');
    $('body').addClass('auth-loaded-1');
    console.log('al1 on');
  } else {
    console.log('al1 off');
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
        var html = "<div class='hamburger-dropdown-menu-items' style='display: none;'><ul class='hamburger-dropdown-menu'></ul></div>";
        $(html).insertAfter('.d-header-icons');
        $('body').addClass('auth-loaded-2');
        console.log('al2 on');
      } else {
        console.log('al2 off');
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
          console.log('al3 on');
        } else {
          console.log('al3 off');
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
          console.log('al4 on');
        } else {
          console.log('al4 off');
        }

        // if ($notifications_list_item.length) {
        //   $notifications_list_item.css('display','');
        // }

        if ($auth_list_item.length) {
          $auth_menu_items.addClass('dropdown-menu-items');
          $auth_menu_items.css('display','');
        }
      } else {
        $auth_list_item.find('a').attr('href', 'https://test-restarters.rstrt.org');
      }

      // Amend Main navigation dropdown links
      if( ! $('.auth-loaded-6').length) {
        $.each( response.menu.general, function( key, value ) {
          $main_navigation_dropdown.append(
            $('<li>').append(
              $('<a>').attr('href', value).text(key)
            )
          );
        });

        $('body').addClass('auth-loaded-6');
        console.log('al6 on');
      } else {
        console.log('al6 off');
      }
    },
  });

  // $('body').addClass('auth-loaded');
}

function userMenu() {
  if( ! $('.auth-loaded-5').length) {
    var html = "<div class='user-dropdown-menu-items'><ul class='user-dropdown-menu'></ul></div>";
    $(html).insertAfter('.d-header-icons');

    $('body').addClass('auth-loaded-5');
    console.log('al5 on');
  } else {
    console.log('al5 off');
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
