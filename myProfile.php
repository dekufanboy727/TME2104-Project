<?php session_start() ?>

<!DOCTYPE html>
<html>
    <head>
        <title>My Profile - PNWX</title>
        <meta charset="UTF-8">
        <link rel="icon" href="Pictures/icon.png">
        <link rel="shortcut icon" href="Pictures/icon.png">
        <script type="text/javascript" src="editprofile.js"></script>
        <link rel="stylesheet" href="CSS/myProfile.css">
    </head>

    <body>
        <header>
            <a href="index.php"> <img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc."> </a>
            <span class = "menu">
                <a id="active" href="myProfile.php"> My Profile </a>
                <a href="dashboard.php"> Dashboard </a>
                <a href="user_trans_list.php"> Transaction History </a>
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
            <?php 
                include 'connection.php';
                $id = $_SESSION['user_id'];
                //Select everything where id of people who logged in now
                $sql = "SELECT * FROM registered_User WHERE id = '$id'"; 
                $isFound = mysqli_query($conn,$sql); //Check is it exists
                $row = mysqli_fetch_assoc($isFound); //fetch the result row

                //Show the pw in * form
                $password = str_repeat("•", strlen($row["pwd"])); 

                //Validate Edit_prodile
                $fname = $lname = ""; 
                $email = $mobile = $pw = $cpw = "";
                $postcode = $add = $city ="";

                $fnameE = $lnameE = "false"; 
                $emailE = $mobileE = $pwE = $cpwE = "false";
                $postcodeE = $addE = $cityE = "false";

                if ($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    //Validate fname
                    if(empty($_POST["fname"]))
                    {
                        $fnameE = "true";
                    }
                    else
                    {
                        $fname = test($_POST["fname"]);

                        //Check whether the first character is upper case?
                        if(!preg_match('~^\p{Lu}~u', $fname))
                        {
                            $fnameE = "true";
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
                                        $fnameE = "true";
                                    }
                                }
                                else if($fname[$x] !== strtolower($fname[$x]))
                                {
                                    $fnameE = "true";
                                }
                            }   
                        }
                    }

                    //Validate lname
                    if(empty($_POST["lname"]))
                    {
                        $lnameE = "true";
                    }
                    else
                    {
                        $lname = test($_POST["lname"]);

                        //Check whether the first character is upper case?
                        if(!preg_match('~^\p{Lu}~u', $lname))
                        {
                            $lnameE = "true";
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
                                        $lnameE = "true";
                                    }
                                }
                                else if($lname[$x] !== strtolower($lname[$x]))
                                {
                                    $lnameE = "true";
                                }
                            }   
                        }
                    }

                    //Validate email
                    if(empty($_POST["email"]))
                    {
                        $emailE = "true";
                    }
                    else 
                    {
                        $email = test($_POST["email"]);
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
                        {
                            $emailE = "true";
                        }
                        
                    }

                    //Validate mobile
                    if(empty($_POST["mobile"]))
                    {
                        $mobileE = "true";
                    }
                    else
                    {
                        $mobile = test($_POST["mobile"]);
                        //Check is it number
                        if(!is_numeric($mobile) || strlen($mobile) > 10 || strlen($mobile) <9)
                        {
                            $mobileE = "true";
                        }
                    }

                    //Validate password
                    if(empty($_POST["pw"]))
                    {
                        $pwE = "true";
                    }
                    else
                    {
                        $pw = $_POST["pw"];
                        if(strlen($pw) <6 || !preg_match("#[0-9]+#",$pw) || !preg_match("#[A-Z]+#",$pw) || !preg_match("#[a-z]+#",$pw) || !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/',$pw) || preg_match('/\s/',$pw))
                        {
                            $pwE = "true";
                        }
                    }

                    //Validate confirm password
                    if(empty($_POST["cpw"]))
                    {
                        $cpwE = "true";
                    }
                    else 
                    {
                        $cpw = $_POST["cpw"];
                        if($cpw !== $_POST["pw"])
                        {
                            $cpwE = "true";
                        }
                    }

                    //Validate address
                    if(empty($_POST["Address"]))
                    {
                        $addE = "true";
                    }
                    else
                    {
                        $add = test($_POST["Address"]);
                    }

                    //Validate postcode
                    if(empty($_POST["Postcode"]))
                    {
                        $postcodeE = "true";
                    }
                    else
                    {
                        $postcode = test($_POST["Postcode"]);
                        if(!is_numeric($postcode) || strlen($postcode) > 5  ||  strlen($postcode) <5)
                        {
                            $postcodeE = "true";
                        }
                    }

                    //Validate city
                    if(empty($_POST["city"]))
                    {
                        $cityE = "true";
                    }
                    else
                    {
                        $city = test($_POST["city"]);
                    }

                    $state = test($_POST["state"]);
                    $region = test($_POST["region"]);
                    $gender = test($_POST["gender"]);
                }

                function test($data)
                {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }
             
                //Update profile if Validation is successful
                if($fnameE === "false" && $lnameE === "false" && $emailE === "false" && $mobileE === "false" && $pwE === "false" && $cpwE === "false" && $postcodeE === "false" && $addE === "false" && $cityE === "false" 
                &&  $fname != "" && $lname != "" && $email != "" && $mobile != "" && $pw != "" && $cpw != "" && $add != "" && $postcode != "" && $city != "")
                {
                    //Update the user info in the database table
                    $sql= "UPDATE registered_User
                    SET firstname = '$fname', lastname= '$lname', email= '$email', region= '$region', phone= '$mobile', pwd= '$pw', gender= '$gender', _state= '$state',postcode= '$postcode', _address= '$add', city= '$city'
                    WHERE id = '$id'";
                    if ($conn->query($sql) === "TRUE") {
                        echo "profile updated!";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }

                    //Refresh the page after profile is updated
                    header("Refresh:0");
                }
            ?>

            <div class="display_title_editbutton"> 
                <span class= "title" >- Profile -</span>
                <noscript>Please ENABLE JavaScript to Edit Profile!</noscript>
                <span class="editbutton">
                    <a onclick="display()" ><img src="Pictures/editprofile.png"></a>
                </span>
            </div>

            <div class="profilepic"> 
            <?php 
                $sql = "SELECT gender FROM registered_User WHERE id = '$id'"; //Select the user id
                $isFound = mysqli_query($conn,$sql); //Check is it exists
                
                //Found the user
                if(mysqli_num_rows($isFound) == 1) 
                {
                    //fetch the id
                    $result = mysqli_fetch_assoc($isFound);
                    $gender = $result["gender"];

                    if( $gender === "Female")
                    {
                        echo '<img src="Pictures/default_pp_female.png">';
                    }
                    else
                    {
                        echo '<img src="Pictures/default_pp_male.png">';
                    }
                }
            ?>
            </div>

            <br>

            <div class = "column">
                <div class="column1">
                    <ul>
                        <li>Email</li>
                        <li>Password</li>
                        <li id="edit_confirm_pw">Confirm Password</li>
                        <li>First Name</li>
                        <li>Last Name</li>
                        <li>Phone</li>
                        <li>Gender</li>
                        <li>Address</li>
                        <li>Postcode</li>
                        <li>City</li>
                        <li>State</li>
                    </ul>
                </div> <!-- End Column1-->

                <div class="column2">
                    <form name="edit" method="post" onsubmit="return validateEditForm()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <ul>
                        <!--Display the li before editting-->
                        <li id="display0"><?php echo  ": " .$row["email"].""; ?></li>
                        <!--Display the input when users try to edit-->
                            <input type="email" id="email" name="email"   value="<?php echo $row["email"]; ?>">

                        <li id="display1"><?php    echo ": " .$password.""; ?></li>
                            <input type="password" id="pw" name="pw"   value="<?php echo $row["pwd"]; ?>">

                        <li id="display2_cpw"><?php    echo ": " .$password.""; ?></li>
                            <input type="password" id="cpw" name="cpw"  value="<?php echo $row["pwd"]; ?>" >

                        <li id="display3"><?php    echo ": " .$row["firstname"].""; ?></li>
                            <input type="text" id="fname" name="fname"  value="<?php echo $row["firstname"];?>">

                        <li id="display4"><?php    echo ": " .$row["lastname"].""; ?></li>
                            <input type="text" id="lname" name="lname"   value="<?php echo $row["lastname"]; ?>">

                        <li id="display5"><?php    echo ": +" .$row["region"]."".$row["phone"].""; ?></li>
                        <span id="PHONE">
                            <select id="region" name="region">
                                        <option value="+60">+60</option>
                                        <option value="+1">+1</option>
                                        <option value="+44">+44</option>
                            </select>
                            <input type="phone" id="mobile" name="mobile"   value="<?php echo $row["phone"]; ?>">
                        </span>

                        <li id="display6"><?php    echo ": " .$row["gender"].""; ?></li>
                        <span id="GENDER">
                            <input type="radio" id="male" name="gender" value="Male"
                            <?php if ($row["gender"]=="Male") echo "checked";?> >
                            <label id="display_male" for="male">Male</label>
                            <input type="radio" id="female" name="gender" value="Female"
                            <?php if ($row["gender"]=="Female") echo "checked";?> >
                            <label id="display_female" for="female">Female</label>
                        </span>

                        <li id="display7"><?php    echo ": " .$row["_address"].""; ?></li>
                            <input type="text" id="address" name="Address" value="<?php echo $row["_address"];?>" >

                        <li id="display8"><?php    echo ": " .$row["postcode"].""; ?></li>
                            <input type="text" id="postcode" name="Postcode" value="<?php echo $row["postcode"];?>" >
                    

                        <li id="display9"><?php    echo ": " .$row["city"].""; ?></li>
                            <input type="text" id="city" name="city"  value="<?php echo $row["city"];?>" >

                        <li id="display10"><?php    echo ": " .$row["_state"].""; ?> </li>
                            <select id="state" name="state">
                                <option value="Kelantan" <?php if ($row["_state"] == 'Kelantan') echo ' selected="selected"'; ?>>Kelantan</option>
                                <option value="Melaka" <?php if ($row["_state"] == 'Melaka') echo ' selected="selected"'; ?>>Melaka</option>
                                <option value="Negeri Sembilan" <?php if ($row["_state"] == 'Sembilan') echo ' selected="selected"'; ?>>Negeri Sembilan</option>
                                <option value="Pahang" <?php if ($row["_state"] == 'Pahang') echo ' selected="selected"'; ?>>Pahang</option>
                                <option value="Penang" <?php if ($row["_state"] == 'Penang') echo ' selected="selected"'; ?>>Penang</option>
                                <option value="Perak" <?php if ($row["_state"] == 'Perak') echo ' selected="selected"'; ?>>Perak</option>
                                <option value="Perlis" <?php if ($row["_state"] == 'Perlis') echo ' selected="selected"'; ?>>Perlis</option>
                                <option value="Sabah" <?php if ($row["_state"] == 'Sabah') echo ' selected="selected"'; ?>>Sabah</option>
                                <option value="Sarawak" <?php if ($row["_state"] == 'Sarawak') echo ' selected="selected"'; ?>>Sarawak</option>
                                <option value="Selangor" <?php if ($row["_state"] == 'Selangor') echo ' selected="selected"'; ?>>Selangor</option>
                                <option value="Terengganu" <?php if ($row["_state"] == 'Terengganu') echo ' selected="selected"'; ?>>Terengganu</option>
                                <option value="Kedah" <?php if ($row["_state"] == 'Kedah') echo ' selected="selected"'; ?>>Kedah</option>
                                <option value="Johor" <?php if ($row["_state"] == 'Johor') echo ' selected="selected"'; ?>>Johor</option>
                            </select>

                        <div id="button">
                            <input type="submit" name = "submit" value="Update" >
                            <input class="cancel" onclick="cancel_edit()" name = "cancel" value="Cancel" >
                        </div>
                    </form>
                </div> <!-- End Column2-->

            </div> <!-- End Column-->
        </main>
        <br><br>

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