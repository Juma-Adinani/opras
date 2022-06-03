<?php
include_once './config/connect.php';
session_start();

if (!isset($_SESSION['id'])) {
   header('location:./login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<?php
include_once './header.php';
?>

<body class="bg-light d-flex flex-column justify-content-between">
   <div style="min-height: 90vh;">
      <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-lg-top" style="box-shadow: 0 0 3px #d6d6d6d6;">
         <div class="container">
            <a class="navbar-brand" href="./homepage.php"><img src="./images/logo/mu_logo.png" width="50" /><strong><span style="color: #fd876d;">MU</span>-<span class="text-secondary">OPRAS</span></strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav me-auto mb-2 w-100 d-flex justify-content-end">
                  <li class="nav-item" style="margin-right: 50px">
                     <a class="nav-link" href="./logout.php">
                        Logout
                     </a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <div class="container">
         <div class="row">
            <div class="col-12 d-flex justify-content-between py-4">
               <h2 class="h5">Personal Details</h2>
            </div>
            <?php

            $sql = $con->query("SELECT * FROM personal_details WHERE user_id  = '" . $_SESSION['id'] . "'");
            if (mysqli_num_rows($sql) == 1) {
               header('location:./select-year.php');
            } else {
            ?>
               <div class="col-md-12 col-lg-12 border bg-white shadow-sm">
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

                              $sql = $con->query("INSERT INTO personal_details (present_station, qualification, duty_post, 
                                                substantive_post, previous_appointment, present_appointment, salary_scale,
                                                period_served, profile_photo, user_id) 
                                             VALUES ('$presentStation', '$qualification', '$dutyPost', 
                                             '$subPost', '$prevAppointment', '$presAppointment', '$salaryScale', 
                                             '$perServed', '$filename', '$user')");

                              if (!mysqli_error($con)) {
                                 echo '<center class="alert alert-success">Details saved successfully</center>';
                                 header("Refresh:4;./select-year.php");
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
                  ?>
                  <form class="needs-validation mt-5 mb-5" action="" method="POST" novalidate enctype="multipart/form-data">
                     <div class="row g-3">
                        <div class="col-sm-4">
                           <label for="station" class="form-label">Present station</label>
                           <input type="text" class="form-control form-css" name="station" id="station" required />
                           <div class="invalid-feedback">
                              Please fill your present station
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <label for="qualification" class="form-label">Qualification</label>
                           <input type="text" class="form-control form-css" name="qualification" id="qualification" placeholder="" required />
                           <div class="invalid-feedback">Please fill your academic qualification</div>
                        </div>
                        <div class="col-sm-4">
                           <label for="dutyPost" class="form-label">Duty post</label>
                           <input type="text" class="form-control form-css" name="dutyPost" id="dutyPost" placeholder="" required />
                           <div class="invalid-feedback">
                              Please fill your duty post
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <label for="subPost" class="form-label">Substantive post</label>
                           <input type="text" class="form-control form-css" name="subPost" id="subPost" placeholder="" required />
                           <div class="invalid-feedback">
                              Please fill your Substantive post
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <label for="prevAppointment" class="form-label">Previous appointment</label>
                           <input type="date" class="form-control form-css" name="prevAppointment" id="prevAppointment" placeholder="" required />
                           <div class="invalid-feedback">
                              Please fill your previous appointment
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <label for="presAppointment" class="form-label">Present appointment</label>
                           <input type="date" class="form-control form-css" name="presAppointment" id="presAppointment" placeholder="" required />
                           <div class="invalid-feedback">
                              Please fill your present appointment
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <label for="salaryScale" class="form-label">Salary scale</label>
                           <input type="text" class="form-control form-css" name="salaryScale" id="salaryScale" placeholder="" required />
                           <div class="invalid-feedback">
                              Please provide your salary scale
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <label for="perServed" class="form-label">Period served</label>
                           <input type="text" class="form-control form-css" name="perServed" id="perServed" placeholder=".e.g.. 1 year, 6 months" required />
                           <div class="invalid-feedback">
                              Please fill your period served
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <label for="photo" class="form-label">Profile photo</label>
                           <input type="file" class="form-control form-css" name="photo" id="photo" required />
                           <div class="invalid-feedback">
                              Please upload your profile photo
                           </div>
                        </div>
                     </div>
                     <hr class="my-4" />
                     <div class="col-12 d-flex justify-content-end">
                        <button class="btn btn-primary btn-lg" type="submit" name="submit">
                           Save details
                        </button>
                     </div>
                  </form>
               </div>
            <?php
            }
            ?>
         </div>
      </div>
   </div>
   <div class="bg-light mt-5">
      <div class="container w-100">
         <div class="col-sm-12 d-flex justify-content-center">
            <strong><span class="text-warning">MU</span>-<span class="">OPRAS</span></strong>
            &copy; 2022, All rights reserved.
         </div>
      </div>
   </div>
   <?php
   include_once './scripts.php';
   ?>
</body>

</html>