<?php session_start(); ?>

<!DOCTYPE html> 
<html>
    <head>
        <title>Pnwx</title>
        <link rel="icon" href="Pictures/icon.png">
        <link rel="shortcut icon" href="Pictures/icon.png">
        <link rel="stylesheet" href="CSS/stylesheet.css">
    </head>
    <body>
        <?php
            include 'adminconfig.php';

            $id = $email = $name ="";

            $id = $_SESSION['admin_id'];
            $email = $_SESSION['email'];

            $sql = "SELECT username FROM admins WHERE ID='$id'"; //Select the user id
            $isFound = mysqli_query($conn,$sql); //Check is it exists

            if (mysqli_num_rows($isFound) > 0){
                $result = mysqli_fetch_assoc($isFound);
                $name = $result['username'];
            }else{
                echo "no results";
            }
            
        ?>
        <header class="HeaderHeader" id="Push_header">
            <div id = side_logo>
              <ul>
              <li><a id="expand_sidenav"><span onclick="sidebar()">&#9776;</span></a></li>
              <li><img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc."></li>
              <ul>
            </div>

            <div class="navigation">
                <ul >
                
                <!--<li><a href="index.php" target="_blank">Home</a></li>
                <li><a href="http://www.pnwx.com/Equipment/" target="_blank">Equipment</a></li>
                <li><a href="http://www.pnwx.com/Accessories/" target="_blank">Accessories</a></li>
                <li><a href="http://www.pnwx.com/Supplies" target="_blank">Supplies</a></li>
                <li><a href="http://www.pnwx.com/Parts/" target="_blank">Parts</a></li>
                
                <div class="search">
                <li><form action="http://www.pnwx.com/Search/" method="post">
                <input type="text" name="SearchWords" size="30" maxlength="70" value="" />
                <input class="SearchButton" type="submit" value="Search" />
                </form></li>
                </div>
                
                </ul>-->
            </div>

            <div class="login_register">
                <ul> 
                    <li><a href="adminlogout.php">log out</a></li>
                    <li><a href=""><?php echo $name ?></a></li>
                    <li><img class="image_login_register" src="Pictures/login_register_icon.png" alt="Login and register icon"></a>
                </ul>
            </div>    
        </header>
        <main id="Push_main">
            placeholder
        </main>
        <footer class="FooterFooter" id="Push_footer">
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