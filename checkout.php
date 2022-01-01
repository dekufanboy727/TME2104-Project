<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Check Out - PNWX</title>
        <link rel="icon" href="Pictures/icon.png">
        <link rel="shortcut icon" href="Pictures/icon.png">
        <link rel="stylesheet" href="CSS/checkout.css">
    </head>

    <body>
        <header class="HeaderHeader">
            <a href="index.php"> <img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc."> </a>
            <span class = "menu">
                <h3>Checking Out - Payment</h3>
                <a class = "cart_position" href="cart.php"> <img id="cart" src="Pictures/cart.png" alt="Cart"> </a>
            </span>
            <div class="login_register">
                <ul>
                  <li><a href="logout.php"  >Logout</a></li>
                  <li>| </li>
                  <li><a href="myProfile.php"  >My Profile</a></li>
                  <li><img class="image_login_register" src="Pictures/login_register_icon.png" alt="Login and register icon"></a>
                </ul>
            </div>
        </header>
        
        <main>
            <?php 
                include 'connection.php';
                $userid = $_SESSION['user_id'];
                $cartid = $_SESSION['cartid'];


                //Select user info from the table
                $sql = "SELECT firstname, lastname, region, phone, _state, postcode, _address, city 
                FROM registered_user WHERE id='$userid'";
                $result = mysqli_query($conn,$sql); 
                $user_making_payment = mysqli_fetch_assoc($result); //Fetch the selected info
                
            ?>
            <img src="Pictures/delivery.png">
            <p>Delivery Address</p> <br>
            <?php
                echo $user_making_payment['lastname']." ".$user_making_payment['firstname'];
                echo "+".$user_making_payment['region']." ".$user_making_payment['phone'];
                echo $user_making_payment['_address'].", ".$user_making_payment['city'].", ".$user_making_payment['postcode'].", ".$user_making_payment['_state'].", Malaysia.";
            ?>
            <br>

            <?php
                $total_quantity = $shippingfee = $paymentotal = 0;
                $sql = "SELECT Cart_Item.Cart_id, product.id, product.productname, Cart_Item.Quantity, product.price, Cart_Item.Subtotal 
                FROM Cart_Item
                INNER JOIN product
                ON Cart_Item.Product_id = product.id /*Find the same PRODUCT ID*/
                WHERE Cart_Item.Cart_id = '$cartid'"; /*Locate that person's CART ID*/

                $result = mysqli_query ($conn,$sql);

                if(mysqli_num_rows($result) > 0)
                {
                    $total_quantity = mysqli_num_rows($result); //Fetch the total number of items
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo'<tr align = "center">';
                        echo '<td >'.$row['productname']. '</td><br>';
                        echo '<td>'.$row['Quantity'].'</td><br>';
                        echo '<td>' .$row['price']. '</td><br>';
                        echo '<td>' .$row['Subtotal']. '</td><br>';
                        echo'</tr>';
                    }
                }

                if($total_quantity <= 5 )
                {
                    $shippingfee = 55.50;
                }
                else if($total_quantity > 5 && $total_quantity <= 10)
                {
                    $shippingfee = 100.50;
                }
                else if($total_quantity > 10 && $total_quantity <= 15)
                {
                    $shippingfee = 150.50;
                }
                else if($total_quantity > 15 && $total_quantity <= 20)
                {
                    $shippingfee = 210.50;
                }
                else if($total_quantity > 15 && $total_quantity <= 20)
                {
                    $shippingfee = 270.50;
                }
                else
                {
                    $shippingfee = 340.50;
                }

                $_SESSION['shipping'] = $shippingfee;
                
                $sql = "SELECT Grand_total FROM ShoppingCart WHERE id = '$cartid'"; 
                $result = mysqli_query ($conn,$sql);
                $user_making_payment = mysqli_fetch_assoc($result);

                $_SESSION['merchandise'] = $user_making_payment['Grand_total'];

                $paymentotal = $user_making_payment['Grand_total'] + $shippingfee;
                echo "Merchandise Subtotal: ".$user_making_payment['Grand_total'];
                echo "Shipping Subtotal: ".$shippingfee;
                echo "Payment Total (".$total_quantity." Item): ".$paymentotal;

                $_SESSION['PaymentTotal'] = $paymentotal;
            ?>

            <!--Payment-->
            <p>Total: 

            <?php 
                $shippingfee = $_SESSION['shipping'];
                $merchandise = $_SESSION['merchandise'];
                $paymentotal = $_SESSION['PaymentTotal'];

                $sql = "SELECT Grand_total FROM ShoppingCart WHERE User_id='$userid'";
                $isFound = mysqli_query($conn,$sql); 

                //Fetch the grantotal
                $result = mysqli_fetch_assoc($isFound); 

                $total = $shippingfee + $result['Grand_total'];
                echo $total.'</p>';
            ?>
            <p>
                OTP
                <form name="payment" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="text" id="validation" name="validation">
                    <div class="button">
                        <input type="submit" name = "submit" value="Submit" >
                    </div>
                </form>
            </p>

            <!--Validate dummy OTP-->
            <?php
                $validate_error = "";
                $validate_error2 = "";
                $OTP = "";
                $trans_id = "";
                if ($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    if(empty($_POST["validation"]))
                    {
                        $validate_error = "PAYMENT ATTEMPT FAILED!";
                        $validate_error2 = "Please try to CHECK OUT AGAIN!";
                    }
                    else
                    {
                        $OTP = test($_POST["validation"]);
                        if(!is_numeric($OTP) || strlen($OTP) !== 6)
                        {
                            $validate_error = "PAYMENT ATTEMPT FAILED!";
                            $validate_error2 = "Please try to CHECK OUT AGAIN!";
                        }
                    }

                    if($OTP !== "" && $validate_error === "" && $validate_error2 === "")
                    {
                        date_default_timezone_set("Asia/Kuching");
                        $date = date("Y-m-d");
                        $time = date("H:i:s");

                        $sql = "INSERT INTO transactions (userid, _date, _time, shipping_fee, merchandise_total, grand_total) 
                        VALUES ('$userid', '$date', '$time', '$shippingfee', '$merchandise', '$paymentotal')";
                        $isFound = mysqli_query($conn,$sql);

                        if ($isFound === TRUE) {
                            echo "New record created successfully";
                        } else {
                            echo "Error: " .  mysqli_error($conn);
                        }

                        //Fetch the trans id
                        $sql = "SELECT id FROM transactions WHERE userid = '$userid' AND _date = '$date' AND _time = '$time'"; 
                        $isFound = mysqli_query($conn,$sql); 
                        $result = mysqli_fetch_assoc($isFound);
                        //Store the trans id into the variable
                        $trans_id = $result['id'];

                        //Select every product in CART ITEM 
                        $sql = "SELECT * FROM Cart_Item WHERE Cart_id = '$cartid'"; 
                        $isFound = mysqli_query($conn,$sql); 
    
                        if(mysqli_num_rows($isFound) > 0)
                        {
                            while($row = mysqli_fetch_assoc($isFound)) //Insert every product into the transactions details
                            {
                                $proid = $row['Product_id'];
                                $quan = $row['Quantity'];
                                $subtotal = $row['Subtotal'];
                                $sql = "INSERT INTO transactions_details (trans_id, product_id, quantity, total_price) VALUES
                                ('$trans_id', '$proid', '$quan', '$subtotal')";

                                $isInsert = mysqli_query($conn,$sql); 
                                if ($isInsert === TRUE) {
                                    echo "New record FOR TRANSACTIONS DETAILS created successfully";
                                } else {
                                    echo "Error record FOR TRANSACTIONS DETAILS : " .  mysqli_error($conn);
                                }
                            }
     
                            //Remove the paid items in cart
                            $sql = "DELETE FROM Cart_Item WHERE Cart_id = $cartid";
                            $isFound = mysqli_query($conn,$sql); 
                            if ($isFound === TRUE) {
                                echo "Remove the paid items in cart successfully";
                            } else {
                                echo "Error Remove the paid items: " .  mysqli_error($conn);
                            }
                        }
                        echo "Validation and Payment Successful!";
                        echo '<p>'."Payment Date: ".$date;
                        echo "Payment Time: ".$time.'</p>';
                        echo "Generating Receipt and Redirecting back to CATALOG...";

                        //Redirect back to index.php after successful payment
                        header( "refresh:8 ; url=index.php" );
                        
                        //Open a new tab for receipt
                        echo '<script type="text/javascript">
                             window.open("receipt.php?receipt='.$trans_id.'")
                             </script>';
                        
                    }
                    else
                    {
                        echo $validate_error;
                        echo $validate_error2;
                        echo "Redirecting back to CART...";
                        //Redirect back to cart after failed payment attempt
                        header( "refresh:3 ; url=cart.php" );
                    }

                }

                function test($data)
                {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }
            ?>

            

        </main>

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