<?php
    include "./config/db.php";
    $con=auth();
    remove_session('notification');
    if(isset($_SESSION['user_id'])){
        $id=$_SESSION['user_id'];
        $sql="SELECT email,full_name,address FROM users WHERE user_id='$id'";
        $data = $con->query($sql) or die($con->error);
        $details = $data->fetch_assoc();
    }

    if(isset($_GET['isRequesting'])){
      if(isset($_SESSION['user_id'])){
        $donate_id = $_GET['donate_id'];
        $req_id = $_SESSION['user_id'];
        $req_liter = $_GET['req_liter'];
        $total_liter_available = $_GET['total_liter_available'];
        if(isset($req_id) && isset($donate_id) && strlen(trim($req_liter))!=0 && $req_liter>0){
            $attempt_sql = "SELECT request_id FROM request_details WHERE request_user_id='$req_id' AND request_donations_id='$donate_id'";
            $attempt_data = $con->query($attempt_sql) or die($con->error);
            $attempt_details = $attempt_data->fetch_assoc();
            if(!isset($attempt_details['request_id'])){
                if($total_liter_available>=$req_liter){
                  $sql = "INSERT INTO request_details VALUES('','$req_id','$donate_id','$req_liter','PENDING')";
                  $data=$con->query($sql) or die($con->error);
                  $_SESSION['notification'] = "<p id='notification' class='text-success border border-success rounded'>REQUEST SENT</p>";
                }else{
                  $_SESSION['notification'] = "<p id='notification' class='text-danger border border-danger rounded'>REQUEST DENIED, REQUESTING LITERS IS TOO BIG!</p>";
                }
            }else{
                $_SESSION['notification'] = "<p id='notification' class='text-danger border border-danger rounded'>REQUEST DENIED, ALREADY SENT A REQUEST !</p>";
            }
            echo header("location:./");
        }else{
            $_SESSION['notification'] = "<p id='notification' class='text-danger border border-danger rounded'>REQUEST DENIED</p>";
        }
      }else{
        echo header('location:./auth/login.php');
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

        <form method="GET" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
          <input type="text" name="search" class="form-control form-control-dark text-white bg-dark" placeholder="Search for Hospitals..." aria-label="Search">
        </form>

        <?php if(!isset($_SESSION['user_id'])){?>
        <div class="text-end">
          <a href="./auth/login.php" class="btn btn-outline-light me-2">Login</a>
          <a href="./auth/register.php" class="btn btn-warning">Sign-up</a>
        </div>
        <?php }else{
        ?>

          <div class="">
            <button class="btn btn-secondary rounded dropdown-toggle py-1 px-2" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $details['full_name']?></button>
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
                <li class='text-center w-100'>
                  <a href="./auth/logout.php" class="text-warning text-decoration-none">
                    Log out
                  </a>
                </li>
            </ul>
          </div>

          <div class="mx-3">
            <button style="width:55px" class="btn btn-secondary rounded dropdown-toggle p-1" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmarks" viewBox="0 0 16 16">
                  <path d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5V4zm2-1a1 1 0 0 0-1 1v10.566l3.723-2.482a.5.5 0 0 1 .554 0L11 14.566V4a1 1 0 0 0-1-1H4z"/>
                  <path d="M4.268 1H12a1 1 0 0 1 1 1v11.768l.223.148A.5.5 0 0 0 14 13.5V2a2 2 0 0 0-2-2H6a2 2 0 0 0-1.732 1z"/>
                </svg>
            </button>
            <?php  
              $show_notify = "SELECT * FROM request_details
              NATURAL JOIN donations,users
              WHERE donations.donation_id = request_details.request_donations_id
              AND users.user_id =request_details.request_user_id
              AND request_user_id = '$id'
              AND status!='PENDING'
              ";
              $show_notify_data = $con->query($show_notify) or die($show_notify);
              $show_notify_details = $show_notify_data->fetch_assoc();
            ?>
            <ul class="dropdown-menu my-1 bg-primary text-warning " aria-labelledby="dropdownMenuButton2">
                <li class='text-center w-100'>
                  <table class='mx-3'>
                      <tr class='border bg-primary'>
                        <th colspan='1' class='px-1'>Donator</th>
                        <th colspan='1' class='px-1'>Hospital</th>
                        <th colspan='1' class='px-1'>Address</th>
                        <th colspan='1' class='px-1'>Liters Need</th>
                        <th colspan='1' class='px-1'>BloodType</th>
                        <th colspan='1' class='px-1'>STATUS</th>
                      </tr>
                  <?php
                    if(isset($show_notify_details)){
                      do{
                        $donator_id=$show_notify_details['request_donations_id'];
                        $get_donator = "SELECT full_name 
                        FROM users NATURAL JOIN donations
                        WHERE users.user_id = donations.user_donating
                        AND donation_id='$donator_id'";
                        $get_donator_full = $con->query($get_donator) or die($con->error);
                        $get_donator_full_name = $get_donator_full->fetch_assoc();
                        ?>
                          <tr class='<?php if($show_notify_details['status']=='APPROVED'){ echo 'bg-success';   }else{ echo 'bg-danger'; }?>'>
                            <td colspan="1" class='px-1 text-center'>
                              <?php echo $get_donator_full_name['full_name'];?>
                            </td>
                            <td colspan="1" class='text-center'>
                              <?php echo $show_notify_details['hospital'];?>
                            </td>
                            <td colspan="1" class='text-center'>
                              <?php echo $show_notify_details['address'];?>
                            </td>
                            <td colspan="1" class='text-center'>
                              <?php echo $show_notify_details['request_liters'];?> L
                            </td>
                            <td colspan="1" class='text-center'>
                              <?php echo $show_notify_details['offer_blood_type'];?>
                            </td>
                            <td colspan="1" class='text-center'>
                              <?php echo $show_notify_details['status'];?>
                            </td>
                          </tr>
                        <?php 
                      }while($show_notify_details = $show_notify_data->fetch_assoc());
                    }else{
                      echo "EMPTY";
                    }
                  ?>
              </table>
              </li>
            </ul>
          </div>

        <?php } ?>
      </div>
    </div>
  </header>
  <main class='mt-3 w-100'>
    <?php
        if(isset($_SESSION['user_id']) && isset($_GET['search'])){
          $id=$_SESSION['user_id'];
          $search = $_GET['search'];
          $sql="SELECT * FROM donations 
          NATURAL JOIN users
          WHERE users.user_id=donations.user_donating 
          AND users.user_id!='$id'
          AND donations.hospital LIKE '%$search%'
          ";
        }
        else if (isset($_SESSION['user_id'])){
          $id=$_SESSION['user_id'];
          $sql="SELECT * FROM donations NATURAL JOIN users WHERE users.user_id=donations.user_donating AND users.user_id!=$id";
        }else{
          $sql="SELECT * FROM donations NATURAL JOIN users WHERE users.user_id=donations.user_donating";
        }
        $donation = $con->query($sql) or die($con->error);
        $donation_details = $donation->fetch_assoc();
    
    
    
    
    ?>
    <table class='center w-75 rounded m-auto'>
      <div class='w-75 m-auto text-center'><?php
        if(isset($_SESSION['notification'])){
          echo $_SESSION['notification'];
        }
      ?></div>
    <tr class='border bg-success'>
      <th colspan="1" class='text-center'>donator</th>
      <th colspan="1" class='text-center'>Hospital</th>
      <th colspan="1" class='text-center'>Address</th>
      <th colspan="1" class='text-center'>Liters</th>
      <th colspan="1" class='text-center'>Blood Type</th>
      <th colspan="1" class='text-center'>Send Request</th>
    </tr>
    <?php
      if(isset($donation_details)){
      do{
        $donate = $donation_details['donation_id'];
        $sql_available_liters = "SELECT sum(request_liters) as total_liter
        FROM request_details
        NATURAL JOIN donations
        WHERE donations.donation_id = request_details.request_donations_id
        AND request_details.request_donations_id = '$donate'
        AND status !='CANCELLED'
        AND status !='PENDING'
        ";
        $sql_available_data = $con->query($sql_available_liters) or die($con->error);
        $sql_available_details = $sql_available_data->fetch_assoc();
        if($sql_available_details['total_liter']<$donation_details['liters']){
    ?>
    <tr>
      <td colspan="1" class='text-center'><?php echo $donation_details['full_name']  ?></td>
      <td colspan="1" class='text-center'><?php echo $donation_details['hospital']  ?></td>
      <td colspan="1" class='text-center'><?php echo $donation_details['address']  ?></td>
      <td colspan="1" class='text-center'><?php echo $donation_details['liters']-$sql_available_details['total_liter']  ?> L</td>
      <td colspan="1" class='text-center'><?php echo $donation_details['offer_blood_type']  ?></td>
      <td colspan="1" class='text-center'>
        <form method="GET" class='d-flex justify-content-center align-items-center'>
          <label>Liters:</label>
          <input style="width:50px;height:35px;" class='mx-3' type="number" name="req_liter">
          <input style="display:none" value="<?php echo $donation_details['donation_id']; ?>" name="donate_id">
          <input style="display:none" value="<?php echo $donation_details['liters']-$sql_available_details['total_liter']?>" name="total_liter_available">
          <button  class='btn btn-success' type="submit" name="isRequesting">
            <svg class='text-dark' xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
              <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
            </svg>
          </button>
        </form>
      </td>
    </tr>
    <?php } }while($donation_details = $donation->fetch_assoc()); } ?>
    </table>
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