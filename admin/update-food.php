<?php  include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">

        <h2>Update Food</h2> <br><br>

         <?php

           if(isset($_GET['id'])){
                $id = $_GET['id'];
                $sql = "SELECT * FROM tbl_food WHERE id=$id";
                $res = mysqli_query($conn,$sql);
                $count = mysqli_num_rows($res);

                if($count==1){
                  $row = mysqli_fetch_assoc($res);
                  $title = $row['title'];
                  $description = $row['description'];
                  $price = $row['price'];
                  $current_category = $row['category_id'];
                  $current_image = $row['image_name'];
                  $featured = $row['featured'];
                  $active = $row['active'];
                }
                else{
                  //no category found
                  $_SESSION['no-category-found'] = "<div class='error'>No Food Item Found</div>";
                  header("location:".SITEURL.'admin/manage-food.php');
                }
           }
           else{
            header("location:".SITEURL.'admin/manage-food.php');
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
            <td>Description:</td>
            <td>
                <textarea name="description" cols="25" rows="5"><?php echo $description; ?></textarea>
            </td>
        </tr>

        <tr>
            <td>Price:</td>
            <td>
                <input type="number" name="price" value="<?php echo $price; ?>">
            </td>
        </tr>

         <tr>
            <td>Current Image:</td>
            <td>
                <?php
                   if($current_image != ""){
                    ?>
                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="300">
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
            <td>Category:</td>
            <td>
                <select name="category">

                <?php
                  //php code to display categories from database
                  //sql query to get all active categories from database
                  $sql2 = "SELECT * FROM tbl_food WHERE active='Yes'";
                  $res2 = mysqli_query($conn,$sql2);
                  $count2 = mysqli_num_rows($res2);

                  if($count>0){
                    //categories available
                        while($row2=mysqli_fetch_assoc($res2)){
                             $category_id = $row2['category_id'];
                             $category_title = $row2['title'];

                             ?>
                               <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                             <?php
                        }

                    
                  }
                  else{
                    //categories not available
                    ?>
                     <option value="0">No Category Found</option>
                    <?php
                  }
                ?>
                </select>
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
               <input type="submit" value="Update Food" name="submit" class="btn-secondary">
            </td>
         </tr>

      </table>
    </form>
     
    <?php

         if(isset($_POST['submit'])){

             $id = $_POST['id'];
             $title = $_POST['title'];
             $description = $_POST['description'];
             $price = $_POST['price'];
             $category = $_POST['category'];
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
                   $image_name = "food_Name_".rand(0000,9999).'.'.$ext;
                   $source_path = $_FILES['image']['tmp_name']; 
                   $destination_path = "../images/food/".$image_name;
           
                   //finally upload the file
                   $upload = move_uploaded_file($source_path,$destination_path);
           
                   //check wthere the image is uploaded or not
                   //and if image is not uploaded then we will stop the process and redirect with error message
                   if($upload==FALSE){
           
                       $_SESSION['upload'] = "<div class='error'>Failed To Upload Image. Try Again.</div>";
                       header("location:".SITEURL.'admin/manage-food.php');
                       //stop the process
                       die();
                   }

                   //remove the current image if available
                   if($current_image != ""){
                      
                    $remove_path = "../images/food/".$current_image;
                    $remove = unlink($remove_path);
                    //check wether the image is removed or not
                    //if not removed then show message and stop the process
                    if($remove==false){
                     //failed to remove the image
                     $_SESSION['failed-remove'] = "<div class='error'>Failed To Remove Current Image</div>";
                     header("location:".SITEURL.'admin/manage-food.php');
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

             $sql3 = "UPDATE tbl_food SET
              title = '$title',
              description = '$description',
              price = '$price',
              category_id = '$category',
              image_name = '$image_name',
              featured = '$featured',
              active = '$active'
              WHERE id='$id' ";
             //redirect with message

             $res3 = mysqli_query($conn,$sql3);

             if($res3==true){
                $_SESSION['update'] = "<div class='success'>Food Updated successfully</div>";
                header("location:".SITEURL.'admin/manage-food.php');
             }
             else{
                $_SESSION['update'] = "<div class='error'>Failed To Update Food</div>";
                header("location:".SITEURL.'admin/manage-food.php');
             }
         }

    ?>

    </div>
</div>

<?php  include('partials/footer.php') ?>