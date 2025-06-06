<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1> <br><br>

        <?php 
         $id = $_GET['id'];
         $sql = "SELECT * FROM tbl_admin WHERE id=$id";
         $res = mysqli_query($conn,$sql);
         if($res==TRUE){
            $count = mysqli_num_rows($res);
            if($count==1){
              // echo "Admin availabe";
              $row = mysqli_fetch_assoc($res);
              $full_name = $row['full_name'];
              $username = $row['username'];
            }
            else{
                //redirect to manage admin page
                header('loaction:'.SITEURL.'admin/manage-admin.php');
            }
         }

        ?>
        <form action="" method="post">
         
         <table class="tbl-30">
            <tr>
                <td>Full Name</td>
                <td>
                    <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                </td>
            </tr>

            <tr>
                <td>Username</td>
                <td>
                    <input type="text" name="username" value="<?php echo $username; ?>">
                </td>
            </tr>


            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                </td>
            </tr>
         </table>

        </form>

    </div>
</div>

<?php 
//check whether the submit button is clicked or not
if(isset($_POST['submit'])){
   // echo "Button clicked";
   $id = $_POST['id'];
   $full_name = $_POST['full_name'];
   $username = $_POST['username'];

   $sql = "UPDATE tbl_admin SET 
   full_name = '$full_name',
   username = '$username'
   WHERE id=$id ";

   $res = mysqli_query($conn,$sql);
   if($res==TRUE){
    //query executed , admin updated
    $_SESSION['update']= "Admin Updated Successfully";
    header('location:'.SITEURL.'admin/manage-admin.php');
   }
   else{
    // query is not executed, admin is not updated
    $_SESSION['update']= "Unable To Update Admin. Try Again Later.";
    header('location:'.SITEURL.'admin/manage-admin.php');
   }
}


?>

<?php include('partials/footer.php'); ?>

