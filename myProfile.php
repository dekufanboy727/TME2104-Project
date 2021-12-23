<?php session_start() ?>

<!DOCTYPE html>
<html>
    <head>
        <title>My Profile - PNWX</title>
        <meta charset="UTF-8">
        <script type="text/javascript" src="LoginValidation.js"></script>
        <link rel="stylesheet" href="CSS/myProfile.css">
    </head>

    <body>
        <header>
            <a href="index.php"> <img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc."> </a>
            <span class = "menu">
                <a id="active" href="myProfile.php"> My Profile </a>
                <a href="index.php"> Catalog </a>
                <a href="dashboard.php"> Dashboard </a>
                <a class = "cart_position" href="cart.php"> <img id="cart" src="Pictures/cart.png" alt="Cart"> </a>
            </span>
            <span class= "logout"> 
                <a id = "logout" href="logout.php">Logout</a>
                <a>|</a>
                <a href="myProfile.php"  >My Profile</a>
                <img class="image_login_register" src="Pictures/login_register_icon.png" alt="Login and register icon">
            </span>
        </header>

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