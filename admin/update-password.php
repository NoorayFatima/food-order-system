<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1><br><br>

        <?php
           if(isset($_GET['id'])){
            $id = $_GET['id'];
           }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">

               <tr>
                <td>Old Password: </td>
                <td>
                    <input type="password" name="current_password" placeholder="Enter Current Password">
                </td>
               </tr>

               <tr>
                <td>New Password: </td>
                <td>
                    <input type="password" name="new_password" placeholder="Enter New Password">
                </td>
               </tr>

               <tr>
                <td>Confirm Password: </td>
                <td>
                    <input type="password" name="confirm_password" placeholder="Confirm Password">
                </td>
               </tr>

               <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                   <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                </td>
               </tr>
            </table>
        </form>
    </div>
</div>

<?php
   if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
    $res = mysqli_query($conn,$sql);
    if($res==TRUE){
       $count = mysqli_num_rows($res);
       if($count==1){
         //check whether new passowrd matches the confirm password value
         if($new_password==$confirm_password){
            //upadte the password
            $sql2 = "UPDATE tbl_admin SET
            password = '$new_password'
            WHERE id='$id'
            ";

            $res2 = mysqli_query($conn,$sql2);

            if($res2==TRUE){
                $_SESSION['change-pwd'] = "Password Changed Successfully";
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
            else{
                $_SESSION['change-pwd'] = "Failed To Change Password. Try Again.";
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
         }
         else{
            $_SESSION['pwd-not-match'] = "Password Does Not Match";
            header('location:'.SITEURL.'admin/manage-admin.php');
         }
       }
       else{
        $_SESSION['user-not-found'] = "User Not Found";
        header('location:'.SITEURL.'admin/manage-admin.php');
       }
    }
   }
?>

<?php include('partials/footer.php');?>