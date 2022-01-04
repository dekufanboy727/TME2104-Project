<?php session_start() ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard - PNWX</title>
        <meta charset="UTF-8">
        <link rel="icon" href="Pictures/icon.png">
        <link rel="shortcut icon" href="Pictures/icon.png">
        <link rel="stylesheet" href="CSS/dashboard.css">
    </head>

    <body>
        <?php 
            include 'connection.php';
            $userid = $_SESSION['user_id'];
        ?>
        <header>
            <a href="index.php"> <img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc."> </a>
            <span class = "menu">
                <a href="myProfile.php"> My Profile </a>
                <a id="active" href="dashboard.php"> Dashboard </a>
                <a href="index.php"> Catalog </a>
                <a class = "cart_position" href="cart.php"> <img id="cart" src="Pictures/cart.png" alt="Cart"> </a>
            </span>
            <span class= "logout"> 
                <a id = "logout" href="logout.php">Logout</a>
                <a>|</a>
                <a href="myProfile.php"  >My Profile</a>
                <img class="image_login_register" src="Pictures/login_register_icon.png" alt="Login and register icon">
            </span>
        </header>

        <main>
            <!--INSERT CHART HERE LATER-->
            <?php
                $sql = "SELECT id, _date, _time, grand_total FROM transactions WHERE userid = '$userid'";
                $isFound = mysqli_query($conn,$sql); 

                if(mysqli_num_rows($isFound) > 0)
                {
                    while($row = mysqli_fetch_assoc($isFound))
                    {
                        //The list is a button that generate the receipt
                        echo '<a href="receipt.php?receipt='.$row['id'].'&check=false" target="_blank">';
                        echo "Transaction ID: " .$row['id'].
                             " Date: ".$row['_date']." ".$row['_time']."... Order Total: ".$row['grand_total'].
                             '</br></a>';
                    }
                }
            ?>
            

        </main>

        

        <footer class="FooterFooter">
            <div class="FFooterUpperPortion">
                <div class="FFooterIcon">
                    <img src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc.">
                </div>
                <div class="FFooterBlocks">
                    <h3><b>Contact Us</b></h3>
                    <ul>
                        <li>Tel: 503-667-3000</li>
                        <br>
                        <li>Toll-Free: 800-827-9729</li>
                        <br>
                        <li>Fax: 503-666-8855</li>
                    </ul>
                </div>
                <div class="FFooterBlocks">
                    <h3><b>Reach Us</b></h3>
                    <ul>
                        <li>P.O. Box 625,</li>
                        <br>
                        <li>Gresham, OR</li>
                        <br>
                        <li>97030 U.S.A.</li>
                    </ul>
                </div>
                <div class="FFooterBlocks">
                    <h3><b>Opening Hours</b></h3>
                    <ul>
                        <li>8am - 5pm</li>
                        <br>
                        <li>Monday-Friday</li>
                        <br>
                        <li>(PST/PT)</li>
                    </ul>
                </div>
            </div>

            <br>
            <br>
            <hr id="FooterLine"/>
            <div class="FFooterLowerPortion" >
              <sub class="Disclaimer">This web site is our catalog! <u>No printed catalog is available.</u></sub>
              <br>
              <sub class="Disclaimer">©1997-2021 Pacific Northwest X-Ray Inc. - Sales & Marketing Division - All Rights Reserved</sub>
            </div>
        </footer>  
    </body>

</html>