$(document).ready(function () {
  // $("#registration-form").on("submit", function (e) {
  $('#email').on('change', function () {

    let email = $("#email").val();
    const email_success_message = document.getElementById('email_success_message');

    // send AJAX request
    $.ajax({
      url: "../PHP/ajax_signup.php",
      method: "POST",
      data: { email: email },
      cache: false,
      success: function (data) {
        if (data == "Email is already exists") {
          email_success_message.innerHTML = "Email is successfully registered";
          email_success_message.style.color = 'green';
          email_success_message.style.display = 'block';
        }else  
        {
          email_success_message.innerHTML = "Email is not registered";
          email_success_message.style.color = 'red';
          email_success_message.style.display = 'block';
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("AJAX Error: " + textStatus, errorThrown);
      }
    });
  });
});