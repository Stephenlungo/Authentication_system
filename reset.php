<?php
require_once "config.php";
session_start();


$current_password = $new_password = $repeat_password = "";
$current_password_err = $new_password_err = $repeat_password_err = $reset = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") 
{

    if (empty($_POST['current_password'])) 
    {
        $current_password_err = "The current password field is empty";
    }
    elseif(empty($_POST['new_password']))
    {
        $new_password_err = "The new password field is empty";
    }elseif(empty($_POST['repeat_password']))
    {
        $repeat_password_err ="The repeat password field is empty";
    }
    else
    {
        $id = $_SESSION['id'];
        $current_password = $_POST['current_password'];

        $sql = "SELECT pass FROM user WHERE id = ?";

        $stmt = mysqli_prepare($connection, $sql);

        mysqli_stmt_bind_param($stmt, "i", $param_id);

        $param_id = $id;
        
        if(mysqli_stmt_execute($stmt)) //this block of code executes the following statements
        {
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $current_hashed_password);

            if (mysqli_stmt_fetch($stmt)) 
            {
                if (password_verify($current_password, $current_hashed_password)) 
                {
                    $new_password = $_POST['new_password'];
                    $repeat_password = $_POST['repeat_password'];

                    if ($new_password == $repeat_password) 
                    {
                        $sql1 = "UPDATE user SET pass = ? WHERE id = ?";

                        $stmt1 = mysqli_prepare($connection, $sql1);

                        mysqli_stmt_bind_param($stmt1, "si", $param_new_password, $param_id);

                        $param_id = $id;
                        $param_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                        if(mysqli_stmt_execute($stmt1))
                        {
                            header("Location:login.php");
                        }
                        else
                        {
                            $reset_err = "Failed to reset the passowrd";
                        }
                        mysqli_stmt_close($stmt1);
                    }
                    else
                    {
                        $new_password_err = "Passwords did not match";
                    }
            
                }
                else
                {
                    $current_password_err = "Current password did not match";
                }
            }
            else
            {
                $reset_err = "Something went wrong";
            }
            mysqli_stmt_close($stmt);
        }

    }

    mysqli_close($connection);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Password Reset | Authentication System</title>
        
      <link href="style.css" rel="stylesheet"/>
      
      <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        rel="stylesheet"
      />
      
      <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
        rel="stylesheet"
      />
     
      <link
        href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css"
        rel="stylesheet"
      />
      
      <script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"
      ></script>


    </head>
<body>
<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="reset.svg"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <p class="lead fw-normal mb-0 me-3">Forgot Password?</p>
            

            
          </div>

          <div class="divider d-flex align-items-center my-4">
            <p class="text-center fw-bold mx-3 mb-0">Password Reset</p>
          </div>
         
          <div class="form-outline mb-3">
            <input type="password" id="form3Example4" class="form-control form-control-lg"
              placeholder="Enter password" name="current_password" />
             <?php echo $current_password_err; ?>
            <label class="form-label" for="form3Example4">Current Password</label>
          </div>
          <div class="form-outline mb-3">
            <input type="password" id="form3Example4" class="form-control form-control-lg"
              placeholder="Enter password" name="new_password" />
              <?php echo $new_password_err; ?>
            <label class="form-label" for="form3Example4">New Password</label>
          </div>
          <div class="form-outline mb-3">
            <input type="password" id="form3Example4" class="form-control form-control-lg"
              placeholder="Enter password" name="repeat_password" />
              <?php echo $repeat_password_err; ?>
            <label class="form-label" for="form3Example4">Repeat New Password</label>
          </div>
                <?php $reset_err; ?>
          <div class="d-flex justify-content-between align-items-center">
            
           

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Change</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Don't want to change password? <a href="login.php"
                class="link-danger">Login</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
  <div
    class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
  
    <div class="text-white mb-3 mb-md-0">
      Copyright © <script>document.write(new Date().getFullYear())</script>. Center for Infectious Disease Research in Zambia
    </div>
  

  
    <div>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-google"></i>
      </a>
      <a href="#!" class="text-white">
        <i class="fab fa-linkedin-in"></i>
      </a>
    </div>
  
  </div>
</section>
    </body>
</html>