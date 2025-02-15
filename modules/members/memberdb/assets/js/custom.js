// Add your JavaScript here
setTimeout(function () {
  var flashMsg = document.getElementById("flashMsg");
  if (flashMsg) {
    flashMsg.remove(); // Modern method
  }
}, 4000); // 6000 milliseconds = 6 seconds

techHours = document.querySelectorAll(".tech-hours");

techHours.forEach((button) => {
  button.addEventListener("click", (event) => {
   
    hourDiv = event.currentTarget.lastElementChild;   
    hourDiv.classList.toggle('hide');
  
    
  });
});
