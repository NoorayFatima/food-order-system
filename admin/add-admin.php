<?php
include('partials/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1><br><br>

        <?php
         if(isset($_SESSION['add'])){
            echo $_SESSION['add']; //displaying session message
            unset($_SESSION['add']); //removing session message
         }
        ?>

        <form action="" method="post">
         
         <table class="tbl-30">
            <tr>
                <td>Full Name</td>
                <td>
                    <input type="text" name="full_name" placeholder="Enter Your Name">
                </td>
            </tr>

            <tr>
                <td>Username</td>
                <td>
                    <input type="text" name="username" placeholder="Enter Your Username">
                </td>
            </tr>

            <tr>
                <td>Password</td>
                <td>
                    <input type="password" name="password" placeholder="Enter Your Password">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                  <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                </td>
            </tr>
         </table>

        </form>

    </div>
</div>

<?php
include('partials/footer.php');
?>

<?php
//process the value from form and submit it in database

//checking whether the submit button is clicked or not

if(isset($_POST['submit'])){

    //getting data from form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); //password encrypted with md5 function

    //saving data in the database
    $sql = "INSERT INTO tbl_admin SET 
    full_name = '$full_name',
    username = '$username',
    password = '$password'
    ";

    //executing the sql query
    $res = mysqli_query($conn, $sql) or die(mysqli_error());

    if($res==TRUE){
        //create a session variable to display message
        $_SESSION['add'] = "Admin Added Successfully"; 
        //redirect page to manage admin page
        header("location:" . SITEURL . 'admin/manage-admin.php');
    }
    else{
         //create a session variable to display message
         $_SESSION['add'] = "Failed To Add Admin"; 
         //redirect page to manage admin page
         header("location:" . SITEURL . 'admin/add-admin.php');
    }
}


?>