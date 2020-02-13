$(document).ready(function() {

  require('./components/dropdown.js');
  require('./components/table.js');

  console.log('ready!');

  // Change controller for collapse text
  $('.collapse-plus-and-minus-controller').click(function(){
    $(this).text(function(i,old){
      return old == 'OPEN FILTERS' ? 'CLOSE FILTERS' : 'OPEN FILTERS';
    });
  });
});
