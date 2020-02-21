$(document).ready(function() {

  require('./components/dropdown.js');
  require('./components/table.js');
  require('./components/populate-events-select.js');

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
});

// Change tab view onload where hash is within URL
// TODO: Double check this works...
window.onload = function() {
  var hash = window.location.hash;
  if(hash != '' || hash != undefined) {
    var $element = $('a[href="' + hash + '"]');
    if ($element.length == 1) {
      $element.tab('show');
    }
  }
}
