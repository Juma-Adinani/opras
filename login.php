<?php
include_once './config/connect.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
  <meta name="generator" content="Hugo 0.84.0" />
  <title>MU-OPRAS | Open Performance Review and Appraisal</title>
  <link rel="icon" type="image/png" sizes="16x16" href="./images/logo/mu_logo.png" />
  <!-- Bootstrap core CSS -->
  <link href="./dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="login.css" rel="stylesheet" />
</head>

<body>
  <main>
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
      <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <img src="./images/logo/mu_logo.png" width="130" />
            <strong style="font-size: 50px"><span style="color: #fd876d">MU</span>&nbsp;<span class="text-secondary">-</span>&nbsp;<span class="text-secondary">OPRAS</span></strong>
          </div>
          <hr class="py4" />
          <p class="display-6 text-secondary fw-bold text-center mb-3">
            Mzumbe University Open Performance Review and Appraisal System
          </p>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
          <form class="p-4 p-md-5 border rounded-3 bg-light" method="post" action="">
            <?php
            if (isset($_POST['submit'])) {

              $email = mysqli_real_escape_string($con, $_POST['email']);
              $password = mysqli_real_escape_string($con, $_POST['password']);
              $sql = $con->query("SELECT users.id as id, firstname, role_id, surname, role_type
                                    FROM users, roles 
                                    WHERE email = '$email'
                                    AND password = '" . sha1($password) . "'
                                    AND users.role_id = roles.id");
              if (!mysqli_error($con)) {
                if (mysqli_num_rows($sql) == 1) {
                  $row = mysqli_fetch_assoc($sql);

                  $_SESSION['id'] = $row['id'];
                  $_SESSION['role'] = $row['role_type'];
                  $_SESSION['fname'] = $row['firstname'];
                  $_SESSION['lname'] = $row['surname'];

                  echo '<div class="alert alert-warning text-center">
                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        Loading...
                      </div>';

                  header("Refresh:3; url=./homepage.php");
                } else {
                  echo '<div class="alert alert-danger text-center">Invalid credentials, Try again</div>' . mysqli_error($con);
                }
              } else {
                echo '<div class="alert alert-danger text-center">There is an error</div>' . mysqli_error($con);
              }
            }
            ?>
            <p class="lead mb-4 fw-bold text-center text-secondary">
              login with credentials
            </p>
            <div class="form-floating mb-3">
              <input type="email" class="form-control btn-control" name="email" id="floatingInput" required placeholder="name@example.com" />
              <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating mb-3">
              <input type="password" class="form-control btn-control" name="password" id="floatingPassword" required placeholder="Password" />
              <label for="floatingPassword">Password</label>
            </div>
            <div class="checkbox mb-3">
              <!-- <label>
                <input type="checkbox" value="remember-me" /> Remember me
              </label> -->
            </div>
            <button class="w-100 btn btn-control text-dark" type="submit" name="submit" style="background-color: #fd876d">
              Sign in
            </button>
            <hr class="my-4" />
            <small class="text-muted">By clicking Sign in, you agree to the terms of use.</small>
          </form>
        </div>
      </div>
    </div>
  </main>
  <script src="./dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>