<?php
    include "../config/db.php";
    $con=auth();
    if(isset($_POST['isRegister'])){
        $email=$_POST['email'];
        $pass1=$_POST['password'];
        $pass2=$_POST['confirm_password'];
        if(strlen(trim($email))!=0 && strlen(trim($pass2))!=0 && strlen(trim($pass1))!=0 && $pass1==$pass2){
            $sql_check_email_exist = "SELECT * FROM `users` WHERE email = '$email'";
            $data = $con->query($sql_check_email_exist) or die($con->error);
            $details = $data->fetch_assoc();
            if(!isset($details['email'])){
                $sql = "INSERT INTO users VALUES ('','$email','$pass1')";
                $con->query($sql) or die($con->error);
            }else{
                echo "email already exist";
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER</title>
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
            <h5><a href="../" class="nav-link px-2 text-secondary">Blood Finder</a></h5>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
            <input type="search" class="form-control form-control-dark text-white bg-dark" placeholder="Search..." aria-label="Search">
            </form>

            <div class="text-end">
            <a href="../" class="btn btn-outline-light me-2">Home</a>
            <a href="./register.php" class="btn btn-warning">Sign-up</a>
            </div>
        </div>
        </div>
    </header>
    <main class="form-signin w-50 m-auto my-5">
    <form method="POST">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="form-floating">
        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
        </div>
        <div class="form-floating">
        <input type="password" name="confirm_password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Confirm password</label>
        </div>

        <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" name="isRegister" type="submit">Register</button>
        <p class="mt-5 mb-3 text-center text-muted">&copy; 2022– <?php echo date("Y"); ?></p>
    </form>
    </main>
</body>
</html>