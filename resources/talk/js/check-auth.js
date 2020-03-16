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
      console.log(response);

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

        $('.d-header-icons').attr('style', 'display:block');

        userMenu();

        if(response.is_admin) {
          $('.toggle-hamburger-menu svg').removeClass('restarters-hamburger');
          $('.toggle-hamburger-menu svg').addClass('restarters-hamburger-admin');

          $('.admin-dropdown-spacer').show();
          var html =  "<p class='admin-menu-header'>Administrator</p><ul><li><a href=''>Brands</a></li><li><a href=''>Skills</a></li><li><a href='/g'>Groups</a></li><li><a href='/tags'>Tags</a></li><li><a href='/categories'>Categories</a></li><li><a href='/u'>Users</a></li><li><a href=''>Roles</a></li><li><a href=''>Translations</a></li><li><a href='/admin'>Talk Admin Panel</a></li><li><a href='/admin/site_settings/category/required'>Talk Site Settings</a></li><li><a href=''>Repair Directory</a></li></ul>";
          $(html).insertAfter('.admin-dropdown-spacer');
        }

        var html = "<div class='hamburger-dropdown-menu-items' style='display: none;'><ul class='hamburger-dropdown-menu'></ul></div>";
        $(html).insertAfter('.d-header-icons');

        if(response.menu) {
          var menu_text = "<p class='admin-menu-header'>Reporting</p>";
          $('.hamburger-dropdown-menu-items').prepend(menu_text);
          
          $.each(response.menu.reporting, function(key, value) {
            var admin_links = "<li class='"+ key +"'><a href='"+ value +"'>"+ key +"</a></li>";
            $('.hamburger-dropdown-menu').append(admin_links);
          });

          $.each(response.menu.general, function(key, value) {
            var general_links = "<li class='"+ key +"'><a href='"+ value +"'>"+ key +"</a></li>";
            $('.hamburger-dropdown-menu').append(general_links);
          });

          var menu_line = "<li class='admin-dropdown-spacer'></li>"
          $('.About').prepend(menu_line);
        }
      } else {
        $auth_list_item.find('a').attr('href', 'https://test-restarters.rstrt.org');
        $('.d-header-icons').attr('style', 'display:none');
      }
    },
  });
}
