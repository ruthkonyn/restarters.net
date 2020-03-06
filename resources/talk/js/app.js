function messagesViewChange() {

  url = document.getElementById("messages-dropdown").value;

  if (url) {
      // require a URL
      window.location = document.location.origin + url; // redirect
  }
  return false;
}
