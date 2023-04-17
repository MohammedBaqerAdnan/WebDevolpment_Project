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
          <form action="Login_process.php" class="login-form">
            <h2 class="mb-4">Registration</h2>
            <div class="form-group">
              <label for="name">Full Name <span class="text-danger">*</span></label>
              <input type="text" placeholder="Enter Your Full Name" class="form-control" id="name" required />
            </div>
            <div class="form-group">
              <label for="email">Email <span class="text-danger">*</span></label>
              <input type="email" placeholder="Enter Your Email" class="form-control" id="email" required />
            </div>
            <div class="form-group">
              <label for="password">Password <span class="text-danger">*</span></label>
              <input type="password" placeholder="Enter Your Password" class="form-control" id="password" required />
            </div>
            <div class="form-group">
              <label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
              <input type="password" placeholder="Confirm Your Password" class="form-control" id="confirm_password"
                required />
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Register</button>
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
  <script src="../Js/jquery.min.js"></script>
  <script src="../Js/popper.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
</body>

</html>