<!DOCTYPE html>
<html>
    <head>
        <title>Loading...PNWX</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="CSS/redirecting.css">
        
    </head>

    <body>
    <?php 
        include 'connection.php';
        
        session_start();
        $id = $_SESSION['user_id'];
        $sql = "UPDATE registered_User SET _login='Logged Out' WHERE id='$id'";

        $result = mysqli_query ($conn,$sql);
        //See if updated
        if($result == true)
        {
            echo "UPDATED LOGIN";
        } 
        else
        {
            echo "Failed to update". $conn->error;
        }
                    
        session_destroy();
    ?>

        <header>
            <a href="index.php"> <img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc."> </a>
        </header>

        <div class="MAINBODY">
            Logging Out <br>
            <div id="boxes">
                <div class="box _1">L</div>
                <div class="box _2">O</div>
                <div class="box _3">A</div>
                <div class="box _4">D</div>
                <div class="box _5">I</div>
                <div class="box _6">N</div>
                <div class="box _7">G</div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.2.0/anime.js"></script>
            <script src="redirecting.js"></script>
            <script>
                setTimeout(redirecting_logout, 5000);
            </script>
        </div>

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