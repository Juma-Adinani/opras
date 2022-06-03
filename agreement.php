<?php
include_once './config/connect.php';
session_start();

if (isset($_POST['submit'])) {

  $agreedObjective = mysqli_real_escape_string($con, $_POST['objective']);
  $agreedPerformance = mysqli_real_escape_string($con, $_POST['performance']);
  $agreedCriteria = mysqli_real_escape_string($con, $_POST['criteria']);
  $agreedResource = mysqli_real_escape_string($con, $_POST['resource']);
  $sql = $con->query("INSERT INTO agreement (agreed_objectives, agreed_criteria, agreed_resources, agreed_targets, aYear) 
                              VALUES ('$agreedObjective', '$agreedCriteria', '$agreedResource', '$agreedPerformance', '" . $_SESSION['YearId'] . "')");

  $agreementId = mysqli_insert_id($con);
  $sqlObj = $con->query("INSERT INTO revised_objectives(agreement_id) VALUES('$agreementId')");
  $sqlMid = $con->query("INSERT INTO mid_review (agreement_id) VALUES ('$agreementId')");
  $reviewId = mysqli_insert_id($con);
  $sqlAnnual = $con->query("INSERT INTO annual_performance_review (mid_review_id) VALUES ('$reviewId')");

  header("location:./agreement.php");
} else if (isset($_GET['id'])) {
  $id = mysqli_real_escape_string($con, $_GET['id']);

  $sql = $con->query("DELETE FROM agreement WHERE id = '$id'");
  header("location:./agreement.php");
}

include './validate-year.php';
if (!isset($_SESSION['id'])) {
  header("location:./login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<?php
include_once './header.php';
?>

<body class="inner_page invoice_page">
  <div class="full_container">
    <div class="inner_container">
      <!-- Sidebar  -->
      <?php
      include_once './sidebar.php';
      ?>
      <!-- end sidebar -->
      <!-- right content -->
      <div id="content">
        <!-- topbar -->
        <?php
        include_once './topbar.php';
        ?>
        <!-- end topbar -->
        <!-- dashboard inner -->
        <div class="midde_cont mt-5">
          <div class="container-fluid" style="min-height: 100vh">
            <!-- row -->
            <div class="row">
              <div class="col-12 d-flex justify-content-between py-4">
                <h2 class="h5">Performance agreement</h2>
                <button type="button" class="btn btn-small btn-success btn-control-dark" data-toggle="modal" data-target="#exampleModalLong">
                  <i class="fa fa-plus text-light"></i>&nbsp;Add
                </button>
              </div>
              <div class="table-responsive">
                <table class="table table-striped table-responsive-md table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">s/n</th>
                      <th scope="col">Agreed objectives</th>
                      <th scope="col">Agreed performance target</th>
                      <th scope="col">Agreed perfomance criteria</th>
                      <th scope="col">Agreed Resources</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php
                      $sql = $con->query("SELECT agreement.id as id,agreed_objectives,agreed_criteria,agreed_resources,agreed_targets
                                              FROM agreement, year_preview
                                              WHERE agreement.aYear = year_preview.id
                                              AND agreement.aYear = '" . $_SESSION['YearId'] . "'
                                              AND year_preview.user_id = '" . $_SESSION['id'] . "'");
                      if (mysqli_num_rows($sql) > 0) {
                        $count = 0;
                        while ($row = mysqli_fetch_object($sql)) {
                          $count++;
                      ?>
                          <td><?php echo $count; ?></td>
                          <td><?php echo $row->agreed_objectives; ?></td>
                          <td><?php echo $row->agreed_targets; ?></td>
                          <td><?php echo $row->agreed_criteria; ?></td>
                          <td><?php echo $row->agreed_resources; ?></td>
                          <td class="text-center">
                            <a href="">
                              <!-- <i class="fa fa-edit text-primary"></i> </a>&nbsp; -->
                              <a href="agreement.php?id=<?php echo $row->id; ?>" class="text-danger">
                                <i class="fa fa-trash"></i>
                              </a>
                          </td>
                    </tr>
                <?php
                        }
                      } else {
                        echo '<tr><td colspan="6">No agreements made yet</td></tr>';
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">
              Add Agreement
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="mt-2" action="" method="POST">
              <div class="form-group row mt-4">
                <div class="col-12 mb-2">
                  <label class="mb-2" for="agreeObjective">Agreed Objectives</label>
                  <textarea name="objective" class="form-control textarea-control" id="agreeObjective" name="agreed" rows="3" required></textarea>
                </div>
                <div class="col-12 mb-2">
                  <label class="mb-2" for="agreedPerform">Agreed Perfomance Target</label>
                  <textarea name="performance" class="form-control textarea-control" id="agreedPerform" name="agreed" rows="3" required></textarea>
                </div>
                <div class="col-12 mb-2">
                  <label class="mb-2" for="agreedCriteria">Agreed Perfomance Criteria</label>
                  <textarea name="criteria" class="form-control textarea-control" id="agreedCriteria" name="agreed" rows="3" required></textarea>
                </div>
                <div class="col-12 mb-2">
                  <label class="mb-2" for="agreedResources">Agreed Resources</label>
                  <textarea name="resource" class="form-control textarea-control" id="agreedResources" name="agreed" rows="3" required></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                  Cancel
                </button>
                <button type="submit" class="btn btn-secondary" name="submit">
                  Save agreement
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- end form modal to add data into the agreement table -->
    <!-- end model popup -->
  </div>
  <?php
  include_once './scripts.php';
  ?>
</body>

</html>