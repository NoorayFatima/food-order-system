<?php
include('../config/constants.php');
//destroy the session
session_destroy();  //uset $_SESSION['user'], this session starts to check whether user is logged in or not, 
//or to check whether the user is an authorized user or not

//redirect to login page
header("location:".SITEURL."admin/login.php");
?>