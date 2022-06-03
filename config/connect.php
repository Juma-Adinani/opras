<?php

$con = mysqli_connect("localhost", "root", "", "oprasdb");

if (mysqli_connect_error()) {
    echo 'Error in database connection' . mysqli_error($con);
}
