<?php include('../config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In- Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
     <div class="login">
        <h1 class="text-center">Login</h1><br><br>

        <?php 

          if(isset($_SESSION['login'])){
            echo $_SESSION['login'];
            unset($_SESSION['login']);
          }

          if(isset($_SESSION['no-login-message'])){
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
          }
          
        ?>
        <br><br>
        <form action="" method="POST" class="text-center form-login">
            
           <label for="" class="label1"> Username:</label> <input type="text" name="username" placeholder="Enter your Username"><br>

            <br>
            <label for="" class="label2">Password:</label> <input type="password" name="password" placeholder="Enter Your Password"><br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary btn-input"><br><br>
        </form>

        <p class="text-center">Created By- Noor Fatima</p>
     </div>
</body>
</html>

<?php

 if(isset($_POST['submit'])){
    //get the data from login form    mysqli_real_escape_string
    //$username = $_POST['username'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $raw_password = md5($_POST['password']);
    $password = mysqli_real_escape_string($conn, $raw_password);


//sql query to check whether the user with given username exist or not
 $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
 $res = mysqli_query($conn,$sql);

 $count = mysqli_num_rows($res);

 if($count==1){ //there should be only one user with a username and password

    $_SESSION['login'] = "<div class='success'>Login Successfull.</div>";
    $_SESSION['user'] = $username; //to check whether the user is logged in or not and logout will unset it
    header('location:'.SITEURL.'admin/');
    
 }
 else{
    //user not available
    $_SESSION['login'] = "<div class='error text-center'>Login Failed.</div>";
    // header('location:'.SITEURL.'admin/login.php');
    // exit;
    if (!isset($_SESSION['user']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
        header('location:'.SITEURL.'admin/login.php');
        exit;
    }
 }
}
?>