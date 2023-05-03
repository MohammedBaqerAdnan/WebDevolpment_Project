<?php session_start(); ?>
<?php function validate_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registration</title>
  <link rel="stylesheet" href="../../Addition/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../Addition/css/all.min.css" />
  <link rel="stylesheet" href="../Css/login.css" />
</head>

<body>
  <section class="login-container">
    <div class="container v-100">
      <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-6 d-none d-md-block">
          <img src="../Pictures/login1.png" alt="login image" class="login-image" />
        </div>
        <div class="col-12 col-md-6">
          <form action="sign_up_process.php" class="login-form" method="post" id="registration-form">
            <h2 class="mb-4">Registration</h2>
            <?php if (isset($_SESSION['error_message'])) { ?>
              <p class="small fw-bold mt-2 text-danger error" id="error_message">
                <?php
                $error = $_SESSION['error_message'];
                $error = validate_input($error);
                unset($_SESSION['error_message']);
                ?>
                <?php echo $error; ?>
              </p>
            <?php } ?>
            <div class="form-group">
              <label for="name">Full Name <span class="text-danger">*</span></label>
              <?php if (isset($_SESSION['username_refill'])) { ?>
                <?php $username = validate_input($_SESSION['username_refill']); ?>
                <?php unset($_SESSION['username_refill']); ?>
                <input type="text" placeholder="Enter Your Full Name" class="form-control" id="name" name="username"
                  value="<?php echo $username; ?>" />
              <?php } else { ?>
                <input type="text" placeholder="Enter Your Full Name" class="form-control" id="name" name="username" />
              <?php } ?>
              <small id="name_error_message" class="invalid-feedback"></small>
            </div>
            <div class="form-group">
              <label for="email">Email <span class="text-danger">*</span></label>
              <?php if (isset($_SESSION['email_refill'])) { ?>
                <?php $email = validate_input($_SESSION['email_refill']); ?>
                <?php unset($_SESSION['email_refill']); ?>
                <input type="email" placeholder="Enter Your Email" class="form-control" id="email" name="email"
                  value="<?php echo $email; ?>" />
              <?php } else { ?>
                <input type="email" placeholder="Enter Your Email" class="form-control" id="email" name="email" />
              <?php } ?>
              <small id="email_error_message" class="invalid-feedback"></small>
            </div>
            <div class="form-group">
              <label for="password">Password <span class="text-danger">*</span></label>
              <input type="password" placeholder="Enter Your Password" class="form-control" id="password"
                name="password" />
              <small id="password_error_message" class="invalid-feedback"></small>
            </div>
            <div class="form-group">
              <label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
              <input type="password" placeholder="Confirm Your Password" class="form-control" id="confirm_password"
                name="confirm_password" />
              <small id="confirm_password_error_message" class="invalid-feedback"></small>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary" name="Register_button">Register</button>
              <p class="small fw-bold mt-2">
                Already have an account?
                <a href="Login.php" class="link-danger">Login</a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <script src="../../Addition/js/bootstrap.bundle.min.js"></script>
  <script src="../../Addition/js/all.min.js"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
  <script src="../js/jquery-3.6.0.min.js"></script>
  <script src="../js/validate_input_live.js"></script>
  <script src="../js/ajax_check_availability.js"></script>
  <!-- <script src="../js/ajax_signup.js"></script> -->
  <!-- <script>
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
            if (data == "Username is already exists") {
              name_error_message.innerHTML = data;
              name_error_message.style.display = 'block';
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error: " + textStatus, errorThrown);
          }
        });
      });
    });</script> -->
  <script>


    // $(document).ready(function () {
    //   // $("#registration-form").on("submit", function (e) {
    //   $('#email).on('change', function () {
    //     // e.preventDefault(); // prevent the form from submitting normally

    //   let email = $("#email").val();
    //   alert(email);
    //   const email_error_message = document.getElementById('email_error_message');

    //   const email_error_message = document.getElementById('email_error_message');
    //   const name_error_message = document.getElementById('name_error_message');


    //   // send AJAX request
    //   $.ajax({
    //     url: "../PHP/ajax_signup.php",
    //     method: "POST",
    //     data: { email: email },
    //     cache: false,
    //     success: function (data) {
    //       if (data == "Email is already exists") {

    //         alert("Registration successful!");
    //         // window.location.href = "../PHP/Login.php";
    //         //display error message id = error_message
    //         // error_message.innerHTML = data;
    //         // error_message.display = "block";
    //         email_error_message.innerHTML = data;
    //         email_error_message.style.display = 'block';
    //       }
    //     },
    //     error: function (jqXHR, textStatus, errorThrown) {
    //       console.error("AJAX Error: " + textStatus, errorThrown);
    //     }
    //   });
    // });
    // });
    // $(document).ready(function () {
    //   // $("#registration-form").on("submit", function (e) {
    //   $('#email').on('change', function () {

    //     let email = $("#email").val();
    //     const email_error_message = document.getElementById('email_error_message');
    //     const name_error_message = document.getElementById('name_error_message');

    //     // send AJAX request
    //     $.ajax({
    //       url: "../PHP/ajax_signup.php",
    //       method: "POST",
    //       data: { email: email },
    //       cache: false,
    //       success: function (data) {
    //         if (data == "Email is already exists") {
    //           email_error_message.innerHTML = data;
    //           email_error_message.style.display = 'block';
    //         }
    //       },
    //       error: function (jqXHR, textStatus, errorThrown) {
    //         console.error("AJAX Error: " + textStatus, errorThrown);
    //       }
    //     });
    //   });
    // });



  </script>
  <!-- <script>
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
  </script> -->


</body>

</html>