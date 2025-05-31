<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">

        <h1>Add Food</h1>
        <br><br>

        <?php
          if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
          }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

         <table class="tbl-30">
            
         <tr>
            <td>Title:</td>
            <td>
                <input type="text" name="title" placeholder="Title Of the Food">
            </td>
        </tr>

        <tr>
            <td>Description:</td>
            <td>
                <textarea name="description" placeholder="Description of the Food" cols="25" rows="5"></textarea>
            </td>
        </tr>

        <tr>
            <td>Price:</td>
            <td>
                <input type="number" name="price">
            </td>
        </tr>

        <tr>
            <td>Image:</td>
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
                  $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                  $res = mysqli_query($conn,$sql);
                  $count = mysqli_num_rows($res);

                  if($count>0){
                    //categories available
                        while($row=mysqli_fetch_assoc($res)){
                             $id = $row['id'];
                             $title = $row['title'];

                             ?>
                               <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
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
            <td>Featured:</td>
            <td>
                <input type="radio" name="featured" value="Yes"> Yes
                <input type="radio" name="featured" value="No"> No
            </td>
        </tr>

        <tr>
            <td>Active:</td>
            <td>
                <input type="radio" name="active" value="Yes"> Yes
                <input type="radio" name="active" value="No"> No
            </td>
        </tr>

        <tr>
            <td colspan="2">
               <input type="submit" name="submit" value="Add Food" class="btn-secondary">
            </td>
        </tr>

         </table>

        </form>


        <?php
           //adding data into the database
           if(isset($_POST['submit'])){

            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            //if featured button is clicked or not
            if(isset($_POST['featured'])){
                $featured = $_POST['featured'];
            }
            else{
                $featured = "No";
            }
            //if active button is clicked or not
            if(isset($_POST['active'])){
                $active = $_POST['active'];
            }
            else{
                $active = "No";
            }

           //upload the image if selected
           //check whether the image is selected or not and only add image if the image is selected
           if(isset($_FILES['image']['name'])){

             //get the details of the image
              $image_name = $_FILES['image']['name'];
              //check whether the image is selected or not and upload image only if selected
              if($image_name != ""){
                //image is selected
                //rename the image
                //get the extension of the selected image
                $ext = end(explode('.',$image_name));
                //create new name for image
                $image_name = "Food-Name".rand(0000,9999).".".$ext; //new image name. e.g;Food-Name1000.jpg
                //upload the image
                //get the source and destination path of the image
                //source path
                $src = $_FILES['image']['tmp_name']; 
                //destination path
                $dest = "../images/food/".$image_name;
                //upload the image
                $upload = move_uploaded_file($src,$dest);
                //check whether image is uploaded or not
                if($upload==false){
                    //image is not uploaded
                    //redirect to add-food page with error message
                    $_SESSION['upload'] = "<div class='error'>Failed To Upload Image</div>";
                    header("location:".SITEURL.'admin/add-food.php');
                    //stop the process
                    die();
                }
              }
           }
           else{
            $image_name = ""; //setting default value as blank
           }

           //insert data into database
           //for numerical value we do not need to pass value in quotes but for string value we must pass it in quotes
           $sql2 = "INSERT INTO tbl_food SET
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = '$category',
            featured = '$featured',
            active = '$active'
           ";

           $res2 = mysqli_query($conn,$sql2);

           if($res2==true){
            //data added successfully
            $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
            header("location:".SITEURL.'admin/manage-food.php');
           }
           else{
            $_SESSION['add'] = "<div class='error'>Failed To Add Food. Try Again</div>";
            header("location:".SITEURL.'admin/manage-food.php');
           }

           }

        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>