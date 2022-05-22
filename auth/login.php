<?php
    include "../config/db.php";
    $con=auth();
    remove_session('');
    if(isset($_POST['isLogin'])){
        $email=$_POST['email'];
        $pass1=$_POST['password'];
        $sql = "SELECT user_id FROM users WHERE email='$email' AND password='$pass1'";
        $data = $con->query($sql) or die($con->error);
        $details = $data->fetch_assoc();
        if(isset($details)){
            do{
                $_SESSION['user_id']=$details['user_id'];
            }while($details = $data->fetch_assoc());
            echo header("Refresh: 2; URL=../");
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>
<body>
        <header class="p-3 bg-dark text-white">
        <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <h5><a href="../" class="nav-link px-2 text-secondary">Blood Finder</a></h5>
            </ul>

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

        <?php 
            if(isset($_POST['isLogin'])){
                if(isset($_SESSION['user_id'])){?>
                <div class='text-success border border-success py-1 my-1 text-center rounded'>
                    Successfully Login... <br/><small>Redirecting,Please Wait!</small>
                </div>
        <?php }else{ ?>
            <div class='text-danger border border-danger py-2 text-center rounded'>
                Account does`nt Exist!!
            </div>
        <?php }
            }
        ?>

        <div class="form-floating my-1">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating my-1">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>

        <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" name="isLogin" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-center text-muted">&copy; BLOOD FINDER | 2022– <?php echo date("Y"); ?></p>
    </form>
    </main>
</body>
</html>