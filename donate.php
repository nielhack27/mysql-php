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
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
    crossorigin="anonymous"
  />
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"
    defer
  ></script>
    
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

          <div class="">
            <button class="btn btn-secondary rounded dropdown-toggle p-1" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $details['email']?></button>
            <ul class="dropdown-menu my-1 bg-secondary " aria-labelledby="dropdownMenuButton1">
                <li class='text-center w-100'><a href="./dashboard.php" class="text-white text-decoration-none">
                  Dashboard
                </a></li>
                <li class='text-center w-100'><a href="./donate.php" class="text-white text-decoration-none">
                  Donate
                </a></li>
                <li class='text-center w-100'><a href="./auth/logout.php" class="text-warning text-decoration-none">
                  Log out
                </a></li>
            </ul>
          </div>
        <?php } ?>
      </div>
    </div>
  </header>
  <main class='mt-3 w-100'>
  </main>
</body>
</html>

<style>
  tr:nth-child(odd){
    background:white;
  }

  tr:nth-child(even){
    background:#f2f2f2;
  }
</style>