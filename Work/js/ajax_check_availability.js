$(document).ready(function () {
    // $("#registration-form").on("submit", function (e) {
    $('#email').on('change', function () {

      let email = $("#email").val();
      const email_error_message = document.getElementById('email_error_message');
      const name_error_message = document.getElementById('name_error_message');

      // send AJAX request
      $.ajax({
        url: "../PHP/ajax_signup.php",
        method: "POST",
        data: { email: email },
        cache: false,
        success: function (data) {
          if (data == "Email is already exists") {
            email_error_message.innerHTML = data;
            email_error_message.style.display = 'block';
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("AJAX Error: " + textStatus, errorThrown);
        }
      });
    });
  });
  $(document).ready(function () {
    // $("#registration-form").on("submit", function (e) {
    $('#name').on('change', function () {

      let name = $("#name").val();
      const name_error_message = document.getElementById('name_error_message');

      // send AJAX request
      $.ajax({
        url: "../PHP/ajax_signup.php",
        method: "POST",
        data: { name: name },
        cache: false,
        success: function (data) {
          if (data == "name is already exists") {
            name_error_message.innerHTML = data;
            name_error_message.style.display = 'block';
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("AJAX Error: " + textStatus, errorThrown);
        }
      });
    });
  });