<?php  include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">

        <h2>Update Category</h2> <br><br>

         <?php

           if(isset($_GET['id'])){
                $id = $_GET['id'];
                $sql = "SELECT * FROM tbl_category WHERE id=$id";
                $res = mysqli_query($conn,$sql);
                $count = mysqli_num_rows($res);

                if($count==1){
                  $row = mysqli_fetch_assoc($res);
                  $title = $row['title'];
                  $current_image = $row['image_name'];
                  $featured = $row['featured'];
                  $active = $row['active'];
                }
                else{
                  //no category found
                  $_SESSION['no-category-found'] = "<div class='error'>No Category Found</div>";
                  header("location:".SITEURL.'admin/manage-category.php');
                }
           }
           else{
            header("location:".SITEURL.'admin/manage-category.php');
           }

         ?>

        <form action="" method="POST" enctype="multipart/form-data"> <!--allow us to upload file or image-->
        <table class="tbl-30">

         <tr>
            <td>Title:</td>
            <td>
                <input type="text" name="title" value="<?php echo $title; ?>">
            </td>
         </tr>

         <tr>
            <td>Current Image:</td>
            <td>
                <?php
                   if($current_image != ""){
                    ?>
                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="300">
                    <?php
                   }
                ?>
            </td>
         </tr>

         <tr>
            <td>New Image:</td>
            <td>
                <input type="file" name="image">
            </td>
         </tr>

         <tr>
            <td>Featured: </td>
            <td>
                <input <?php if($featured== "Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                <input <?php if($featured== "No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
            </td>
         </tr>

         <tr>
            <td>Active: </td>
            <td>
                <input <?php if($active== "Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                <input <?php if($active== "No"){echo "checked";} ?> type="radio" name="active" value="No"> No
            </td>
         </tr>

         <tr>
            <td colspan="2">
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
               <input type="submit" value="Update Category" name="submit" class="btn-secondary">
            </td>
         </tr>

      </table>
    </form>
     
    <?php

         if(isset($_POST['submit'])){

             $id = $_POST['id'];
             $title = $_POST['title'];
             $current_image = $_POST['current_image'];
             $featured = $_POST['featured'];
             $active = $_POST['active'];

             //updating the new image if selected
             //check whether the image is selected or not
             if(isset($_FILES['image']['name'])){
                //get the image details
                $image_name = $_FILES['image']['name'];
                //check whether the image is available or not
                if($image_name != ""){
                   //image available
                   //upload the image
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
                       header("location:".SITEURL.'admin/manage-category.php');
                       //stop the process
                       die();
                   }

                   //remove the current image if available
                   if($current_image != ""){
                      
                    $remove_path = "../images/category/".$current_image;
                    $remove = unlink($remove_path);
                    //check wether the image is removed or not
                    //if not removed then show message and stop the process
                    if($remove==false){
                     //failed to remove the image
                     $_SESSION['failed-remove'] = "<div class='error'>Failed To Remove Current Image</div>";
                     header("location:".SITEURL.'admin/manage-category.php');
                     die();
                    }
                   }
                 

                }
                else{
                    $image_name = $current_image;
                }
             }

             else{
                $image_name = $current_image;
             }

             //update data in database

             $sql2 = "UPDATE tbl_category SET
              title = '$title',
              image_name = '$image_name',
              featured = '$featured',
              active = '$active'
              WHERE id='$id' ";
             //redirect with message

             $res2 = mysqli_query($conn,$sql2);

             if($res2==true){
                $_SESSION['update'] = "<div class='success'>Category Updated successfully</div>";
                header("location:".SITEURL.'admin/manage-category.php');
             }
             else{
                $_SESSION['update'] = "<div class='error'>Failed To Update Category</div>";
                header("location:".SITEURL.'admin/manage-category.php');
             }
         }

    ?>

    </div>
</div>

<?php  include('partials/footer.php') ?>