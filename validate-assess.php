<?php
include './config/connect.php';
if (isset($_POST['assess'])) {
    $sql = "SELECT * FROM year_preview WHERE id  = '" . $_POST['id'] . "'";
    $result = mysqli_query($con, $sql);

    $row = mysqli_fetch_assoc($result);
    $_SESSION['YearId'] = $row['id'];
    $_SESSION['staffAssessed'] = $row['user_id'];
    header("location: ./annual-review.php");
}
