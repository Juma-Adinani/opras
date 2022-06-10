<?php
session_start();
if ($_SESSION['role'] != 'HR') {
    header("location:./supervisor-page.php");
}
include './config/connect.php';
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

<body class="d-flex flex-column justify-content-between bg-light" style="min-height: 100vh;">
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
            <section class="py-2 text-center container">
                <div class="container py-2">
                    <center>
                        <form action="" class=" d-flex justify-content-center">
                            <div class="form-group row">
                                <div class="col-10">
                                    <input type="search" class="form-control" placeholder="search..." />
                                </div>
                                <div class="col-2 d-flex justify-content-start">
                                    <button class="btn btn-outline-success">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </center>
                </div>
            </section>

            <div class="album py-5">
                <div class="container">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 bg-muted">
                        <?php
                        $sql = $con->query("SELECT year_preview.id as id, firstname, surname, _year 
                                            FROM year_preview, users, opras_year 
                                            WHERE year_preview.user_id = users.id
                                            AND year_preview.year_id = opras_year.id
                                            ORDER BY _year DESC
                                          ");

                        if (mysqli_num_rows($sql) > 0) {
                            while ($row = mysqli_fetch_object($sql)) {
                        ?>
                                <div class="col-sm-3 bg-white shadow-sm m-3 text-center nav-link">
                                    <img src="./images/folder.png" alt="#" width="180"><br>
                                    <span><?php echo $row->firstname . '&nbsp;' . $row->surname; ?></span>
                                    <p class="">Opras Year: <?php echo $row->_year; ?></p>
                                    <form action="" method="post">
                                        <input type="text" name="id" value="<?php echo $row->id; ?>" hidden>
                                        <button class="btn btn-outline-success btn-sm w-100" type="submit" name="assess">Generate report</button>
                                    </form>
                                </div>
                        <?php
                            }
                        } else {
                            echo '<div class="alert alert-warning col-12">No available opras to generate report on</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <footer class="text-muted mt-auto py-3">
        <div class="container d-flex justify-content-between">
            <p class="mb-1">
                <small><strong><span style="color: #fd876d;">MU</span>-<span class="">OPRAS</span></strong>
                    &copy; 2022, All rights reserved.</small>
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

    body {
        overflow-x: hidden;
    }
</style>

</html>