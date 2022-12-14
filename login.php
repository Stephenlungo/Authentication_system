<?php
require_once "config.php";

$email = $password = "";
$email_err = $password_err = $login_err = "";
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    if (empty(trim($_POST['email'])) )
    {
        $email_err = "Enter a valid email address";
      
    }
    elseif(empty(trim($_POST['password'])))
    {
        $password_err = "Password field cant be empty";
    }
    else
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $sql = "SELECT id, username, pass FROM user WHERE username = ?"; //Query to get the username, password and id

        $stmt = mysqli_prepare($connection, $sql);

        mysqli_stmt_bind_param($stmt, 's', $para_email);
        $para_email = $email;
        if(mysqli_stmt_execute($stmt))
        {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) 
            {
                mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                if (mysqli_stmt_fetch($stmt)) 
                {
                    if(password_verify($password, $hashed_password))
                    {
                        session_start();
                        $_SESSION['loggedin'] =1;
                        $_SESSION['id'] = $id;
                        $_SESSION['email'] = $email;

                        header("location:profile.php");

                    }
                    else
                    {
                        $login_err = "Incorrect password";
                    }
                }
                else
                {
                    $login_err = "Something went wrong try again later";
                }
            }
            else
            {
                $login_err = "Username doesn't exist";
            }
            mysqli_stmt_close($stmt);
        }
        else
        {
            $login_err = "Something went wrong";
        }


    }

    mysqli_close($connection);

}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login | Authentication System</title>
        
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
        <img src="login.svg"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <p class="lead fw-normal mb-0 me-3">Login in with</p>
            <button type="button" class="btn btn-primary btn-floating mx-1">
              <i class="fab fa-facebook-f"></i>
            </button>

            <button type="button" class="btn btn-primary btn-floating mx-1">
              <i class="fab fa-twitter"></i>
            </button>

            <button type="button" class="btn btn-primary btn-floating mx-1">
              <i class="fab fa-linkedin-in"></i>
            </button>
          </div>

          <div class="divider d-flex align-items-center my-4">
            <p class="text-center fw-bold mx-3 mb-0">Or</p>
          </div>

          
          <div class="form-outline mb-4">
            <input type="email" id="form3Example3" class="form-control form-control-lg"
              placeholder="Enter a valid email address" name="email" />
             <?php echo $email_err; ?>
            <label class="form-label" for="form3Example3">Email address</label>
        
          </div>

         
          <div class="form-outline mb-3">
            <input type="password" id="form3Example4" class="form-control form-control-lg"
              placeholder="Enter password" name="password" />
              <?php echo $login_err ?>
            <label class="form-label" for="form3Example4">Password</label>
          </div>
       

          <div class="d-flex justify-content-between align-items-center">
            
            <div class="form-check mb-0">
              <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
              <label class="form-check-label" for="form2Example3">
                Remember me
              </label>
            </div>
            <a href="reset.php" class="text-body">Forgot password?</a>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="register.php"
                class="link-danger">Register</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
  <div
    class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
  
    <div class="text-white mb-3 mb-md-0">
      Copyright ?? <script>document.write(new Date().getFullYear())</script>. Center for Infectious Disease Research in Zambia
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