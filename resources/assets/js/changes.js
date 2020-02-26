$('.slick-your-groups').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  dots: true,
  centerMode: true,
  focusOnSelect: true,
  arrows: false,
  infinite: true,
  centerPadding: '25',
});

$(document).ready(function() {
  require('./components/table.js');
  require('./components/populate-events-select.js');

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
});
