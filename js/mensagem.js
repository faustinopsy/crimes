function showMessage() {
  var message = document.getElementById("message");
  var overla = document.getElementById("overlay");
  message.style.display = "block";
  overla.style.display = "block";
  
}

function hideMessage() {
  var overla = document.getElementById("overlay");
  var message = document.getElementById("message");
  message.style.display = "none";
  overla.style.display = "none";
}