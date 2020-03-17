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
  var html = "<div class='user-dropdown-menu-items' style='display: none;'><ul><li><a class='my-profile-url' href=''>My profile &amp; settings</a></li><li class='admin-dropdown-spacer' style='display: none;'></li><li class='dropdown-spacer'></li><li><a href='https://test-restarters.rstrt.org/logout'>Logout</a></li></ul></div>";
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

function changeForumNavigation() {
  $('#create-topic').addClass('d-none');
  $('#create-topic .d-button-label').text('New Topic');
  $('#create-topic').removeClass('d-none');

  var text = "<p class='forum-nav-text'><strong>A place to discuss all things repair: advice, activism, and more.</strong> Join in! Anyone can post a topic.</p>";
  $(text).insertAfter("#create-topic");
}

function categoriesDropdown() {
  var categories = "<ul><li><a href='#' class='topic_categories'>Topic Categories</a></li></ul>";

  $(categories).insertAfter('.select-kit-filter');

  $('.topic_categories').click(function(e) {
    e.preventDefault();
    $('.select-kit-collection').show();
  })
}


setTimeout(function() {
  changeForumNavigation();
  categoriesDropdown();
  checkAuth();
  hamburgerMenu();
  toggleNotifications();
  ajaxSearchNotifications();
}, 300);
