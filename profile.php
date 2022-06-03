<?php
include_once './config/connect.php';
session_start();

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
                                <h2 class="h5">Personal Details</h2>
                            </div>
                            <?php

                            if (isset($_FILES['photo'])) {
                                $path = "./images/profilePhotos/";
                                $filename = basename($_FILES['photo']['name']);
                                $filepath = $path . $filename;
                                $filetype = pathinfo($filepath, PATHINFO_EXTENSION);
                                $presentStation = mysqli_real_escape_string($con, $_POST['station']);
                                $qualification = mysqli_real_escape_string($con, $_POST['qualification']);
                                $dutyPost = mysqli_real_escape_string($con, $_POST['dutyPost']);
                                $subPost = mysqli_real_escape_string($con, $_POST['subPost']);
                                $prevAppointment = mysqli_real_escape_string($con, $_POST['prevAppointment']);
                                $presAppointment = mysqli_real_escape_string($con, $_POST['presAppointment']);
                                $salaryScale = mysqli_real_escape_string($con, $_POST['salaryScale']);
                                $perServed = mysqli_real_escape_string($con, $_POST['perServed']);
                                $user = $_SESSION['id'];

                                if (isset($_POST['submit'])) {
                                    //checking the format of a file
                                    $format = array('jpg', 'jpeg', 'png');
                                    if (in_array($filetype, $format)) {

                                        $tmpname = $_FILES['photo']['tmp_name'];

                                        //inserting data into a database
                                        if (move_uploaded_file($tmpname, $filepath)) {

                                            $sql = $con->query("UPDATE personal_details SET present_station = '$presentStation', qualification = '$qualification', 
                                                duty_post = '$dutyPost', substantive_post = '$subPost', previous_appointment = '$prevAppointment', 
                                                present_appointment = '$presAppointment',salary_scale = '$salaryScale',
                                                period_served = '$perServed', profile_photo = '$filename' WHERE user_id = '$user'");

                                            if (!mysqli_error($con)) {
                                                echo '<center class="alert alert-success">Details Updated successfully</center>';
                                                header("Refresh:2;");
                                            } else {
                                                echo '<center class="alert alert-danger">There is an error..!</center>';
                                                die(mysqli_error($con));
                                            }
                                        } else {
                                            echo '<center class="alert alert-danger">Error on photo uploading..!</center>';
                                        }
                                    } else {
                                        echo '<center class="alert alert-danger">Make Sure You post photo (jpg, png, jpeg) formats..!</center>';
                                    }
                                } else {
                                    echo "<div class='alert alert-warning'><strong>Select a file to upload!</strong></div>";
                                }
                            }


                            $sql = $con->query("SELECT * FROM users, personal_details, roles
                                                         WHERE personal_details.user_id = users.id
                                                         AND users.role_id = roles.id
                                                         AND personal_details.user_id = '" . $_SESSION['id'] . "'");
                            $fetchProfile = mysqli_fetch_object($sql);
                            ?>
                            <div class="full price_table padding_infor_info">
                                <div class="row">
                                    <!-- user profile section -->
                                    <!-- profile image -->
                                    <div class="col-lg-12">
                                        <div class="full dis_flex center_text">
                                            <div class="col-sm-12 d-flex flex-column justify-content-center align-items-center">
                                                <div class="profile_img"><img width="180" class="rounded-circle" src="images/profilePhotos/<?php echo $fetchProfile->profile_photo; ?>" alt="#" /></div>
                                                <div class="profile_contant">
                                                    <div class="contact_inner text-center mt-3">
                                                        <h3><?php echo $fetchProfile->firstname . '&nbsp;' . $fetchProfile->surname; ?></h3>
                                                        <ul class="list-unstyled">
                                                            <li><i class="fa fa-envelope-o"></i> : <?php echo $fetchProfile->email; ?></li>
                                                            <li><i class="fa fa-phone"></i> : <?php echo $fetchProfile->phone; ?></li>
                                                        </ul>
                                                        <p><strong>About: </strong><?php echo $fetchProfile->role_type; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- profile contant section -->
                                        <div class="full inner_elements margin_top_30">
                                            <div class="col-sm-12 mb-3 mb-sm-0">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <form class="needs-validation" action="" method="POST" novalidate>
                                                            <div class="row g-3">
                                                                <div class="col-sm-4">
                                                                    <label for="station" class="form-label">Present station</label>
                                                                    <input type="text" class="form-control form-css" name="station" id="station" value="<?php echo $fetchProfile->present_station; ?>" required />
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="qualification" class="form-label">Qualification</label>
                                                                    <input type="text" class="form-control form-css" name="qualification" id="qualification" value="<?php echo $fetchProfile->qualification; ?>" required />
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="dutyPost" class="form-label">Duty post</label>
                                                                    <input type="text" class="form-control form-css" name="dutyPost" id="dutyPost" value="<?php echo $fetchProfile->duty_post; ?>" required />
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="subPost" class="form-label">Substantive post</label>
                                                                    <input type="text" class="form-control form-css" name="subPost" id="subPost" value="<?php echo $fetchProfile->substantive_post; ?>" required />
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="prevAppointment" class="form-label">Previous appointment</label>
                                                                    <input type="text" class="form-control form-css" name="prevAppointment" id="prevAppointment" value="<?php echo $fetchProfile->previous_appointment; ?>" required />
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="presAppointment" class="form-label">Present appointment</label>
                                                                    <input type="text" class="form-control form-css" name="presAppointment" id="presAppointment" value="<?php echo $fetchProfile->present_appointment; ?>" required />
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="salaryScale" class="form-label">Salary scale</label>
                                                                    <input type="text" class="form-control form-css" name="salaryScale" id="salaryScale" value="<?php echo $fetchProfile->salary_scale; ?>" required />
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="perServed" class="form-label">Period served</label>
                                                                    <input type="text" class="form-control form-css" name="perServed" id="perServed" value="<?php echo $fetchProfile->period_served; ?>" required />
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="photo" class="form-label">Profile photo</label>
                                                                    <input type="file" class="form-control form-css" name="photo" id="photo" />
                                                                </div>
                                                            </div>
                                                            <hr class="my-4" />
                                                            <div class="container">
                                                                <button class="btn btn-sm text-white" type="submit" name="submit" style="background: #17a2b8;">
                                                                    Save changes
                                                                </button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end user profile section -->
                                    </div>
                                </div>
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
    </div>
    <?php
    include_once './scripts.php';
    ?>
</body>
<style>
    .form-control {
        border: 0;
        border-bottom: thin solid #f3f3f3;
        border-radius: 0;
    }

    .form-control:focus {
        box-shadow: none;
        outline: none;
        color: #17a2b8;
        border: 0;
        border-bottom: 2px solid #17a2b8;
    }
</style>

</html>