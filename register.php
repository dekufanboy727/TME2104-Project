<!DOCTYPE html>
<html>
    <head>
        <title>Registration - PNWX</title>
        <meta charset="UTF-8">
        <script type="text/javascript" src="RegisterValidation.js"></script>
        <link rel="stylesheet" href="CSS/register.css">
    </head>

    <body>

        <?php 
            //Validation
            $welcome = "";
            $fname = $lname = ""; 
            $fnameE = $lnameE = "";
            $NameE1 = "*Please capitalize every first character for every WORD in NAME!";
            $NameE2 = "*Please make sure the other characters after the first character are lowercase for every WORD in NAME!";
            //Other declaration
            $email = $mobile = $pw = $cpw = $gender = $terms = "";
            $emailE = $mobileE = $pwE = $cpwE = $genderE = $termsE ="";
            $postcode = $add = "";
            $postcodeE = $addE = "";
            $cpw_match = $pw_strong = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                //Validate fname
                if(empty($_POST["fname"]))
                {
                    $fnameE = "*First Name is required!";
                }
                else
                {
                    $fname = test($_POST["fname"]);

                    //Check whether the first character is upper case?
                    if(!preg_match('~^\p{Lu}~u', $fname))
                    {
                        $fnameE = $NameE1;
                    }
                    else
                    {
                        for($x=1; $x < strlen($fname); $x++)
                        {
                            if($fname[$x] === " ") //next word
                            {
                                if( $fname[$x+1] !== strtoupper($fname[$x+1]))
                                {
                                    $fnameE = $NameE1;
                                }

                                for($x=$x+2; $x < strlen($fname); $x++)
                                {
                                    if($fname[$x] !== strtolower($fname[$x]))
                                    {
                                        $fnameE = $NameE2;
                                        break;
                                    }
                                }
                                break;
                            }
                            
                            if($fname[$x] !== strtolower($fname[$x]))
                            {
                                $fnameE = $NameE2;
                            }
                        }   
                    }
                }

                //Validate lname
                if(empty($_POST["lname"]))
                {
                    $lnameE = "*Last Name is required!";
                }
                else
                {
                    $lname = test($_POST["lname"]);

                    //Check whether the first character is upper case?
                    if(!preg_match('~^\p{Lu}~u', $lname))
                    {
                        $lnameE = $NameE1;
                    }
                    else
                    {
                        for($x=1; $x < strlen($lname); $x++)
                        {
                            if($lname[$x] === " ") //next word
                            {
                                if( $lname[$x+1] !== strtoupper($lname[$x+1]))
                                {
                                    $lnameE = $NameE1;
                                }

                                for($x=$x+2; $x < strlen($lname); $x++)
                                {
                                    if($lname[$x] !== strtolower($lname[$x]))
                                    {
                                        $lnameE = $NameE2;
                                        break;
                                    }
                                }
                                break;
                            }
                            
                            if($lname[$x] !== strtolower($lname[$x]))
                            {
                                $lnameE = $NameE2;
                            }
                        }
                    }
                }
                
                //Validate email
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

                //Validate mobile
                if(empty($_POST["mobile"]))
                {
                    $mobileE = "*Phone number is required!";
                }
                else
                {
                    $mobile = test($_POST["mobile"]);
                    //Check is it number
                    if(!is_numeric($mobile))
                    {
                        $mobileE = "*Invalid! Please use only numbers 0-9!";
                    }
                    else if(strlen($mobile) > 10 || strlen($mobile) <9) //Check length
                    {
                        $mobileE = "*Invalid phone number length!";
                    }
                }

                //Validate password
                if(empty($_POST["pw"]))
                {
                    $pwE = "*Password is required!";
                }
                else
                {
                    $pw = $_POST["pw"];
                    if(strlen($pw) <6 )
                    {
                        $pwE = "*Please use password with at least 6 digits!";
                    }
                    else if(!preg_match("#[0-9]+#",$pw))
                    {
                        $pwE = "*Must contain at least 1 number!";
                    }
                    else if (!preg_match("#[A-Z]+#",$pw))
                    {
                        $pwE = "*Must contain at least 1 uppercase letter!";
                    }
                    else if (!preg_match("#[a-z]+#",$pw))
                    {
                        $pwE = "*Must contain at least 1 lowercase letter!";
                    }
                    else if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/',$pw))
                    {
                        $pwE = "*Must contain at least 1 special character!";
                    }
                    else if (preg_match('/\s/',$pw)) //find whitespace
                    {
                        $pwE = "*Must not contain any whitespace!";
                    }
                    else
                    {
                        $pw_strong = "Strong Password!";
                    }
                }

                //Validate confirm password
                if(empty($_POST["cpw"]) && !empty($_POST["pw"]))
                {
                    $cpwE = "*Please confirm your password!";
                }
                else 
                {
                    $cpw = $_POST["cpw"];
                    if($cpw !== $_POST["pw"])
                    {
                        $cpwE = "*The password confirmation does not match!";
                    }
                    else if($cpw === $_POST["pw"] && !empty($_POST["pw"]))
                    {
                        $cpw_match = "Password Match!";
                    }
                }

                //Validate gender
                if(empty($_POST["gender"]))
                {
                    $genderE = "*Gender is required!";
                }
                else
                {
                    $gender = test($_POST["gender"]);
                }

                //Validate terms
                if(empty($_POST["terms"]))
                {
                    $termsE = "*Please accept the terms and conditions!";
                }
                else
                {
                    $terms = test($_POST["terms"]);
                }

                //Validate address
                if(empty($_POST["Address"]))
                {
                    $addE = "*Address is required!";
                }
                else
                {
                    $add = test($_POST["Address"]);
                }

                //Validate postcode
                if(empty($_POST["Postcode"]))
                {
                    $postcodeE = "*Postcode is required!";
                }
                else
                {
                    $postcode = test($_POST["Postcode"]);
                    if(!is_numeric($postcode))
                    {
                        $postcodeE = "*Invalid PostCode! Only numbers are Allowed!";
                    }
                    else if (strlen($postcode) > 5 || strlen($postcode) <5)
                    {
                        $postcodeE = "*Invalid PostCode length!";
                    }
                }

                
            } //End Validation

            function test($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            if($emailE == "" && $mobileE == "" && $pwE == "" && $cpwE == "" && $genderE == "" && $termsE =="" && $fnameE == "" && $lnameE == "" && $addE == "" && $postcodeE == ""
            &&  $fname != "" && $lname != "" && $email != "" && $mobile != "" && $pw != "" && $cpw != "" && $gender != "" && $terms != "" && $add != "" && $postcode != "")
            {
                $welcome = "Thank you for your Registration, " .$fname. " !";
            }

            //Database
            //Create Table Users
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "DB_PNWX";
            
            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            //Check connection
            if (!$conn) 
            {
                die("Connection failed: " . mysqli_connect_error());
            }
            else
            {
                echo "Connection successful!";
            }
            
            // create table
            $sql = "CREATE TABLE registered_User (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            email VARCHAR(50) NOT NULL,
            phone INT(10) NOT NULL,
            pwd VARCHAR(30) NOT NULL,
            gender CHAR(30) NOT NULL
            )";

            if ($conn->query($sql) === TRUE) {
                echo "Table MyGuests created successfully";
            } else {
                echo "Error creating table: " . $conn->error;
            }
            
            $conn->close();

        ?>

        <header>
            <a href="index.php"><img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc." ></a>
            <div class="header_signup">
                Sign Up
                <a href="login.php" >Already a Member? Login here!</a>
            </div>
        </header>
        
        <div class="column">
            <div class="column_A">
                <h1>Pacific Northwest X-Ray Inc.</h1>
                <p>An Oregon-based X-ray and medical equipment supply company
                provides you with portable radiographic, cabinetry, eyewear, gloves, aprons, and other related products</p> 
            </div>

            <div class="column_B">  
                    <h3 class="signup">Create your PNWX Account</h3>
                <form name="reg" method="post" onsubmit="return validateForm()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="row">
                        <div class="col1">
                            <img src="Pictures/name.png">
                            <label for="fname">First Name</label>
                        </div>
                        <div class="col2">
                            <input type="text" id="fname" name="fname" placeholder="Your first name.." value="<?php echo $fname;?>">
                            <span class="error"> <br> <?php echo $fnameE; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <img src="Pictures/name.png">
                            <label for="lname">Last Name</label>
                        </div>
                        <div class="col2">
                            <input type="text" id="lname" name="lname" placeholder="Your last name.." value="<?php echo $lname;?>">
                            <span class="error"> <br> <?php echo $lnameE; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <img src="Pictures/email.png">
                            <label for="Email">Email</label>
                        </div>
                        <div class="col2">
                            <input type="email" id="email" name="email" placeholder="Email.." value="<?php echo $email;?>" >
                            <span class="error"> <br> <?php echo $emailE; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <img src="Pictures/phone.png">
                            <label for="mobile">Mobile</label>
                        </div>
                        <div class="col2">
                            <select id="region" name="region">
                                <option value="+60">+60</option>
                                <option value="+1">+1</option>
                                <option value="+44">+44</option>
                            </select>
                            <input type="text" id="mobile" name="mobile" placeholder="Phone number.." value="<?php echo $mobile;?>" >
                            <span class="error"> <br> <?php echo $mobileE; ?> </span>
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
                            <span class="error"> <br> <?php echo $pwE; ?> </span>
                            <span class="correct"> <?php echo $pw_strong; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <img src="Pictures/pw.png">
                            <label for="cpw">Confirm Password</label>
                        </div>
                        <div class="col2">
                            <input type="password" id="cpw" name="cpw" placeholder="Confirm password.." value="<?php echo $cpw;?>" >
                            <span class="error"> <br> <?php echo $cpwE; ?> </span>
                            <span class="correct"> <?php echo $cpw_match; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <img src="Pictures/gender.png">
                            <label for="gender">Gender</label>
                        </div>
                        <div class="col2">
                            <div class="gender">
                                <input type="radio" id="male" name="gender" value="Male"
                                <?php if (isset($gender) && $gender=="Male") echo "checked";?> >
                                <label for="male">Male</label>
                                <input type="radio" id="female" name="gender" value="Female"
                                <?php if (isset($gender) && $gender=="Female") echo "checked";?> >
                                <label for="female">Female</label>
                                <span class="errorGender"><?php echo $genderE; ?> </span>
                            </div>
                        </div>
                    </div>
                    <br><br>

                    <div class="row">
                        <div class="col1">
                            <img src="Pictures/location.png">
                            <label for="address">Address</label>
                        </div>
                        <div class="col2">
                            <input type="text" id="address" name="Address" placeholder="Address.." value="<?php echo $add;?>" >
                            <span class="error"> <br> <?php echo $addE; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <img src="Pictures/postcode.png">
                            <label for="postcode">Postcode</label>
                        </div>
                        <div class="col2">
                            <input type="text" id="postcode" name="Postcode" placeholder="Postcode.." value="<?php echo $postcode;?>" >
                            <span class="error"> <br> <?php echo $postcodeE; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <img src="Pictures/location.png">
                            <label for="state">State</label>
                        </div>
                        <div class="col2">
                            <select id="state" name="state">
                                <option value="Johor">Johor</option>
                                <option value="Kedah">Kedah</option>
                                <option value="Kelantan">Kelantan</option>
                                <option value="Melaka">Melaka</option>
                                <option value="Negeri Sembilan">Negeri Sembilan</option>
                                <option value="Pahang">Pahang</option>
                                <option value="Penang">Penang</option>
                                <option value="Perak">Perak</option>
                                <option value="Perlis">Perlis</option>
                                <option value="Sabah">Sabah</option>
                                <option value="Sarawak">Sarawak</option>
                                <option value="Selangor">Selangor</option>
                                <option value="Terengganu">Terengganu</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    
                    <br>

                    <div class="Terms_Con">
                        <input type="checkbox" id="terms" name="terms" value="Accepted"
                        <?php if (isset($terms) && $terms == "Accepted") echo "checked";?> >
                        <label for="terms">I accept the above Terms and Conditions</label>
                        <div class="errorTerms"> <br> <?php echo $termsE; ?> </div>
                    </div> 

                    <div class="button">
                        <input type="submit" name = "submit" value="Register" >
                        <input type="reset" name = "reset" value="Clear" > 
                    </div>
                    <div class="welcome"> <br> <?php echo $welcome; ?></div>
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