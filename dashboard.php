<?php
    include "./config/db.php";
    remove_session('donate');
    $con=auth();
    if(isset($_SESSION['user_id'])){
        $id=$_SESSION['user_id'];
        $sql="SELECT email,full_name FROM users WHERE user_id='$id'";
        $data = $con->query($sql) or die($con->error);
        $details = $data->fetch_assoc();
    }


    if(isset($_POST['isDonate'])){
        $id=$_SESSION['user_id'];
        $hospital = $_POST['hospital'];
        $blood_liters = $_POST['blood_liters'];
        $blood_type = $_POST['blood_type'];
        if(strlen(trim($hospital))!=0 && strlen(trim($blood_type))!=0 && $blood_liters>0){
            $sql = "INSERT INTO donations VALUES('','$id','$hospital','$blood_type','$blood_liters')";
            $data_donate = $con->query($sql) or die($con->error);
            $_SESSION['donate'] = "<p class='text-center w-75 m-auto rounded text-success border border-success'>DONATION SUCCESSFULLY CREATED</p>";
        }else{
          $_SESSION['donate'] = "<p class='text-center w-75 m-auto rounded text-danger border border-danger'>CREATING DONATION FAILURE!</p>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard</title>
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
          <input type="text" name="search" class="form-control form-control-dark text-white bg-dark" placeholder="Search for hospitals..." aria-label="Search">
        </form>

        <?php if(!isset($_SESSION['user_id'])){?>
        <div class="text-end">
          <a href="./auth/login.php" class="btn btn-outline-light me-2">Login</a>
          <a href="./auth/register.php" class="btn btn-warning">Sign-up</a>
        </div>
        <?php }else{
        ?>

          <div class="">
            <button class="btn btn-secondary rounded dropdown-toggle p-1" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $details['full_name']?></button>
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
  <main class='mt-3 w-100'>
  <?php
      if(isset($_SESSION['donate'])){
          echo $_SESSION['donate'];
    }?>
  <div class="w-100 m-auto mx-2 py-1">
    <button class="btn btn-secondary rounded dropdown-toggle p-1" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">Make A Donation
    </button>
    
    <form method="POST" class="dropdown-menu my-1 bg-secondary p-3" aria-labelledby="dropdownMenuButton1">
        <div class="form-floating my-1">
            <input type="text" name="hospital" class="form-control" id="floatingInput" placeholder="st.peter">
            <label for="floatingInput">Hospital</label>
        </div>
        <div class="form-floating my-1">
            <input type="number" name="blood_liters" class="form-control" id="floatingPassword" placeholder="Blood liter">
            <label for="floatingPassword">Blood Liter</label>
        </div>
        <select class='my-1 rounded' name="blood_type" class='rounded'>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
        </select>
        <label class='text-white'>Blood Type</label>
        <input type="submit" class='btn btn-warning w-100 rounded' name="isDonate">
    </form>
    </div>
    
    <div class='row mx-2'>
          <table class='col align-self-start rounded'>
            <tr class='border bg-success w-100 text-center'>
                <th colspan="5">DONATIONS INFO</th>
            </tr>
                <tr class='border bg-success'>
                <th colspan="1" class='text-center'>ID</th>
                <th colspan="1" class='text-center'>Hospital</th>
                <th colspan="1" class='text-center'>Liters</th>
                <th colspan="1" class='text-center'>Blood Type</th>
                <th colspan="1" class='text-center'>Cancel</th>
            </tr>
            <?php
                $id=$_SESSION['user_id'];
                if(isset($_GET['search'])){
                  $search=$_GET['search'];
                  $sql = "SELECT * FROM donations 
                  WHERE user_donating='$id'
                  AND hospital LIKE '%$search%'
                  ";
                }else{
                  $sql = "SELECT * FROM donations WHERE user_donating='$id'";
                }
                $donate = $con->query($sql) or die($con->error);
                $donate_data = $donate->fetch_assoc();
                if(isset($donate_data)){
                do{
                    $donation_id=$donate_data['donation_id'];
            ?>
            <tr>
                <td colspan="1" class='text-center'>#<?php echo $donation_id; ?></td>
                <td colspan="1" class='text-center'><?php echo $donate_data['hospital']; ?></td>
                <td colspan="1" class='text-center'><?php echo $donate_data['liters']; ?></td>
                <td colspan="1" class='text-center'><?php echo $donate_data['offer_blood_type']; ?></td>
                <td colspan="1" class='text-center'>
                    <a class='text-danger' href="./delete_donation.php?id=<?php echo $donation_id; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                    </svg></a>
                </td>
            </tr>
            <?php }while($donate_data = $donate->fetch_assoc()); }?>
        </table>

        <?php
          if(isset($_GET['search'])){
            $search=$_GET['search'];
            $sql_request = "SELECT status,request_id,request_details.request_liters as DL, donations.donation_id as DId, users.full_name as user_requesting,donations.offer_blood_type as RBT, donations.hospital  as hospital 
            FROM request_details
            NATURAL JOIN users,donations
            WHERE users.user_id = request_details.request_user_id
            AND donations.donation_id = request_details.request_donations_id
            AND donations.user_donating = '$id'
            AND hospital LIKE '%$search%'
            ";
          }else{
            $sql_request = "SELECT status,request_id,request_details.request_liters as DL, donations.donation_id as DId, users.full_name as user_requesting,donations.offer_blood_type as RBT, donations.hospital  as hospital 
            FROM request_details
            NATURAL JOIN users,donations
            WHERE users.user_id = request_details.request_user_id
            AND donations.donation_id = request_details.request_donations_id
            AND donations.user_donating = '$id'
            ";
          }
          $data_sql_request = $con->query($sql_request) or die($con->error);
          $details_sql_request = $data_sql_request->fetch_assoc();
        
        
        ?>


        <table class='col align-self-start rounded mb-3'>
            <tr class='border bg-success w-100 text-center'>
                <th colspan="6">CLIENTS INFO</th>
            </tr>
            <tr class='border bg-success'>
                <th colspan="1" class='text-center'>ID</th>
                <th colspan="1" class='text-center'>Requesting</th>
                <th colspan="1" class='text-center'>Blood Type</th>
                <th colspan="1" class='text-center'>Hospital</th>
                <th colspan="1" class='text-center'>Liters</th>
                <th colspan="1" class='text-center'>Approval</th>
            </tr>
            <?php
              if(isset($details_sql_request) && $details_sql_request['status']!="CANCEL"){
                do{
            ?>
            <tr>
                <td colspan="1" class='text-center'>#<?php echo $details_sql_request['DId']; ?></td>
                <td colspan="1" class='text-center'><?php echo $details_sql_request['user_requesting']; ?></td>
                <td colspan="1" class='text-center'><?php echo $details_sql_request['RBT']; ?></td>
                <td colspan="1" class='text-center'><?php echo $details_sql_request['hospital']; ?></td>
                <td colspan="1" class='text-center'><?php echo $details_sql_request['DL']; ?></td>
                <td colspan="1" class='text-center'>
                  <?php if($details_sql_request['status']=='PENDING'){ ?>
                  <a href="./approval.php?DL=<?php echo $details_sql_request['DL'] ?>&isApprove=True&request_id=<?php echo $details_sql_request['request_id']; ?>" class="mx-1"><svg class='text-success' xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                    <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                  </svg></a>
                  <a href="./approval.php?isApprove=False&request_id=<?php echo $details_sql_request['request_id']; ?>" class="mx-1"><svg class='text-danger' xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-x" viewBox="0 0 16 16">
                      <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                      <path fill-rule="evenodd" d="M12.146 5.146a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                    </svg></a>
                    <?php } else if($details_sql_request['status']=='APPROVED'){ ?>
                        <svg class='text-success' xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                          <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                          <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                        </svg>
                    <?php } else if($details_sql_request['status']=='CANCELLED'){ ?>
                      <svg class='text-danger' xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-x" viewBox="0 0 16 16">
                      <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                      <path fill-rule="evenodd" d="M12.146 5.146a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                    </svg>
                    <?php } ?>
                </td>
            </tr>
            <?php }while($details_sql_request = $data_sql_request->fetch_assoc()); }?>
        </table>

        
    </div>
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