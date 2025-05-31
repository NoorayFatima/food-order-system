<?php 

 include('../config/constants.php');

 if(isset($_GET['id']) && isset($_GET['image_name'])){

      $id = $_GET['id'];
      $image_name = $_GET['image_name'];
     // delete the physical image if it is available
     if($image_name != ""){
        //image is available
        $path = "../images/food/".$image_name;
        $remove = unlink($path); //unlink is a built in function which deletes the image and take the image source as a parameter and it returns boolean value either true or false
        //if failed to remove image then stop the process and display error message
        if($remove==false){
            //set the session message
            $_SESSION['remove'] = "<div class='error'>Failed to delete Food Image.</div>";
            //redirect to manage category page
            header("location:".SITEURL.'admin/manage-food.php');
            //stop the process
            die();
        }
    }

     //delete data from database

     $sql = "DELETE FROM tbl_food WHERE id=$id";
     $res = mysqli_query($conn,$sql);

     if($res==TRUE){

        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
        header("location:".SITEURL.'admin/manage-food.php');
     }
     else{
        
        $_SESSION['delete'] = "<div class='error'>Failed To Delete Food.</div>";
        header("location:".SITEURL.'admin/manage-food.php');
     }

 }
 else{
    //redirect to manage category page
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorize Access.</div>";
    header("location:".SITEURL.'admin/manage-food.php');
 }

?>