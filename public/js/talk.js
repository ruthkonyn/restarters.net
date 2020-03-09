function messagesViewChange() {

  url = document.getElementById("messages-dropdown").value;

  if (url) {
      // require a URL
      window.location = document.location.origin + url; // redirect
  }
  return false;
}

$("select[name=messages]").change(function() {
    window.location.href = $(this).val();
  });

$(function(){  //on document ready
    $("select[name=messages] option")  //get the options
        .filter( function () { //find the one that has the value that matches the url
             return window.location.href.indexOf(this.value)>-1; //return true if it is a match
        })
        .prop("selected",true);  //select it
});
