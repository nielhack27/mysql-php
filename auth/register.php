<?php
    include "../config/db.php";
    $con=auth();
    remove_session('');
    if(isset($_POST['isRegister'])){
        $email=$_POST['email'];
        $name=$_POST['name'];
        $address=$_POST['address'];
        $pass1=$_POST['password'];
        $pass2=$_POST['confirm_password'];
        if(strlen(trim($email))!=0 && strlen(trim($address))!=0 &&strlen(trim($name))!=0 && strlen(trim($pass2))!=0 && strlen(trim($pass1))!=0 && $pass1==$pass2){
            $sql_check_email_exist = "SELECT * FROM `users` WHERE email = '$email'";
            $data = $con->query($sql_check_email_exist) or die($con->error);
            $details = $data->fetch_assoc();
            if(!isset($details['email'])){
                $sql = "INSERT INTO users VALUES ('','$email','$name','$address','$pass1')";
                $con->query($sql) or die($con->error);
                echo header("Refresh: 3; URL=./login.php");
            }else{
                $notify = "email already exist";
            }
        }else{
            $notify ="Password and Confirm password is not matched!!";
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

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <h5><a href="../" class="nav-link px-2 text-secondary">Blood Finder</a></h5>
            </ul>

            <div class="text-end">
            <a href="../" class="btn btn-outline-light me-2">Home</a>
            <a href="./login.php" class="btn btn-warning">Login</a>
            </div>
        </div>
        </div>
    </header>
    <main class="form-signin w-50 m-auto my-5">
    <form method="POST">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        <?php if(!isset($notify) && isset($_POST['isRegister'])){?>
            <div class='text-success border border-success py-2 text-center rounded'>
                <p>Successfully Register... <br/><small>Redirecting,Please Wait!</small></p>
            </div>
        <?php }else{ 
                if(isset($notify)){
            ?>
            <div class='text-danger border border-danger py-2 text-center rounded'>
                            
                        echo $notify; 
                  
            </div>
        <?php
        } }?>

        <div class="form-floating my-2">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
            <label for="floatingInput">Email</label>
        </div>
        <div class="form-floating my-2">
            <input type="text" name="name" class="form-control" id="floatingInput" placeholder="Juan Dela Cruz" required>
            <label for="floatingInput">Full Name</label>
        </div>
        <div class="form-floating my-2">
            <input type="text" name="address" class="form-control" id="floatingInput" placeholder="name@example.com" required>
            <label for="floatingInput">Address</label>
        </div>
        <div class="form-floating my-2">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
        </div>
        <div class="form-floating my-2">
            <input type="password" name="confirm_password" class="form-control" id="floatingPassword" placeholder="Password" required>
            <label for="floatingPassword">Confirm password</label>
        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" name="isRegister" type="submit">Register</button>
        <p class="mt-5 mb-3 text-center text-muted">&copy; BLOOD FINDER 2022– <?php echo date("Y"); ?></p>
    </form>
    </main>
</body>
</html>