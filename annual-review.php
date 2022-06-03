<?php
include './config/connect.php';
session_start();
if (!isset($_SESSION['id'])) {
  header("location:./login.php");
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
                    echo '<div class="col-12 alert alert-danger">Out of range (You must rate from 0 to 5)</div>';
                  } else {
                    $sql = $con->query("UPDATE annual_performance_review 
                                          SET staff_mark = '$staffMark'
                                          WHERE id = '$id'");
                  }
                } else {

                  $supervisorMark = mysqli_real_escape_string($con, $_POST['supervisorMark']);

                  if ($supervisorMark < 0 || $supervisorMark > 5) {
                    echo '<div class="col-12 alert alert-danger">Out of range (You must rate from 0 to 5)</div>';
                  } else {
                    $sql = $con->query("UPDATE annual_performance_review 
                                          SET supervisor_mark = '$supervisorMark'
                                          WHERE id = '$id'");
                  }
                }

                $sql = "SELECT SUM((staff_mark + supervisor_mark)/ 2) as agreedMark, mid_review_id
                        FROM annual_performance_review WHERE id = '$id'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);
                $agreedMark =  $row['agreedMark'];
                $review = $row['mid_review_id'];
                $sql0 = $con->query("UPDATE annual_performance_review SET agreed_mark = '$agreedMark'
                                    WHERE id = $id");
              }
              ?>
              <div class="col-12 d-flex justify-content-between py-4">
                <h2 class="h5">Annual review performance</h2>
              </div>
              <div class="table-responsive">
                <table class="table table-striped table-responsive-md table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">s/n</th>
                      <th scope="col">Agreed Objectives</th>
                      <th scope="col">Progress made</th>
                      <th scope="col">Staff mark</th>
                      <th scope="col">Supervisor mark</th>
                      <th scope="col">Agreed mark</th>
                      <th scope="col">Rate now</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php
                      $sql00 = "SELECT annual_performance_review.id as id, agreed_objectives, progress_made, staff_mark, supervisor_mark, agreed_mark
                                FROM annual_performance_review, mid_review, agreement,year_preview
                                WHERE annual_performance_review.mid_review_id = mid_review.id 
                                AND mid_review.agreement_id = agreement.id
                                AND agreement.aYear = year_preview.id
                                AND agreement.aYear = '" . $_SESSION['YearId'] . "'";
                      $sql = mysqli_query($con, $sql00);
                      if (mysqli_num_rows($sql) > 0) {
                        $sn = 0;
                        while ($row = mysqli_fetch_object($sql)) {
                          $sn++;
                      ?>
                          <th scope="row"><?php echo $sn; ?></th>
                          <td>
                            <?php echo $row->agreed_objectives; ?>
                          </td>
                          <td>
                            <?php echo $row->progress_made; ?>
                          </td>
                          <form action="" method="post">
                            <td><input type="text" name="id" value="<?php echo $row->id; ?>" hidden>
                              <?php
                              if ($_SESSION['role'] == 'staff') {
                              ?>
                                <input type="number" class="form-control" name="staffMark" value="<?php echo $row->staff_mark; ?>">
                              <?php
                              } else {
                              ?>
                                <input type="number" class="form-control" name="staffMark" value="<?php echo $row->staff_mark; ?>" disabled>
                              <?php
                              }
                              ?>
                            </td>
                            <td>
                              <?php
                              if ($_SESSION['role'] == 'supervisor') {
                              ?>
                                <input type="number" class="form-control" name="supervisorMark" value="<?php echo $row->supervisor_mark; ?>">
                              <?php
                              } else {
                              ?>
                                <input type="number" class="form-control" name="supervisorMark" value="<?php echo $row->supervisor_mark; ?>" disabled>
                              <?php
                              }
                              ?>
                            </td>
                            <td> <?php echo $row->agreed_mark; ?></td>
                            <td class="text-center">
                              <button type="submit" name="rate" class="btn btn-light">
                                <i class="fa fa-check text-primary"></i></button>
                            </td>
                          </form>
                    </tr>
                <?php
                        }
                      } else {
                        echo '<tr><td colspan="7">No annual review data to review</td></tr>';
                      }
                ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- row -->
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