<?php
include './config/connect.php';
session_start();
if (!isset($_SESSION['id'])) {
  header("location:./login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MU-OPRAS | Open Performance Review and Appraisal</title>
  <link rel="icon" type="image/png" sizes="16x16" href="images/logo/mu_logo.png" />
  <!-- Bootstrap core CSS -->
  <link href="dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column justify-content-between" style="min-height: 100vh;">
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-lg-top" style="box-shadow: 0 0 3px #d6d6d6d6;">
      <div class="container">
        <a class="navbar-brand" href="./homepage.php"><img src="./images/logo/mu_logo.png" width="50" /><strong><span style="color: #fd876d;">MU</span>-<span class="text-secondary">OPRAS</span></strong></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 w-100 d-flex justify-content-end">
            <li class="nav-item dropdown" style="margin-right: 50px">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Profile
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="./profile.php">Account</a></li>
                <li><a class="dropdown-item" href="./settings.php">Settings</a></li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li>
                  <a class="dropdown-item" href="./logout.php">Logout</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <main>
      <section class="py-5 text-center container">
        <div class="row pb-2">
          <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">MU-Opras Modules</h1>
            <!-- <p class="lead text-muted">
              Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officia recusandae nemo officiis reprehenderit debitis, placeat fugiat incidunt quis ipsam voluptate eaque suscipit eius illo aspernatur nostrum. Iusto, rem. Quis, amet.
            </p> -->
          </div>
        </div>
      </section>
      <div class="album py-5 bg-light">
        <div class="container">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 d-flex justify-content-center">
            <div class="col">
              <div class="card shadow-sm">
                <img src="images/logo/mp.jpg" width="100%" height="225" alt="services photo" />
                <div class="card-body">
                  <h3 class="card-title text-secondary">Services</h3>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="./personal-details.php" class="btn btn-sm btn-outline-secondary">
                        Open
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            if ($_SESSION['role'] != 'admin') {
            ?>
              <div class="col">
                <div class="card shadow-sm">
                  <img src="images/logo/p.webp" width="100%" height="225" alt="services photo" />
                  <div class="card-body">
                    <h3 class="card-title text-secondary">
                      <?php if ($_SESSION['role'] == 'supervisor') {
                        echo 'Assess';
                      } else if ($_SESSION['role'] == 'staff') {
                        echo 'Performance';
                      } else {
                        echo 'Comment';
                      }; ?>
                    </h3>
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="btn-group">
                        <?php if ($_SESSION['role'] == 'supervisor') {
                          echo '<a href="./supervisor-page.php" " class="btn btn-sm btn-outline-secondary">Open</a>';
                        } else if ($_SESSION['role'] == 'staff') {
                          if (isset($_POST['performance'])) {
                            $sql = $con->query("SELECT * FROM year_preview WHERE user_id = '" . $_SESSION['id'] . "'");
                            $row = mysqli_fetch_assoc($sql)['id'];
                            $_SESSION['YearId'] = $row;
                            header("location:./annual-review.php");
                          }
                        ?>
                          <form action="" method="post">
                            <input type="text" name="id" value="<?php echo $row; ?>" hidden>
                            <button type="submit" name="performance" class="btn btn-outline-secondary btn-sm">Assess performance</button>
                          </form>
                        <?php
                        } else {
                          echo '<a href="./supervisor-page.php" " class="btn btn-sm btn-outline-secondary">Leave a comment</a>';
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            }
            if ($_SESSION['role'] == 'admin') {
              echo '
                    <div class="col">
                      <div class="card shadow-sm">
                        <img src="images/logo/pm.png" width="100%" height="225" alt="services photo" />
                        <div class="card-body">
                          <h3 class="card-title text-secondary">Management</h3>
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                              <a href="./admin/" class="btn btn-sm btn-outline-secondary">
                                Open
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  ';
            }
            ?>
          </div>
        </div>
      </div>
    </main>
  </div>
  <footer class="text-muted py-2 mt-auto">
    <div class="container d-flex justify-content-between">
      <p class="mb-1">
        <small><strong><span style="color: #fd876d;">MU</span>-<span class="">OPRAS</span></strong>
          &copy; 2022, All rights reserved.</small>
      </p>
      <p class="float-end mb-1">
        <a href="#">Back to top</a>
      </p>
    </div>
  </footer>

  <script src="dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>