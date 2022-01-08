<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/adminCustomer.css">
    <link rel="icon" href="Pictures/icon.png">
    <link rel="shortcut icon" href="Pictures/icon.png">
    <script src="https://unpkg.com/scrollreveal"></script>
    <title>Admin/Edit Customer - PNWX</title>
</head>
<body>
    
    <?php
        include_once 'adminconfig.php';

        //Create Logic
        //Validation of Data
        //Validation
        $shownid = 0;
        $fname = $lname = ""; 
        $fnameE = $lnameE = $createSuc = $deleteMes ="";
        $NameE1 = "*Please capitalise FIRST CHARACTER of your Name!";
        $NameE2 = "*Please make sure your Name are all in lowercase except the FIRST character!";
        //Other declaration
        $email = $mobile = $pw = $cpw = $gender = $region = $state = "";
        $emailE = $mobileE = $pwE = $cpwE = $genderE = $termsE ="";
        $postcode = $add = $city ="";
        $postcodeE = $addE = $cityE ="";
        $cpw_match = $pw_strong = "";
        $editstat = FALSE;

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
                $pw = test($_POST["pw"]);
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
                $cpw = test($_POST["cpw"]);
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

        if(isset($_POST["create"])){
            if($emailE == "" && $mobileE == "" && $pwE == "" && $cpwE == "" && $genderE == "" && $termsE =="" && $fnameE == "" && $lnameE == "" && $addE == "" && $postcodeE == "" && $cityE == ""
            &&  $fname != "" && $lname != "" && $email != "" && $mobile != "" && $pw != "" && $cpw != "" && $gender != "" &&  $add != "" && $postcode != "" && $city != "")
            {
                //Insert registered user's data into the table
                $sql = "INSERT INTO registered_User (firstname, lastname, email, region, phone, pwd, gender, _state, postcode, _address, city,_login)
                VALUES ('$fname', '$lname', '$email','$region','$mobile', '$pw','$gender', '$state', '$postcode', '$add', '$city', 'Logged Out')";
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                    $createSuc = "New record created successfully";
                    
                    //Resetting Values
                    $fname = $lname = ""; 
                    $fnameE = $lnameE = $createSuc = $deleteMes ="";
                    $NameE1 = "*Please capitalise FIRST CHARACTER of your Name!";
                    $NameE2 = "*Please make sure your Name are all in lowercase except the FIRST character!";
                    
                    $email = $mobile = $pw = $cpw = $gender = $region = $state = "";
                    $emailE = $mobileE = $pwE = $cpwE = $genderE = $termsE ="";
                    $postcode = $add = $city ="";
                    $postcodeE = $addE = $cityE ="";
                    $cpw_match = $pw_strong = "";
                  } else {
                    $createSuc = "Record could not be created successfully";
                    //echo "Error: " . $sql . "<br>" . $conn->error;
                  }

                $sql = "SELECT id FROM registered_user WHERE email='$email'"; //Select the user id
                $isFound = mysqli_query($conn,$sql); 
                $result = mysqli_fetch_assoc($isFound);
                $id = $result["id"];
            }
        }

        //Delete Action

        if(isset($_GET["delete"])){
            //Gets the id from the superglobal
            $deleteid = $_GET["delete"];
            $deletesql = "DELETE FROM registered_user WHERE id = '$deleteid'";
            $deleteresult = mysqli_query($conn, $deletesql);
            if( $deleteresult === TRUE){
                $deleteMes = "Record has been succesfully deleted.";
            }else
            {
                $deleteMes = "Record can't be deleted";
            }
        }
        
        //Edit Mode

        if(isset($_GET["edit"])){
            $editid = $_GET["edit"];
            $editsql = "SELECT * FROM registered_user WHERE id = '$editid'";
            $editresult = mysqli_query($conn, $editsql) or die($mysqli_error($conn));
            if (mysqli_num_rows($editresult) > 0){
                $editstat = TRUE;
                $editrow = mysqli_fetch_assoc($editresult);
                $shownid = $editid;
                $fname = $editrow["firstname"];
                $lname = $editrow["lastname"];
                $email = $editrow["email"];
                $region = $editrow["region"];
                $mobile = $editrow["phone"];
                $pw = $editrow["pwd"];
                $cpw = $editrow["pwd"];
                $gender = $editrow["gender"];
                $state = $editrow["_state"];
                $postcode = $editrow["postcode"];
                $add = $editrow["_address"];
                $city = $editrow["city"];

            }else{
                $deleteMes = "0 results";
            }
        }

        // To exit out of edit mode
        if(isset($_GET["canceledit"])){
            $fname = "";
            $lname = "";
            $email = "";
            $region = "";
            $mobile = "";
            $pw = "";
            $cpw = "";
            $gender = "";
            $state = "";
            $postcode = "";
            $add = "";
            $city = "";
            $shownid = 0;

            $editstat = FALSE;
        }

        //Update Logic
        if(isset($_POST["update"])){
            if($emailE == "" && $mobileE == "" && $pwE == "" && $cpwE == "" && $genderE == "" && $termsE =="" && $fnameE == "" && $lnameE == "" && $addE == "" && $postcodeE == "" && $cityE == ""
            &&  $fname != "" && $lname != "" && $email != "" && $mobile != "" && $pw != "" && $cpw != "" && $gender != "" &&  $add != "" && $postcode != "" && $city != ""){

                $shownid = $_POST['id'];
                $updatesql = "UPDATE registered_user SET firstname = '$fname', lastname = '$lname', email = '$email', region = '$region', phone = '$mobile', pwd = '$pw', 
                gender = '$gender', _state= '$state', postcode ='$postcode', _address ='$add', city = '$city', _login = 'Logged Out' WHERE id = '$shownid'";

                if(mysqli_query($conn, $updatesql)){
                    $deleteMes = "Record ".$shownid." Updated";
                    $email = $mobile = $pw = $cpw = $gender = $region = $state = "";
                    $emailE = $mobileE = $pwE = $cpwE = $genderE = $termsE ="";
                    $postcode = $add = $city ="";
                    $postcodeE = $addE = $cityE ="";
                    $cpw_match = $pw_strong = "";
                }else{
                    $deleteMes = "Update Error";
                }
            }

        }

        //To Clear Values
        if(isset($_GET["clearvalues"])){
            $fname = "";
            $lname = "";
            $email = "";
            $region = "";
            $mobile = "";
            $pw = "";
            $cpw = "";
            $gender = "";
            $state = "";
            $postcode = "";
            $add = "";
            $city = "";
            $emailE = $mobileE = $pwE = $cpwE = $genderE = $termsE ="";
            $postcodeE = $addE = $cityE ="";
            $cpw_match = $pw_strong = "";
            $shownid = 0;
        }

    ?>
    <header class="HeaderHeader" id="Push_header">
        <a href="adminDashboard.php"> <img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc."> </a>
        
        <div class="header_login">
            Admin
        </div>

        <div class="login_register">
            <ul> 
                <li><a href="adminlogout.php">Log Out</a></li>
                <!-- <li><a href=""><?php echo $name ?></a></li> -->
                <li><img class="image_login_register" src="Pictures/login_register_icon.png" alt="Login and register icon"></a>
            </ul>
        </div>
    </header>

    <div class="admin-title">
        <h1>Edit Customer Information</h1>
        <hr>
    </div>

    <!-- Display customer Information -->
    <table class="displayTable">
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Region</th>
                <th>Phone</th>
                <th>Password</th>
                <th>Gender</th>
                <th>State</th>
                <th>Postcode</th>
                <th>Address</th>
                <th>City</th>
                <th>Login</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $table_sql = "SELECT id, firstname, lastname, email, region, phone, pwd, gender, _state, postcode, _address, city, _login
                            FROM registered_user";
                $table_result = mysqli_query($conn, $table_sql);

                if(mysqli_num_rows($table_result) > 0){
                    while($row = mysqli_fetch_assoc($table_result)){
                        echo "<tr><td>".$row['id']."</td><td>".$row['firstname']." ".$row['lastname']."</td><td>".$row['email']."</td><td>".$row['region']."</td><td>"
                        .$row['phone']."</td><td>".$row['pwd']."</td><td>".$row['gender']."</td><td>".$row['_state']."</td><td>".$row['postcode']."</td><td>".$row['_address']."</td><td>"
                        .$row['city']."</td><td>".$row['_login']."</td><td>";

                        echo '<a class="butt" href= "adminEditCustomer.php?edit='.$row['id'].'"><button class="button" type="button value="edit">Edit</button></a>'.
                             '<a class="butt" href= "adminEditCustomer.php?delete='.$row['id'].'"><button class="button" type="button" value="delete">Delete</button></a>'
                             ."</td></tr>"; 
                    }
                }else{
                    echo "<span class='noresults'>No Transactions Detected</span><br><br>";
                }

            ?>
        </tbody>
	</table>

    <?php 
    //Close Connection
    mysqli_close($conn); 
    ?>

    <!-- For inserting new customer data -->
    <br><br><br>
    <div class="column-form">
        <div class="columnB-form">
            <h1><?php if($editstat == TRUE){echo "Update ";}else{echo "Insert ";}?> Customer Data</h1>
            <span class="correct-record"> <?php echo $createSuc; ?> </span>
            <span class="correct-record"> <?php echo $deleteMes; ?> </span>
            <form name="reg" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="hidden" name = "id" value = "<?php echo $editid;?>"/>    
                <table class="formTable">
                    <tr>
                        <th>
                            Category
                        </th>
                        <th>
                            Fields
                        </th>
                    </tr>
                    <tr>
                        <td><label for="fname">First Name</label></td>
                        <td>
                            <input type="text" id="fname" name="fname" placeholder="Your first name.." value="<?php echo $fname;?>">
                            <span class="error"> <br> <?php echo $fnameE; ?> </span>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="lname">Last Name</label></td>
                        <td>
                            <input type="text" id="lname" name="lname" placeholder="Your last name.." value="<?php echo $lname;?>">
                            <span class="error"> <br> <?php echo $lnameE; ?> </span>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="Email">Email</label></td>
                        <td>
                            <input type="email" id="email" name="email" placeholder="Email.." value="<?php echo $email;?>" >
                            <span class="error"> <br> <?php echo $emailE; ?> </span>
                            <br>
                        </td>
                    </tr>    
                    <tr>
                        <td><label for="mobile">Mobile</label></td>
                        <td>
                            <select id="region" name="region">
                                <option value="+60" <?php if($region === "+60"){ echo "selected";} ?>>+60</option>
                                <option value="+1" <?php if($region === "+1"){ echo "selected";} ?>>+1</option>
                                <option value="+44" <?php if($region === "+44"){ echo "selected";} ?>>+44</option>
                            </select>
                            <input type="text" id="mobile" name="mobile" placeholder="Phone number.." value="<?php echo $mobile;?>" >
                            <span class="error"> <br> <?php echo $mobileE; ?> </span>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="pw">Password</label></td>
                        <td>
                            <input type="password" id="pw" name="pw" placeholder="Password.." value="<?php echo $pw;?>" >
                            <span class="error"> <br> <?php echo $pwE; ?> </span>
                            <span class="correct"> <?php echo $pw_strong; ?> </span>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="cpw">Confirm Password</label></td>
                        <td>
                            <input type="password" id="cpw" name="cpw" placeholder="Confirm password.." value="<?php echo $cpw;?>" >
                            <span class="error"> <br> <?php echo $cpwE; ?> </span>
                            <span class="correct"> <?php echo $cpw_match; ?> </span>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="gender">Gender</label></td>
                        <td>
                            <label for="male">Male
                                <input type="radio" id="male" name="gender" value="Male"
                                <?php if (isset($gender) && $gender=="Male") echo "checked";?> >
                            </label>
                            <label for="female">Female
                                <input type="radio" id="female" name="gender" value="Female"
                                <?php if (isset($gender) && $gender=="Female") echo "checked";?> >
                            </label>
                            <br><br><br>
                            <span class="errorGender"><?php echo $genderE; ?> </span>
                        </td>
                        <br>
                    </tr>
                    <tr>
                        <td><label for="address">Address</label></td>
                        <td>
                            <input type="text" id="address" name="Address" placeholder="Address.." value="<?php echo $add;?>" >
                            <span class="error"> <br> <?php echo $addE; ?> </span>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="postcode">Postcode</label></td>
                        <td>
                            <input type="text" id="postcode" name="Postcode" placeholder="Postcode.." value="<?php echo $postcode;?>" >
                            <span class="error"> <br> <?php echo $postcodeE; ?> </span>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="city">City</label></td>
                        <td>
                            <input type="text" id="city" name="city" placeholder="City.." value="<?php echo $city;?>" >
                            <span class="error"> <br> <?php echo $cityE; ?> </span>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="state">State</label></td>
                        <td>
                            <select id="state" name="state">
                                <option value="Johor" <?php if($state === "Johor"){ echo "selected";} ?>>Johor</option>
                                <option value="Kedah" <?php if($state === "Kedah"){ echo "selected";} ?>>Kedah</option>
                                <option value="Kelantan" <?php if($state === "Kelantan"){ echo "selected";} ?>>Kelantan</option>
                                <option value="Melaka" <?php if($state === "Melaka"){ echo "selected";} ?>>Melaka</option>
                                <option value="Negeri Sembilan" <?php if($state === "Negeri Sembilan"){ echo "selected";} ?>>Negeri Sembilan</option>
                                <option value="Pahang" <?php if($state === "Pahang"){ echo "selected";} ?>>Pahang</option>
                                <option value="Penang" <?php if($state === "Penang"){ echo "selected";} ?>>Penang</option>
                                <option value="Perak" <?php if($state === "Perak"){ echo "selected";} ?>>Perak</option>
                                <option value="Perlis" <?php if($state === "Perlis"){ echo "selected";} ?>>Perlis</option>
                                <option value="Sabah" <?php if($state === "Sabah"){ echo "selected";} ?>>Sabah</option>
                                <option value="Sarawak" <?php if($state === "Sarawak"){ echo "selected";} ?>>Sarawak</option>
                                <option value="Selangor" <?php if($state === "Selangor"){ echo "selected";} ?>>Selangor</option>
                                <option value="Terengganu" <?php if($state === "Terengganu"){ echo "selected";} ?>>Terengganu</option>
                            </select>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php if ($editstat === TRUE):?>
                                <input type="submit" name = "update" value="Update" >
                            <?php else: ?>
                                <input type="submit" name = "create" value="Create" >
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($editstat === TRUE):?>
                                <a href="adminEditCustomer.php?canceledit=1"><input type="button" value="Cancel" ></a>
                            <?php else: ?>
                                <a href="adminEditCustomer.php?clearvalues=1"><input type="button" name = "reset" value="Clear" ></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <br><br><br>

    <!-- Calling Scroll Animation -->
    <script src='scrollAnimation.js' defer></script>

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