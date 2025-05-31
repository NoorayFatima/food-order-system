<?php
include('partials/menu.php');
?>
<!--Main section start-->
<div class="main-content">
    <div class="wrapper">
        <h1>Dashboard</h1>
         <br><br>
        <?php 
          if(isset($_SESSION['login'])){
            echo $_SESSION['login'];
            unset($_SESSION['login']);
          }
        ?> <br><br>
        <div class="col-4 text-center">

            <?php   

             $sql = "SELECT * FROM tbl_category";
             $res = mysqli_query($conn, $sql);
             $count = mysqli_num_rows($res);
            ?>

            <h2><?php echo $count; ?></h2><br>
            Categories
        </div>

        <div class="col-4 text-center">

        <?php   

             $sql2 = "SELECT * FROM tbl_food";
             $res2 = mysqli_query($conn, $sql2);
             $count2 = mysqli_num_rows($res2);
            ?>

            <h2><?php echo $count2; ?></h2><br>
            Foods
        </div>

        <div class="col-4 text-center">
        <?php   

           $sql3 = "SELECT * FROM tbl_order";
           $res3 = mysqli_query($conn, $sql3);
           $count3 = mysqli_num_rows($res3);
?>
            <h2><?php echo $count3; ?> </h2><br>
             Total Orders
        </div>

        <div class="col-4 text-center">

        <?php   
           $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
           $res4 = mysqli_query($conn, $sql4);
           $row4 = mysqli_fetch_assoc($res4);
           $total_revenue = $row4['Total'];
        ?>
            <h2>$<?php echo $total_revenue; ?></h2><br>
             Revenue Generated
        </div>


        <div class="clearfix"></div>
    </div>
</div>
<!--Main section end-->

<?php
include('partials/footer.php');
?>