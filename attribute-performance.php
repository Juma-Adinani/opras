<?php
include './config/connect.php';
session_start();
if (!isset($_SESSION['id'])) {
  header("location:./login.php");
}
if (isset($_POST['ready'])) {
  $sql = $con->query("INSERT INTO opras (aYear, supervisor_id) VALUES ('" . $_SESSION['YearId'] . "','" . $_SESSION['id'] . "')");
  header("location:./comment-section.php");
} else if (isset($_GET['id'])) {
  $_SESSION['YearId'] = $_GET['id'];
  header("location:./comment-section.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
include './header.php';
?>

<body class="inner_page invoice_page">
  <div class="full_container">
    <div class="inner_container">
      <!-- Sidebar  -->
      <?php
      include './sidebar.php';
      ?>
      <!-- end sidebar -->
      <!-- right content -->
      <div id="content">
        <!-- topbar -->
        <?php
        include './topbar.php';
        ?>
        <!-- end topbar -->
        <!-- dashboard inner -->
        <div class="midde_cont mt-5">
          <div class="container-fluid" style="min-height: 100vh">
            <!-- row -->
            <div class="row">
              <?php
              if (isset($_POST['rate'])) {
                $id = $_POST['id'];

                if ($_SESSION['role'] == 'staff') {
                  $staffMark = mysqli_real_escape_string($con, $_POST['staffMark']);
                  if ($staffMark < 0 || $staffMark > 5) {
                    echo '<div class="alert alert-danger col-12">Out of Range (range must be 0 to 5)</div>';
                  } else {
                    $sql = $con->query("UPDATE quality_attributes SET staff_mark = $staffMark WHERE id = $id");
                  }
                } else {
                  $supervisor_mark = mysqli_real_escape_string($con, $_POST['supervisorMark']);
                  if ($supervisor_mark < 0 || $supervisor_mark > 5) {
                    echo '<div class="alert alert-danger">Out of Range (range must be 0 to 5)</div>';
                  } else {
                    $sql = $con->query("UPDATE quality_attributes SET supervisor_mark = $supervisor_mark WHERE id = $id");
                  }
                }

                $sql = $con->query("SELECT SUM((staff_mark + supervisor_mark)/2) as agreedMark FROM quality_attributes WHERE id = $id");
                $averageMark = mysqli_fetch_object($sql)->agreedMark;
                $sql2 = $con->query("UPDATE quality_attributes SET agreed_mark = '$averageMark' WHERE id = $id");
              }
              ?>
              <div class="col-12 d-flex justify-content-between pt-4 pb-2">
                <h2 class="h5">Attribute of Good Performance</h2>
              </div>

              <div class="container-fluid d-flex justify-content-center">
                <div class="col-12">
                  <div class="card shadow-sm">
                    <div class="card-body">
                      <?php
                      $sql = "SELECT * FROM main_factors";
                      $result = mysqli_query($con, $sql);
                      $count = 0;
                      while ($row = mysqli_fetch_object($result)) {
                        $count++;
                      ?>
                        <h5 class="card-title text-muted"><?php echo $count . '. ' . $row->factors; ?></h5>
                        <table class="table table-selected table-bordered text-dark table-lg">
                          <thead>
                            <tr>
                              <th scope="col">Quality factors</th>
                              <th scope="col">staff mark</th>
                              <th scope="col">supervisor mark</th>
                              <th scope="col">agreed mark</th>
                              <th scope="col">Rate now</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <?php
                              $qualitySql = "SELECT * FROM quality_attributes WHERE factor_id = $row->id";
                              $qualityResult = mysqli_query($con, $qualitySql);
                              while ($fetchQuality = mysqli_fetch_object($qualityResult)) {
                              ?>
                                <td><?php echo $fetchQuality->quality; ?></td>
                                <form action="" method="post">
                                  <td>
                                    <input type="text" class="form-control" name="id" value="<?php echo $fetchQuality->id; ?>" hidden>
                                    <?php
                                    if ($_SESSION['role'] == 'staff') {
                                    ?>
                                      <input type="number" class="form-control" name="staffMark" value="<?php echo $fetchQuality->staff_mark; ?>">
                                    <?php
                                    } else {
                                    ?>
                                      <input type="number" class="form-control" name="staffMark" value="<?php echo $fetchQuality->staff_mark; ?>" disabled>
                                    <?php
                                    }
                                    ?>
                                  </td>
                                  <td>
                                    <?php
                                    if ($_SESSION['role'] == 'supervisor') {
                                    ?>
                                      <input type="number" class="form-control" name="supervisorMark" value="<?php echo $fetchQuality->supervisor_mark; ?>">
                                    <?php
                                    } else {
                                    ?>
                                      <input type="number" class="form-control" name="supervisorMark" value="<?php echo $fetchQuality->supervisor_mark; ?>" disabled>
                                    <?php
                                    }
                                    ?>
                                  </td>
                                  <td><?php echo $fetchQuality->agreed_mark; ?></td>
                                  <td class="text-center">
                                    <button type="submit" class="btn btn-light text-primary" name="rate">
                                      <i class="fa fa-check text-primary"></i></button>
                                  </td>
                                </form>
                            </tr>
                          <?php
                              }
                          ?>
                          </tbody>
                        </table>
                      <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- row -->
            <?php
            if ($_SESSION['role'] == 'supervisor') {
              $sql = "SELECT * FROM opras WHERE aYear = '" . $_SESSION['YearId'] . "' AND supervisor_id = '" . $_SESSION['id'] . "'";
              $result = mysqli_query($con, $sql);
              if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result)['aYear'];
            ?>
                <div class="container mt-4 d-flex justify-content-end">
                  <a href="attribute-performance.php?id=<?php echo $row ;?>" class="btn btn-sm btn-light text-primary border-bottom">Proceed with comment section</a>
                </div>
              <?php
              } else {
              ?>
                <form action="" method="post" class="container mt-4 d-flex justify-content-end">
                  <button class="btn btn-success btn-sm w-25" name="ready" type="submit">Ready</button>
                </form>
            <?php
              }
            }
            ?>
          </div>
          <!-- footer -->
          <div class="container-fluid">
            <div class="footer row">
              <div class="col-12 p-2 d-flex justify-content-center align-items-center">
                <div class="col-6">
                  <small><strong><span class="text-warning">MU</span>-<span class="">OPRAS</span></strong>
                    &copy; 2022, All rights reserved.</small>
                </div>
                <div class="col-4 text-end">
                  <small>Designed by <em>Rukiah Chomboh</em> </small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end dashboard inner -->
      </div>
    </div>
    <!-- model popup -->
    <!-- The Modal -->
    <!-- end model popup -->
  </div>
  <!-- jQuery -->
  <?php
  include './scripts.php';
  ?>
</body>
<style>
  .form-control {
    border: none;
  }

  .form-control:focus {
    border-bottom: thin solid royalblue;
    outline: none;
    box-shadow: none;
    border-radius: 0;
  }
</style>

</html>