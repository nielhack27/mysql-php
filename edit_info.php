<?php
    include "./config/db.php";
    $con=auth();
    remove_session('');
    if(isset($_SESSION['user_id'])){
        $id=$_SESSION['user_id'];
        $sql="SELECT email,full_name,address FROM users WHERE user_id='$id'";
        $data = $con->query($sql) or die($con->error);
        $details = $data->fetch_assoc();
    }

    if(isset($_POST['isUpdate'])){
        $id=$_SESSION['user_id'];
        $email=$_POST['email'];
        $name=$_POST['name'];
        $address=$_POST['address'];
        $pass1=$_POST['password'];
        $pass2=$_POST['confirm_password'];
        if(strlen(trim($email))!=0 && strlen(trim($address))!=0 &&strlen(trim($name))!=0 && strlen(trim($pass2))!=0 && strlen(trim($pass1))!=0 && $pass1==$pass2){
            $sql_check_email_exist = "SELECT * FROM `users` WHERE email = '$email'";
            $data = $con->query($sql_check_email_exist) or die($con->error);
            $details = $data->fetch_assoc();
            if(!isset($details['email']) || $email == $details['email']){
                $sql = "UPDATE users SET email='$email', full_name='$name', address='$address',password='$pass1' WHERE user_id='$id'";
                $con->query($sql) or die($con->error);
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
       

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <h5><a href="./" class="nav-link px-2 text-warning">Blood Finder</a></h5>
        </ul>


        <?php if(!isset($_SESSION['user_id'])){?>
        <div class="text-end">
          <a href="./auth/login.php" class="btn btn-outline-light me-2">Login</a>
          <a href="./auth/register.php" class="btn btn-warning">Sign-up</a>
        </div>
        <?php }else{
        ?>

          <div class="">
            <button class="btn btn-secondary rounded dropdown-toggle py-1 px-2" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><?php echo       $details['full_name']?></button>
            <ul class="dropdown-menu my-1 bg-secondary " aria-labelledby="dropdownMenuButton1">
                <li class='text-center w-100'><a href="./" class="text-white text-decoration-none">
                  Home
                </a></li>
                <li class='text-center w-100'><a href="./edit_info.php" class="text-white text-decoration-none">
                  Edit Info
                </a></li>
                <li class='text-center w-100'><a href="./dashboard.php" class="text-white text-decoration-none">
                  Dashboard
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
  <main class='form-signin w-50 m-auto my-5'>
  <form method="POST">
        <h1 class="h3 mb-3 fw-normal">Edit <?php echo $details['full_name']; ?>`s information</h1>
        <?php if(!isset($notify) && isset($_POST['isUpdate'])){?>
            <div class='text-success border border-success py-2 text-center rounded'>
                Successfully Updated!
            </div>
        <?php }else{ 
                if(isset($notify)){
            ?>
            <div class='text-danger border border-danger py-2 text-center rounded'>
                            
                        <?php echo $notify; ?>
                  
            </div>
        <?php
        } }?>

        <div class="form-floating my-2">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" value="<?php echo $details['email'] ?>" required>
            <label for="floatingInput">Email</label>
        </div>
        <div class="form-floating my-2">
            <input type="text" name="name" class="form-control" id="floatingInput" placeholder="Juan Dela Cruz" value="<?php echo $details['full_name'] ?>" required>
            <label for="floatingInput">Full Name</label>
        </div>
        <div class="form-floating my-2">
            <input type="text" name="address" class="form-control" id="floatingInput" placeholder="name@example.com" value="<?php echo $details['address'] ?>" required>
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
        <button class="w-100 btn btn-lg btn-primary" name="isUpdate" type="submit">UPDATE</button>
        <p class="mt-5 mb-3 text-center text-muted">&copy;BLOOD FINDER | 2022– <?php echo date("Y"); ?></p>
    </form>
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