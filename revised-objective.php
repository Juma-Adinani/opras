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
              if (isset($_POST['update'])) {
                $id = $_POST['id'];
                $objective = mysqli_real_escape_string($con, $_POST['objective']);
                $criteria = mysqli_real_escape_string($con, $_POST['criteria']);
                $target = mysqli_real_escape_string($con, $_POST['target']);
                $resource = mysqli_real_escape_string($con, $_POST['resource']);

                $sql = $con->query("UPDATE revised_objectives SET  revised_objectives = '$objective', 
                                    revised_performance = '$target', 
                                    revised_criteria = '$criteria', 
                                    revised_resources = '$resource'
                                    WHERE id = '$id'");
              }
              ?>
              <div class="col-12 d-flex justify-content-between py-4">
                <h2 class="h5">Revised objective performance</h2>
              </div>
              <div class="table-responsive">
                <table class="table table-striped table-responsive-md table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">s/n</th>
                      <th scope="col">Agreed Objectives</th>
                      <th scope="col">Agreed Perfomance Target</th>
                      <th scope="col">Agreed Performance Criteria</th>
                      <th scope="col">Agreed Resources</th>
                      <th scope="col">Revise</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php
                      $sql = $con->query("SELECT revised_objectives.id as id, agreed_objectives, agreed_criteria, agreed_resources, agreed_targets
                                            FROM revised_objectives, agreement
                                            WHERE revised_objectives.agreement_id = agreement.id
                                            AND agreement.aYear = '" . $_SESSION['YearId'] . "'");
                      if (mysqli_num_rows($sql) > 0) {
                        $sn = 0;
                        while ($row = mysqli_fetch_object($sql)) {
                          $sn++;
                      ?>
                          <td><?php echo $sn; ?></td>
                          <form action="" method="post">
                            <td>
                              <input type="text" name="id" value="<?php echo $row->id; ?>" hidden />
                              <textarea class="form-control" name="objective" cols="30" rows="3"><?php echo $row->agreed_objectives; ?></textarea>
                            </td>
                            <td><textarea class="form-control" name="target" cols="30" rows="3"><?php echo $row->agreed_targets; ?></textarea></td>
                            <td><textarea class="form-control" name="criteria" cols="30" rows="3"><?php echo $row->agreed_criteria; ?></textarea></td>
                            <td><textarea class="form-control" name="resource" id="" cols="30" rows="3"><?php echo $row->agreed_resources; ?></textarea></td>
                            <td class="text-center">
                              <button class="btn btn-light" type="submit" name="update"><i class="fa fa-check text-primary"></i></button>
                            </td>
                          </form>
                    </tr>
                <?php
                        }
                      } else {
                        echo '<tr><td colspan="6">No Objectives to revise yet</td></tr>';
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