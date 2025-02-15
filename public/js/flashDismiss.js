function clearFlash() {
  var msg = document.getElementById("flash-msg");
  if (msg) {
    msg.remove();
  }
}

// Set a timeout to clear the div after 5 seconds
setTimeout(clearFlash, 5000);


