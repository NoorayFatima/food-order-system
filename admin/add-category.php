<?php include('partials/menu.php');?>

<div class="main-content">
   <div class="wrapper">

    <h1>Add Category</h1>
    <br><br>
    <?php
     if(isset($_SESSION['add'])){
        echo $_SESSION['add'];
        unset($_SESSION['add']);
     }

     if(isset($_SESSION['upload'])){
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
     }
    ?> <br><br>
    <!--Add category form starts -->
      <form action="" method="POST" enctype="multipart/form-data"> <!--allow us to upload file or image-->

      <table class="tbl-30">

         <tr>
            <td>Title:</td>
            <td>
                <input type="text" name="title" placeholder="Category Title">
            </td>
         </tr>

         <tr>
            <td>Add Image:</td>
            <td>
                <input type="file" name="image">
            </td>
         </tr>

         <tr>
            <td>Featured: </td>
            <td>
                <input type="radio" name="featured" value="Yes"> Yes
                <input type="radio" name="featured" value="No"> No
            </td>
         </tr>

         <tr>
            <td>Active: </td>
            <td>
                <input type="radio" name="active" value="Yes"> Yes
                <input type="radio" name="active" value="No"> No
            </td>
         </tr>

         <tr>
            <td colspan="2">
               <input type="submit" value="Add Category" name="submit" class="btn-secondary">
            </td>
         </tr>

      </table>

      </form>
    <!--Add category form ends -->

   </div>
</div>

<?php include('partials/footer.php');?>

<?php
 if(isset($_POST['submit'])){

    $title = $_POST['title'];
    //checking whether the radio buttons are clicked or not
    if(isset($_POST['featured'])){
     //get the value from form
     $featured = $_POST['featured'];
    }
    else{
        $featured = "No";
    }

    if(isset($_POST['active'])){
        //get the value from form
        $active = $_POST['active'];
       }
       else{
           $active = "No";
       }
    
    //check whether the image is selecyed or not and accordingly select image name
   // print_r($_FILES['image']);
    //die();
    if(isset($_FILES['image']['name'])){
        //upload the image
        //to upload image we need image name, source path and destination path

        $image_name = $_FILES['image']['name'];
        if($image_name != ""){ //upload image only if available, otherwise countinue processing the form
            
        
        //auto rename our image, so that if user adds the same image again it should  also be added as a separate image, it must not be replaced by the previous one
        //get the extension of our image
        $ext = end(explode('.',$image_name));
        //rename the image
        $image_name = "food_category_".rand(000,999).'.'.$ext;
        $source_path = $_FILES['image']['tmp_name']; 
        $destination_path = "../images/category/".$image_name;

        //finally upload the file
        $upload = move_uploaded_file($source_path,$destination_path);

        //check wthere the image is uploaded or not
        //and if image is not uploaded then we will stop the process and redirect with error message
        if($upload==FALSE){

            $_SESSION['upload'] = "<div class='error'>Failed To Upload Image. Try Again.</div>";
            header("location:".SITEURL.'admin/add-category.php');
            //stop the process
            die();
        }
      }
    }
    else{
        //don't upload the image and set the image_name value as blank
        $image_name = "";
    }
    

    //create sql query to insert category data in database
    $sql = "INSERT INTO tbl_category SET
       title = '$title',
       image_name = '$image_name',
       featured = '$featured',
       active = '$active'
    ";

    $res = mysqli_query($conn,$sql);

    if($res==TRUE){
        $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
        header("location:".SITEURL.'admin/manage-category.php');
    }
    else{
        $_SESSION['add'] = "<div class='error'>Unable To Add Category.Try Again.</div>";
        header("location:".SITEURL.'admin/add-category.php'); 
    }

 }
?>