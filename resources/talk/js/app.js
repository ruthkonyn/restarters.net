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
  var categories = "<ul class='additional_options'><li><a href='#' class='topic_categories'>Topic Categories <svg xmlns='http://www.w3.org/2000/svg' width='14.9' height='8.146' viewBox='0 0 14.9 8.146'><path d='M6.726 7.738a1.567 1.567 0 0 0 2.1 0l5.7-5.427A1.3 1.3 0 1 0 12.687.485L7.934 4.966a.324.324 0 0 1-.427 0L2.154.321a1.3 1.3 0 0 0-1.71 1.956z' data-name='Path 125'/></svg></a></li><li><a href='https://talk.restarters.net/c/local-chat' class='group_chat'>Group Chat <svg xmlns='http://www.w3.org/2000/svg' width='14.9' height='8.146' viewBox='0 0 14.9 8.146'><path d='M6.726 7.738a1.567 1.567 0 0 0 2.1 0l5.7-5.427A1.3 1.3 0 1 0 12.687.485L7.934 4.966a.324.324 0 0 1-.427 0L2.154.321a1.3 1.3 0 0 0-1.71 1.956z' data-name='Path 125'/></svg></a></li><li><a href='https://talk.restarters.net/c/local-chat' class='all_groups'>All groups <svg xmlns='http://www.w3.org/2000/svg' width='14.9' height='8.146' viewBox='0 0 14.9 8.146'><path d='M6.726 7.738a1.567 1.567 0 0 0 2.1 0l5.7-5.427A1.3 1.3 0 1 0 12.687.485L7.934 4.966a.324.324 0 0 1-.427 0L2.154.321a1.3 1.3 0 0 0-1.71 1.956z' data-name='Path 125'/></svg></a></li><li><a href='#' class='help'>Help & Feedback</a></li><li><a href='#' class='guides'>User Guides</a></li><li><a href='#' class='requests'>Feature Requests</a></li><li><a href='#' class='bug'>Bug Reports</a></li></ul>";

  $('.topic_categories').click(function(e) {
    e.preventDefault();
      $('.additional_options').addClass('display-none');
      $('.select-kit-collection').toggleClass('display-block');

      $(categories).insertAfter('.select-kit-filter');
      var back = "<a class='back' href='#'><svg xmlns='http://www.w3.org/2000/svg' width='14.9' height='8.146' viewBox='0 0 14.9 8.146'><path d='M6.726 7.738a1.567 1.567 0 0 0 2.1 0l5.7-5.427A1.3 1.3 0 1 0 12.687.485L7.934 4.966a.324.324 0 0 1-.427 0L2.154.321a1.3 1.3 0 0 0-1.71 1.956z' data-name='Path 125'/></svg> All forum options</a>";
      $('.select-kit-collection').prepend(back);
  });

  $('.back').click(function(e) {
    e.preventDefault();
    $('.additional_options').removeClass('display-none');
    $('.select-kit-collection').toggleClass('display-block');
  });
}


setTimeout(function() {
  checkAuth();
  hamburgerMenu();
  changeForumNavigation();
  categoriesDropdown();
  toggleNotifications();
  ajaxSearchNotifications();
}, 300);
