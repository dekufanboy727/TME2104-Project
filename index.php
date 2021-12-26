<!--!!!-->
<?php session_start(); ?>

<!DOCTYPE html>
<!--Procurred by Chong Yun Sin 74455, Than Ye Hong 76990, Tang Jhen Nee 77363, Liew Yu Heng 77313-->

<html lang="en">
    <head>
        <title>Pnwx</title>
        <link rel="icon" href="Pictures/icon.png">
        <link rel="shortcut icon" href="Pictures/icon.png">
        <link rel="stylesheet" href="CSS/stylesheet.css">
    </head>
    <body>

    <?php

        // Create database & connection
        include 'connection.php';
        
        // ADDDED!!!!!
        //Declarations
        $signup = $login = $logout = $myprofile = "";
        //Check if session login is defined
        if (isset($_SESSION['login'])) 
        {
            //If it is defined, then we check is it Logged in 
            if($_SESSION['login'] === "Logged In")
            {
                $logout = "Logout";
                $myprofile = "My Profile     |";
            }
            else //Or logged out
            {
                $signup = "Sign Up";
                $login = "Login     |";
            }
        }
        else //session login not set yet
        {
            $signup = "Sign Up";
            $login = "Login     |";
        }
        //product

        //Create Table Products
        $sql = "CREATE TABLE IF NOT EXISTS cat1 (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        productcategory VARCHAR(255) NOT NULL,
        productname VARCHAR(255) NOT NULL,
        productdetail VARCHAR(255) NOT NULL,
        price int(11) NOT NULL,
        productpic BLOB (255) NOT NULL
        )";

        if (mysqli_query($conn, $sql) === TRUE) {
          echo "Table cat1 created successfully or Table exists <br\>";

          $sql = "SELECT id FROM cat1";
          $query = mysqli_query($conn, $sql);
          if ( mysqli_num_rows($query) == 0){
            //setup array for dummy products
            $productcategory = array("Merchant Board ", "Merchant Board ", "Silver Recovery Systems ", "Silver Recovery Systems ", "Veterinary ", "Veterinary ", 
            "X Ray Test Meters ", "X Ray Test Meters ");

            $productname = array("Pacific Northway X-Ray Merchant Board for DR Panels ", "PNWX Light Duty Merchant Board for Film Cassettes", 
            "Steel Wool Recovery Canisters and Accessories", "Rotex Standard Ultra Series Silver Recovery Systems", "Techno Aide Veterinary Immobilizers", 
            "Techno Aide Veterinary Positioner", "ECC Series 820 kVp Meters", "Series 815 kVp Meters");

            $productdetail = array("Model: 1104-C3a, box style merchant board with arms to accommodate DR Panels up to 1-1/4 thick.", 
            "Model: 1104, constructed of solid oak, adjustable tabletops ,compatible with CR.", 
            "Model: C4 Steel Wool Canister; Size: 3-1/2 gallon; Steel Wool Type: Coarse", "Model: Ultra 4; Max Recovery Rate: 0.5oz/hr Tank Capacity: 2.75 gal; Electrical Requirements: 115VAC/60Hz", 
            "Type:  Immobilizers; Model: VIT X; Size: X Large; Dimension: 36 x 14 x 9 feet high.",
            "Type:  Positioner; Model: YFCA Positioner; Size: Small; Dimensions: 7 x 12.5 x 3.", "Model: 820; X-Ray kVp Meter/Exposure; Time Meter/mA Meter/mAs; kVp Range: 45 to 125.",
            "Model: 815L;Lower kV Range Version of the 815 Meter(40 to 120kVp);For dental applications.");

            $price = array("1968", "770", "215", "2412", "170", "33", "2279", "1700");

            $productpic = array("itempic/item1.jpg", "itempic/item2.jpg", "itempic/item3.jpg", "itempic/item4.jpg", "itempic/item5.jpg", "itempic/item6.jpg", "itempic/item7.jpg", 
            "itempic/item8.jpg");
            
            $index = 0;
            foreach($productcategory as $value){
              $sql = "INSERT INTO cat1(productcategory, productname, productdetail, price, productpic) 
              VALUES ('$value','$productname[$index]', '$productdetail[$index]', '$price[$index]', '$productpic[$index]')";
              if (mysqli_query($conn, $sql) === TRUE) {
                echo "New record created successfully";
              } else {
                echo "Error: " . $sql  . mysqli_error($conn);
              }
              $index++;
            }
          }else{
            echo "Error: " . $sql . "There's already products in the table";
          }
        } else {
            echo "Error creating table: " . mysqli_error($conn);
        }
        mysqli_close($conn);
    ?>
    <!----product end-->
    
        <header class="HeaderHeader" id="Push_header">
            <div id = side_logo>
              <ul>
              <li><a id="expand_sidenav"><span onclick="sidebar()">&#9776;</span></a></li>
              <li><img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc."></li>
              <ul>
            </div>

            <div class="login_register">
                <ul>
                  <li><a href="register.php"><?php echo $signup?></a></li>
                  <li><a href="login.php" ><?php echo $login?></a></li>
                  <li><a href="logout.php"  ><?php echo $logout?></a></li>
                  <li><a href="myProfile.php"  ><?php echo $myprofile?></a></li>
                  <li><img class="image_login_register" src="Pictures/login_register_icon.png" alt="Login and register icon"></a>
                </ul>
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
        </header>
        <div id="mySidenav" class="sidenav">
              <a href="javascript:void(0)" class="closebtn" onclick="closesidebar()">&times;</a>
              <br>
              <a href="#merchantBoard" >Merchant Board</a>
              <br>
              <a href="#silverRecovery" >Silver Recovery Systems</a>
              <br>
              <a href="#veterinary">Veterinary</a>
              <br>
              <a href="#xray" ">X-Ray Test Meters</a>
        </div>

        <main id="Push_main">
        <div class="slidebanner-container">
            <div class="mySlides">
              <img src="Pictures/pnwxHomePage.png" style="width:100%">
            </div>
            
            <div class="mySlides">
              <div class="row">
                <div class="column1">
                        <h1>Silver Recovery Systems.</h1>
                    <img src="Pictures/Equipment1.jpg" alt="Rotex Silver Recovery Equipment" title="Rotex Silver Recovery Equipment" width="200" height="200" >
                </div>
            
                <div class="column2">
                    <br><br><br><br>
                    <h2>Silver Recovery Systems.
                        How These Systems Work...</h2>
                    <p>the process by which pure metallic silver can be recycled from old x-ray films. The commonest process now used is called "wash". The film is shredded and placed in large baths of a chemical reagent e.g. cyanide solution. The cyanide leaches the silver from the film. The silver is then removed from the solution by electrolysis. </p>
                        <p><a href="page2.html"><button class="button">LEARN MORE</button></a></p>
                </div>
              </div>
            </div>
            
            <a class="prev" onclick="nextslide(-1)">&#10094;</a>
            <a class="next" onclick="nextslide(1)">&#10095;</a>
            
            <div class = "dotbullet">
                <span class="dot" onclick="currentSlide(1)"></span> 
                <span class="dot" onclick="currentSlide(2)"></span> 
            </div>
            <script src="slides.js"></script>
            </div>
            <br>
            <br>

            <section class="Showcase">
              <div class="page1-title">
                <h2>- Category -</h2>
              </div>

              <div class="row">

                <h3> Merchant Board </h3>
                <?php 
                      if($productcategory = "Merchant Board") {
                        include 'displayitem.php';} else {
                          echo "Not Merchant Board";
                        }
                ?>    
              </div>

              <div class="row">
                <h3> Silver Recovery Systems </h3>
                <?php 
                      if($productcategory === "Silver Recovery Systems") {
                        include 'displayitem.php';} else {
                          echo "Not silver recovery system";
                        }
                ?>              
              </div>

              <div class="row">
                <h3> Veterinary  </h3>
                <?php 
                      if($productcategory === "Veterinary") {
                        include 'displayitem.php';} else {
                          echo "Not Veterinary";
                        }
                ?>              
              </div>

              <div class="row">
                <h3> X Ray Test Meters  </h3>
                <?php 
                      if($productcategory === "X Ray Test Meters") {
                        include 'displayitem.php';} else {
                          echo "Not X Ray Test Meters";
                        }
                ?>              
              </div>
            </section>

        
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