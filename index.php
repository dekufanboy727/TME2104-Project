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
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "DB_PNWX";
        
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
    
        // Create database
        $sql = "CREATE DATABASE DB_PNWX";
        if (mysqli_query($conn, $sql)) 
        {
          echo "Database created successfully";
        } else 
        {
          echo "Error creating database: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    ?> 

        <header class="HeaderHeader">
            <div class="login_register">
                <ul>
                  <li><a href="register.php">Sign Up</a></li>
                  <li><a>|</a></li>
                  <li><a href="login.php" >Login</a></li>
                  <li><img class="image_login_register" src="Pictures/login_register_icon.png" alt="Login and register icon""></li>
                </ul>
            </div>

            <img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc.">
            
            <div class="navigation">
                <ul >
                
                <li><a href="index.html" target="_blank">Home</a></li>
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
                
                </ul>
            </div>

            <div id="mySidenav" class="sidenav">
              <a href="javascript:void(0)" class="closebtn" onclick="closesidebar()">&times;</a>
              <a href="#merchantBoard">Merchant Board</a>
              <a href="#silverRecovery">Silver Recovery Systems</a>
              <a href="#veterinary">Veterinary</a>
              <a href="#xray">X-Ray Test Meters</a>
            </div>
            <br>
            <span style="font-size:30px;cursor:pointer" onclick="sidebar()">&#9776; Category</span>

            

        </header>
        <br>
        <main>
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
			      <h2>Category</h2>
			    </div>
              <div class="row">
              <h3 id ="merchantBoard"> Merchant Board </h3>
                <div class="column">
                  <div class="card">
                    <img src="Pictures/merchantBoard1.jpg" alt="merchantBoard1">
                    <div class="grid-container">
                      <h2> 	PNWX Merchant Board for DR Panels</h2><br>
                      <p class="title">$1,968.00</p>
                      <p><a href="http://www.pnwx.com/Accessories/PatAsst/MerchantBoards/"><button class="button">LEARN MORE</button></a></p>
                    </div>
                  </div>
                </div>
              
                <div class="column">
                  <div class="card">
                    <img src="Pictures/merchantBoard2.jpg" alt="merchantBoard2">
                    <div class="grid-grid-container">
                      <h2> 	PNWX Light Duty Merchant Board for Film Cassettes</h2>
                      <p class="title">$770.00</p>
                      <p><a href="http://www.pnwx.com/Accessories/PatAsst/MerchantBoards/"><button class="button">LEARN MORE</button></a></p>
                    </div>
                  </div>
                </div>
                

              </div>
              
              <div class="row">
              <h3 id ="silverRecovery"> Silver Recovery Systems</h3>
                <div class="column">
                  <div class="card">
                    <img src="Pictures/Equipment1.jpg" alt="X-Ray Merchant board">
                    <div class="grid-container">
                      <h2>Steel Wool Recovery Canisters and Accessories</h2>
                      <p class="title">$215.00</p>
                      <p><a href="http://www.pnwx.com/Equipment/DarkEquip/Rotex/SteelWoolCanisters/"><button class="button">LEARN MORE</button></a></p>
                    </div>
                  </div>
                </div>
              
                <div class="column">
                  <div class="card">
                    <img src="Pictures/Equipment2.jpg" alt="Surgical Radiation Reducing Gloves">
                    <div class="grid-container">
                      <h2>	Rotex Standard Ultra Series Silver Recovery Systems</h2>
                      <p class="title">$2,412.31</p>
                      <p><a href="http://www.pnwx.com/Equipment/DarkEquip/Rotex/Ultra/"><button class="button">LEARN MORE</button></a></p>
                    </div>
                  </div>
                </div>
                
              </div>

              <div class="row">
              <h3 id ="veterinary"> Veterinary</h3>
                <div class="column">
                  <div class="card">
                    <img src="Pictures/pet1.jpg" alt="Veterinary Immobilizers">
                    <div class="grid-container">
                      <h2>	Techno-Aide's Veterinary Immobilizers</h2><br>
                      <p class="title">$169.80</p>
                      <p><a href="https://www2.pnwx.com/Accessories/PosAides/Pet-Sitioner/"><button class="button">LEARN MORE</button></a></p>
                    </div>
                  </div>
                </div>
              
                <div class="column">
                  <div class="card">
                    <img src="Pictures/pet2.jpg" alt="Veterinary Immobilizers">
                    <div class="grid-container">
                      <h2>Techno-Aide Veterinary Positioner</h2><br>
                      <p class="title">$32.50</p>
                      <p><a href="https://www2.pnwx.com/Accessories/PosAides/Pet-Sitioner/"><button class="button">LEARN MORE</button></a></p>
                    </div>
                  </div>
                </div>
                
              </div>
 
              <div class="row">
              <h3 id ="xray">X-Ray Test Meters</h3>
                <div class="column">
                  <div class="card">
                    <img src="Pictures/xray1.jpg" alt="X-Ray Test Meters">
                    <div class="grid-container">
                      <h2>	ECC Series 820 kVp, mA, Time/mAs Meters</h2>
                      <p class="title">$2,279.00</p>
                      <p><a href="http://www.pnwx.com/Equipment/Test/X-Ray/ECC/820/"><button class="button">LEARN MORE</button></a></p>
                    </div>
                  </div>
                </div>
              
                <div class="column">
                  <div class="card">
                    <img src="Pictures/xray2.jpg" alt="X-Ray Test Meters">
                    <div class="grid-container">
                      <h2>Series 815 kVp Meters</h2><br>
                      <p class="title">$1,700.00</p>
                      <p><a href="http://www.pnwx.com/Equipment/Test/X-Ray/ECC/815/"><button class="button">LEARN MORE</button></a></p>
                    </div>
                  </div>
                </div>
                
              </div>

            </section>
        </main>
        <br>


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