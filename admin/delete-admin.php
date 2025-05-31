<?php

include('../config/constants.php');

$id = $_GET['id'];

$sql = "DELETE FROM tbl_admin WHERE id=$id";

$res = mysqli_query($conn,$sql);

if($res==TRUE){
    $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>"; //session variable created to show success message
    //redirect to manage admin page bcz we want to show success message on manage admin page
    header('location:'.SITEURL.'admin/manage-admin.php');
}
else{

    $_SESSION['delete'] = "<div class='error'>Failed To Delete Admin. Try Again Later.</div>"; 
    header('location:'.SITEURL.'admin/manage-admin.php');
}

?>