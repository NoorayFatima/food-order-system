<?php
 //Authorization-Access Control
 //check whether the user is logged-in or not
 if(!isset($_SESSION['user'])){  //if user session is not set
   //means that user is not logged-in
   //redirect to login page with message
   $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login To Access Admin Panel!</div>";
   //redirect to login page
   header("location:".SITEURL."admin/login.php");
 }
?>