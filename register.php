<!DOCTYPE html>
<html>
    <head>
        <title>Registration - PNWX</title>
        <meta charset="UTF-8">
        <link rel="icon" href="Pictures/icon.png">
        <link rel="shortcut icon" href="Pictures/icon.png">
        <script type="text/javascript" src="RegisterValidation.js"></script>
        <link rel="stylesheet" href="CSS/register.css">
    </head>

    <body>

        <?php 
            //Validation
            $welcome = $login = "";
            $fname = $lname = ""; 
            $fnameE = $lnameE = "";
            $NameE1 = "*Please capitalise FIRST CHARACTER of your Name!";
            $NameE2 = "*Please make sure your Name are all in lowercase except the FIRST character!";
            //Other declaration
            $email = $mobile = $pw = $cpw = $gender = $terms = "";
            $emailE = $mobileE = $pwE = $cpwE = $genderE = $termsE ="";
            $postcode = $add = $city ="";
            $postcodeE = $addE = $cityE ="";
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
                                $x++;
                                if( $fname[$x] !== strtoupper($fname[$x]))
                                {
                                    $fnameE = $NameE1;
                                }
                            }
                            else if($fname[$x] !== strtolower($fname[$x]))
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
                                $x++;
                                if( $lname[$x] !== strtoupper($lname[$x]))
                                {
                                    $lnameE = $NameE1;
                                }
                            }
                            else if($lname[$x] !== strtolower($lname[$x]))
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

                //Validate city
                if(empty($_POST["city"]))
                {
                    $cityE = "*City is required!";
                }
                else
                {
                    $city = test($_POST["city"]);
                }

                $state = test($_POST["state"]);
                $region = test($_POST["region"]);

                
            } //End Validation

            function test($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            //Connection
            include 'connection.php';

            //Create Table Users
            $sql = "CREATE TABLE registered_User (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                firstname VARCHAR(30) NOT NULL,
                lastname VARCHAR(30) NOT NULL,
                email VARCHAR(50) NOT NULL,
                region int(5) NOT NULL,
                phone INT(10) NOT NULL,
                pwd VARCHAR(30) NOT NULL,
                gender CHAR(30) NOT NULL,
                _state CHAR(30) NOT NULL,
                postcode INT(10) NOT NULL,
                _address VARCHAR(255) NOT NULL,
                city CHAR(30) NOT NULL,
                _login CHAR(30) NOT NULL
                )";

            //Inserting Preset Users For Functions to Work
            if ($conn->query($sql) === TRUE) {
                echo "Table MyGuests created successfully";

                $sql = " INSERT INTO registered_user (id, firstname, lastname, email, region, phone, pwd, gender, _state, postcode, _address, city, _login) VALUES
                (1, 'Jerry', 'Mander', 'JM1@gmail.com', 60, 1910001000, 'Cc123@', 'Male', 'Selangor', 53110, '3, Jalan Terringgi 3/5 C,', 'Kuala Lumpur', 'Logged Out'),
                (2, 'Holly', 'Maddson', 'HM2@gmail.com', 60, 1110001000, 'Aa123@', 'Female', 'Penang', 37701, '2, Jalan Ferringgi 5/7B', 'GeorgeTown', 'Logged Out'),
                (3, 'Barry', 'Halselhoff', 'BH3@gmail.com', 60, 1320001000, 'Bb123@', 'Male', 'Selangor', 48000, '4, Jalan University,', 'Petaling Jaya', 'Logged Out'),
                (4, 'Darrel', 'Wong', 'DW4@gmail.com', 60, 1420001000, 'Bb123@', 'Male', 'Sarawak', 93000, '6, Jalan Rodway,', 'Kuching', 'Logged Out'),
                (5, 'Siti', 'Ahmad', 'MA5@gmail.com', 60, 1530002000, 'Bb123@', 'Female', 'Pahang', 27600, '7, Jalan Lipis,', 'Raub', 'Logged Out');";

                $result = mysqli_query($conn, $sql);
                if ($result === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " .  mysqli_error($conn);
                }
            } else {
                echo "Error creating table: " . $conn->error;
            }
            
            //Create CART
            $sql = "CREATE TABLE ShoppingCart (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                User_id INT(10) UNSIGNED NOT NULL,
                Grand_total FLOAT(20, 2) NOT NULL,
                FOREIGN KEY (User_id) REFERENCES registered_User(id)
                ON DELETE CASCADE
                ON UPDATE CASCADE
                )";

                $result = mysqli_query($conn, $sql);
                if ($result === TRUE) 
                {
                    echo "Table cart created successfully or Table exists".'<br>';
                }
                else
                {
                    echo "Error creating table cart: " . mysqli_error($conn);
                }
            
            //Create Transactions TABLE
            $sql = "CREATE TABLE transactions (
                id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                userid int(15) NOT NULL,
                _date date NOT NULL,
                _time time NOT NULL,
                shipping_fee double(15,2) NOT NULL,
                merchandise_total double(15,2) NOT NULL,
                grand_total double(15,2) NOT NULL,
                is_preset tinyint(1) NOT NULL DEFAULT 0
              )";

            $result = mysqli_query($conn, $sql);
            if ($result == TRUE){
                echo "Table Transactions Created Successfully".'<br>';

                //Insert Dummy Transactions for testing purpose 
                $sql = "INSERT INTO transactions (id, userid, _date, _time, shipping_fee, merchandise_total, grand_total, is_preset) VALUES
                (1, 1, '2021-12-28', '12:55:45', 100.50, 8239.00, 8339.50, 1),
                (2, 2, '2021-12-29', '08:10:05', 55.50, 340.00, 395.50, 1),
                (3, 3, '2021-12-28', '10:20:11', 340.50, 9212.00, 9552.50, 1),
                (4, 4, '2022-12-08', '15:49:59', 55.50, 3936.00, 3991.5, 1),
                (5, 5, '2022-12-08', '21:13:12', 210.50, 4950.00, 5160.5, 1)";

                $result = mysqli_query($conn, $sql);
                if ($result === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " .  mysqli_error($conn);
                }

            }else{
                echo "Error creating table: " . $conn->error;
            }

            //Create transactions_details TABLE
            $sql = "CREATE TABLE transactions_details (
                trans_id int(11) UNSIGNED NOT NULL, 
                product_id int(30) NOT NULL,
                quantity int(15) NOT NULL,
                total_price double(15,2) NOT NULL,
                PRIMARY KEY (trans_id, product_id, quantity, total_price),
                FOREIGN KEY (trans_id) REFERENCES transactions (id)
                ON DELETE CASCADE
                ON UPDATE CASCADE
                )";

            $result = mysqli_query($conn, $sql);
            if ($result === TRUE){
                echo "Table Transaction Details Created Successfully".'<br>';

                //Insert Dummy Transactions details for testing purpose 
                $sql = "INSERT INTO transactions_details (trans_id, product_id, quantity, total_price) VALUES
                (1, 3, 4, 860.00),
                (1, 7, 1, 2279.00),
                (1, 8, 3, 5100.00),
                (2, 5, 2, 340.00),
                (3, 4, 1, 2412.00),
                (3, 5, 40, 6800.00),
                (4, 1, 2, 3936.00),
                (5, 2, 6, 4620.00),
                (5, 6, 10, 330.00);";

                
                $result = mysqli_query($conn, $sql);
                if ($result === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " .  mysqli_error($conn);
                }

            }else{
                echo "Error creating table: " . $conn->error;
            }

            //Actual Registration Logic
            if($emailE == "" && $mobileE == "" && $pwE == "" && $cpwE == "" && $genderE == "" && $termsE =="" && $fnameE == "" && $lnameE == "" && $addE == "" && $postcodeE == "" && $cityE == ""
            &&  $fname != "" && $lname != "" && $email != "" && $mobile != "" && $pw != "" && $cpw != "" && $gender != "" && $terms != "" && $add != "" && $postcode != "" && $city != "")
            {
                $welcome = "Thank you for your Registration, " .$fname. " !";
                $login = "Click HERE to Login!";

                //Insert registered user's data into the table
                $sql = "INSERT INTO registered_User (firstname, lastname, email, region, phone, pwd, gender, _state, postcode, _address, city,_login)
                VALUES ('$fname', '$lname', '$email','$region','$mobile', '$pw','$gender', '$state', '$postcode', '$add', '$city', 'Logged Out')";
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                  } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                  }

                $sql = "SELECT id FROM registered_User WHERE email='$email'"; //Select the user id
                $isFound = mysqli_query($conn,$sql); 
                $result = mysqli_fetch_assoc($isFound);
                $id = $result["id"];

                //Insert cart data
                $sql = "INSERT INTO ShoppingCart (User_id, Grand_total)
                VALUES ('$id', '0.00')";
                if ($conn->query($sql) === TRUE) {
                    echo "New CART created successfully";
                  } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                  }
            }

            //Close Connection
            mysqli_close($conn);

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
                            <label for="city">City</label>
                        </div>
                        <div class="col2">
                            <input type="text" id="city" name="city" placeholder="City.." value="<?php echo $city;?>" >
                            <span class="error"> <br> <?php echo $cityE; ?> </span>
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

                    <div class="welcome"> 
                        <br> 
                        <?php echo $welcome; ?>
                        <br><br>
                        <span class="login"><a href= "login.php"> <?php echo $login; ?> </a></span>
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