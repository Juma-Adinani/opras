<?php
include_once './config/connect.php';
session_start();
if (!isset($_SESSION['id'])) {
    header("location:./login.php");
}
if ($_SESSION['role'] == 'supervisor' || $_SESSION['role'] == 'DVC') {
    header("location: ./supervisor-page.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MU-OPRAS | Open Performance Review and Appraisal</title>
    <link rel="icon" type="image/png" sizes="16x16" href="images/logo/mu_logo.png" />
    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column justify-content-between" style="min-height: 100vh;">
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-lg-top" style="box-shadow: 0 0 3px #d6d6d6d6;">
            <div class="container">
                <a class="navbar-brand" href="./homepage.php"><img src="./images/logo/mu_logo.png" width="50" /><strong><span style="color: #fd876d;">MU</span>-<span class="text-secondary">OPRAS</span></strong></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 w-100 d-flex justify-content-end">
                        <li class="nav-item dropdown" style="margin-right: 50px">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Profile
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="./profile.php">Account</a></li>
                                <li><a class="dropdown-item" href="./settings.php">Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <a class="dropdown-item" href="./logout.php">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main>
            <div class="album py-5">
                <div class="container d-flex justify-content-center">
                    <div class="col-md-10 mx-auto col-lg-5">
                        <?php
                        $checkYear = array();
                        if (isset($_POST['select'])) {
                            $year = mysqli_real_escape_string($con, $_POST['year']);
                            $checkYear = array();
                            $sql = $con->query("SELECT opras_year.id as oprasId FROM year_preview, opras_year
                                                WHERE year_preview.year_id = opras_year.id AND user_id = '" . $_SESSION['id'] . "'");
                            while ($row = mysqli_fetch_assoc($sql)) {
                                array_push($checkYear, $row['oprasId']);
                            }

                            if (in_array($year, $checkYear)) {
                                echo '<center class="alert alert-danger">Already used</center>';
                            } else {
                                $sql = $con->query("INSERT INTO year_preview (year_id, user_id) 
                                                VALUES ('$year', '" . $_SESSION['id'] . "')");
                                $_SESSION['YearId'] = mysqli_insert_id($con);
                                if (!mysqli_error($con)) {
                                    echo '<center class="alert alert-success">a year selected</center>';
                                    header("Refresh:2; url=./agreement.php");
                                } else {
                                    echo '<center class="alert alert-danger">Failed to select</center>' . mysqli_error($con);
                                }
                            }
                        } else if (isset($_GET['previewId'])) {
                            $_SESSION['YearId'] =  $_GET['previewId'];
                            header("location: ./agreement.php");
                        }
                        ?>
                        <form class="p-4 p-md-5 border rounded-3 bg-light" method="post" action="">
                            <p class="lead mb-4 fw-bold text-center text-secondary">
                                Select an opras year
                            </p>
                            <div class="form-floating mb-3">
                                <select class="form-control btn-control text-muted" name="year" id="year" required>
                                    <option value="">select a year...</option>
                                    <?php
                                    $sql = $con->query("SELECT * from opras_year");
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                    ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['_year']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <button class="w-100 btn btn-control text-dark" type="submit" name="select" style="background-color: #fd876d">
                                Select
                            </button>
                            <hr class="my-4" />
                            <?php
                            $sql = $con->query("SELECT year_preview.id as previewId, _year FROM year_preview, opras_year WHERE year_preview.year_id = opras_year.id AND user_id = '" . $_SESSION['id'] . "' ORDER BY _year DESC");
                            if (mysqli_num_rows($sql) > 0) {
                            ?>
                                <div class="text-primary lead">Proceed with the current year <br>
                                    <?php
                                    while ($row = mysqli_fetch_object($sql)) {
                                    ?>
                                        <a class="nav-link" href="./select-year.php?previewId=<?php echo $row->previewId; ?>"><?php echo $row->_year; ?></a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <footer class="text-muted py-2 mt-auto">
        <div class="container d-flex justify-content-between">
            <p class="mb-1">
                <small><strong><span style="color: #fd876d;">MU</span>-<span class="">OPRAS</span></strong>
                    &copy; 2022, All rights reserved.
                </small>
            </p>
            <p class="float-end mb-1">
                <a href="#">Back to top</a>
            </p>
        </div>
    </footer>

    <script src="dist/js/bootstrap.bundle.min.js"></script>
</body>
<style>
    .form-control:focus {
        border: thin solid green;
        outline: none;
        box-shadow: none;
    }
</style>

</html>