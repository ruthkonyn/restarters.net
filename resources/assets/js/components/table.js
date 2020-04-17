$('.entireRowClickable').click(function() {
  if( $(this).find('a').attr('href') ){
    window.location = $(this).find('a').attr('href');
  }
}).hover( function() {
    $(this).toggleClass('hoverablePointer');
});
