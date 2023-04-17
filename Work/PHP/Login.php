<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="../../Addition/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../Addition/css/all.min.css" />
  <link rel="stylesheet" href="../Css/login.css" />
</head>

<body>
  <section class="login-container">
    <div class="container">
      <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-6 d-none d-md-block">
          <img src="../Pictures/login1.png" alt="login image" class="login-image" />
        </div>
        <div class="col-12 col-md-6">
          <form action="Login_process.php" class="login-form" method="post">
            <h2 class="mb-4">Login</h2>
            <?php if (isset($_GET['error'])) { ?>
              <p class="small fw-bold mt-2 text-danger error">
                <?php echo $_GET['error']; ?>
              </p>
            <?php } ?>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" placeholder="Enter Your Email" class="form-control" id="email" name="email" />
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" placeholder="Enter Your Password" class="form-control" id="password"
                name="password" autocomplete="current-password" />
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary" name="Login_button">
                Login
              </button>
              <p class="small fw-bold mt-2">
                Don't have an account?
                <a href="registration.php" class="link-danger">Register</a>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <script src="../../js/bootstrap.bundle.min.js"></script>
  <script src="../../js/all.min.js"></script>
</body>

</html>