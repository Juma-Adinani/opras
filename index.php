<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MU-OPRAS | Open Performance Review and Appraisal</title>
  <link rel="icon" type="image/png" sizes="16x16" href="./images/logo/mu_logo.png" />
  <!-- Bootstrap core CSS -->
  <link href="./dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="vh-100 bg-white d-flex align-items-center justify-content-center">
  <div>
    <button class="btn bg-white text-secondary border-0 d-flex flex-column align-items-center" type="button" disabled>
      <div>
        <span class="spinner-grow spinner-grow-lg" role="status" aria-hidden="true"></span>
        <span class="spinner-grow spinner-grow-lg mx-2" role="status" aria-hidden="true"></span>
        <span class="spinner-grow spinner-grow-lg" role="status" aria-hidden="true"></span>
      </div>
      <p>
        <strong><span style="color: #fd876d">MU</span><span class="text-secondary">-</span><span class="text-secondary">OPRAS</span></strong>...
      </p>
    </button>
  </div>
  <?php
  header('Refresh:3; url=./login.php');
  ?>
</body>

</html>