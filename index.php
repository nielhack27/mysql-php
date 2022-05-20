<?php
    include "./config/db.php";
    $con=auth();
    if(isset($_SESSION['user_id'])){
        $id=$_SESSION['user_id'];
        $sql="SELECT email FROM users WHERE user_id='$id'";
        $data = $con->query($sql) or die($con->error);
        $details = $data->fetch_assoc();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Blood Bank Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>
<body>
<header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <h5><a href="./" class="nav-link px-2 text-secondary">Blood Finder</a></h5>
        </ul>

        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
          <input type="search" class="form-control form-control-dark text-white bg-dark" placeholder="Search..." aria-label="Search">
        </form>

        <?php if(!isset($_SESSION['user_id'])){?>
        <div class="text-end">
          <a href="./auth/login.php" class="btn btn-outline-light me-2">Login</a>
          <a href="./auth/register.php" class="btn btn-warning">Sign-up</a>
        </div>
        <?php }else{
        ?>
            <div class="text-end">
            <a href="./" class="btn btn-outline-light me-2"><?php echo $details['email']?></a>
                <a href="./auth/logout.php" class="btn btn-warning">LOGOUT</a>
            </div>
        <?php } ?>
      </div>
    </div>
  </header>
    main page
</main>
</body>
</html>