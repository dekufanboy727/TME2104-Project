<?php session_start(); ob_start();?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin Login - PNWX</title>
        <meta charset="UTF-8">
        <script type="text/javascript" src="LoginValidation.js"></script>
        <link rel="stylesheet" href="CSS/login.css">
    </head>

    <body>

        <?php
            //Declarations
            $email = $pw = "";
            $emailE = $pwE ="";
            $error= "";


            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                //Validate Email
                if(empty($_POST["email"]))
                {
                    $emailE = "*Email is required!";
                }
                else 
                {
                    $email = test($_POST["email"]);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
                    {
                        $emailE = "*Invalid email format!";
                    }
                    
                }

                //Validate Password
                if(empty($_POST["pw"]))
                {
                    $pwE = "*Password is required!";
                }
                else
                {
                    $pw = $_POST["pw"];
                }

            }

            function test($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            //Connection
            include 'adminconfig.php';
            
            //Dummy Table Setup
            $sql = "CREATE TABLE admins (
                    ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    username varchar(30) NOT NULL,
                    pass varchar(30) NOT NULL,
                    fullname varchar(30) NOT NULL,
                    email varchar(30) NOT NULL,
                    _login tinyint(1) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

            if (mysqli_query($conn, $sql) === TRUE){
                echo "Table added";

                $sql = "ALTER TABLE admins AUTO_INCREMENT = 1000";
                if (mysqli_query($conn, $sql) === TRUE){
                    echo "Alter successful";
                    $sql = "INSERT INTO admins (username, pass, fullname, email, _login) 
                        VALUES  ('admin01', 'PNWX', 'Jared RightBottom', 'admin01@pnwx.com', 0),
                                ('admin02', 'PNWX', 'Garry HIghlander', 'admin02@pnwx.com', 0);";

                    if (mysqli_query($conn, $sql) == TRUE){
                        echo "Values added successful";
                    }else{
                        echo "Error: " . mysqli_error($conn);
                    }

                }else{
                    echo "Error: " . mysqli_error($conn);
                }
            }else{
                echo "Error: " . mysqli_error($conn);
            }
            
            //No error in input
            if (!empty($_POST["email"])&& !empty($_POST["pw"])) //Check whether the user exists 
            {
                $sql = "SELECT ID FROM admins WHERE email='$email' AND pass='$pw'"; //Select the user id
                $isFound = mysqli_query($conn,$sql); //Check is it exists
                
                //Found the user
                if(mysqli_num_rows($isFound) == 1) 
                {
                    //fetch the id
                    $result = mysqli_fetch_assoc($isFound);
                    $id = $result["ID"];

                    //Update the login status in table
                    $sql = "UPDATE admins SET _login='1' WHERE ID='$id'";

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

                    //Set session variables
                    $_SESSION['admin_email'] = $email;
                    $_SESSION['admin_login'] = "Logged In";
                    $_SESSION['admin_id'] = $id;

                    //Close Connection
                    mysqli_close($conn);
                    
                    //Redirecting user
                    header("Location: adminDashboard.php");
                    ob_end_flush();
                }   
                else
                {
                    $error = "Login Failed! Please try again!";
                }
            }
        ?>

        <header>
            <a href="index.php"> <img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc."> </a>
            <div class="header_login">
                Admin Log In
                <a href="index.php" action="<?php ?>">Return Here!</a>
            </div>
        </header>
        
        <div class="column">
            <div class="column_A">
                <h1>Pacific Northwest X-Ray Inc.</h1>
                <p>An Oregon-based X-ray and medical equipment supply company
                provides you with portable radiographic, cabinetry, eyewear, gloves, aprons, and other related products</p> 
            </div>

            <div class="column_B">  
                <h3 class="login">Log In</h3>
                <form name="login" method="post" onsubmit="return validateForm()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="row">
                        <div class="col1">
                            <img src="Pictures/email.png">
                            <label for="Email">Email</label>
                        </div>
                        <div class="col2">
                            <input type="email" id="email" name="email" placeholder="Email.." value="<?php echo $email;?>" >
                            <span class="error"> <?php echo $emailE; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <img src="Pictures/pw.png">
                            <label for="pw">Password</label>
                        </div>
                        <div class="col2">
                            <input type="password" id="pw" name="pw" placeholder="Password.." value="<?php echo $pw;?>" >
                            <span class="error"> <?php echo $pwE; ?> </span>
                        </div>
                    </div>

                    <div class="button">
                        <input type="submit" name = "submit" value="Login" > 
                    </div>

                    <div class = "login_error">
                    <span class = "login_fail"><?php echo $error; ?></span>
                    </div>

                </form>
            </div>
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