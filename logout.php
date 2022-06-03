<?php

session_start();
unset($_SESSION['id']);
unset($_SESSION['YearId']);
session_destroy();

header("location: index.php");
