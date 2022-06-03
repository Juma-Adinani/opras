<?php
$sql = $con->query("SELECT * FROM year_preview WHERE user_id = '" . $_SESSION['id'] . "'");

if (mysqli_num_rows($sql) == 0) {
    header("location:./select-year.php");
}
