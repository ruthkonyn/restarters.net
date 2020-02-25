// Slick Slider js
import 'slick-carousel/slick/slick.min';

// Bootstrap js
require('../../assets/js/bootstrap');

$('.slick-your-groups').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  dots: true,
  centerMode: true,
  focusOnSelect: true,
  arrows: false,
  // variableWidth: true,
  infinite: true,
  centerPadding: '25',
  // rows: 0,
});


$(document).ready(function() {
  require('./components/dropdown.js');
  require('./components/table.js');
  require('./components/populate-events-select.js');
  require('./components/ajax-search-discourse-notifications.js');

  console.log('ready!');

  // Change controller for collapse text
  $('.collapse-plus-and-minus-controller').click(function() {
    $(this).text(function(i,old){
      return old == $(this).attr('data-close-text') ? $(this).attr('data-open-text') : $(this).attr('data-close-text');
    });
  });

  // Initialize tooltips
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  $('.redirectToIntended').click(function() {
    $prefix = $(this).attr('data-initial-url');

    location.href = $prefix + $('.group_discourse_slug').val();
  });

  // Keep hash within URL when toggling between Bootstrap Panes/Tabs
  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    window.location.hash = $(this).attr('href');
  });

  $("form[id$='-search']").submit(function (e) {
    if ($('#formHash').length) {
      $('#formHash').val(window.location.hash);
    } else {
      $(this).append(
        $('<input>', {
          type: 'hidden',
          id: 'formHash',
          name: 'formHash',
          val: window.location.hash
        })
      );
    }
  });
});

// Change Bootstrap Pane/Tab view onload where hash is within URL
window.onload = function() {

  var hash = window.location.hash;

  if ( $('#formHash').length ) {
    var hash = $('#formHash').val();
  }

  if(hash != '' || hash != undefined) {
    var $element = $('a[href="' + hash + '"]');
    if ($element.length == 1) {
      $element.tab('show');
    }
  }
}
