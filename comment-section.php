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

$sql = $con->query("SELECT * FROM opras WHERE aYear = '" . $_SESSION['YearId'] . "'");
if (mysqli_num_rows($sql) == 0) {
    $_SESSION['commentMessage'] = '<div class="alert alert-warning col-12">This Opras is not ready for comment</div>';
} else {
    unset($_SESSION['commentMessage']);
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
                            <div class="col-12 d-flex justify-content-between pt-4 pb-2">
                                <h2 class="h5">Comment section</h2>
                            </div>

                            <div class="container-fluid d-flex justify-content-center">
                                <?php
                                if (isset($_SESSION['commentMessage'])) {
                                    echo $_SESSION['commentMessage'];
                                } else {
                                    $sql = "SELECT firstname, surname, _year,SUM(annual_performance_review.agreed_mark) as totalAnnual, SUM(quality_attributes.agreed_mark) as totalAttributes 
                                            FROM users, annual_performance_review, mid_review, agreement, opras_year,quality_attributes, year_preview
                                            WHERE annual_performance_review.mid_review_id = mid_review.id
                                            AND year_preview.user_id = users.id
                                            AND mid_review.agreement_id = agreement.id
                                            AND agreement.aYear = year_preview.id
                                            AND year_preview.year_id = opras_year.id
                                            AND year_preview.id = '" . $_SESSION['YearId'] . "'";
                                    $result = mysqli_query($con, $sql);
                                    if (mysqli_error($con)) {
                                        die(mysqli_error($con));
                                    }
                                    $row = mysqli_fetch_object($result);
                                ?>
                                    <div class="col-12">
                                        <div class="col-12 bg-white">
                                            <div class="py-2">
                                                <h5><?php echo $row->firstname . '&nbsp;' . $row->surname; ?>'s opras (<?php echo $row->_year;?>)</h5>
                                                <p></p>
                                                <p>Annual performance review: <span class="h6"><?php echo $row->totalAnnual ;?>/30</span></p>
                                                <p>Attribute performance review: <span class="h6">13/45</span></p>
                                            </div>
                                        </div><br>
                                        <div class="card shadow-sm">
                                            <div class="card-body">
                                                <form action="" method="post">
                                                    <label for="superid">Supervisor comment</label>
                                                    <textarea name="super-id" id="superid" cols="30" rows="3" class="form-control"></textarea><br>
                                                    <label for="dvccomment">DVC comment</label>
                                                    <textarea name="dvc-comment" id="dvccomment" cols="30" rows="3" class="form-control"></textarea>
                                                    <div class="mt-5 col-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-secondary btn-sm" name="comment">save comment</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
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
        border-bottom: thin solid grey;
        border-radius: 0;
    }

    .form-control:focus {
        border-bottom: thin solid royalblue;
        outline: none;
        box-shadow: none;
        border-radius: 0;
    }
</style>

</html>