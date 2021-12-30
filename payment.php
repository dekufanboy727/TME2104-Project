<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Payment - PNWX</title>
        <link rel="icon" href="Pictures/icon.png">
        <link rel="shortcut icon" href="Pictures/icon.png">
        <link rel="stylesheet" href="CSS/payment.css">
    </head>

    <body>
        <?php 
            include 'connection.php';
            $userid = $_SESSION['user_id'];
            $cartid = $_SESSION['cartid'];
            $shippingfee = $_SESSION['shipping'];
            $merchandise = $_SESSION['merchandise'];
            $paymentotal = $_SESSION['PaymentTotal'];
        ?>

        <header class="HeaderHeader">
            <img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc.">
            <span class = "menu">
                <h3>Checking Out - Payment</h3>
            </span>
        </header>

        <main>
            <p>Total: 

            <?php 
                $sql = "SELECT Grand_total FROM ShoppingCart WHERE User_id='$userid'";
                $isFound = mysqli_query($conn,$sql); 

                //Fetch the grantotal
                $result = mysqli_fetch_assoc($isFound); 

                $total = $shippingfee + $result['Grand_total'];
                echo $total.'</p>';
            ?>

            <p>Processing Payment...</p>
            <p>
                OTP
                <form name="payment" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="text" id="validation" name="validation">
                    <div class="button">
                        <input type="submit" name = "submit" value="Submit" >
                    </div>
                </form>
            </p>

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

                        //Redirect to receipt after successful payment
                        header( "refresh:3 ; url=receipt.php" );

                        
                    }
                    else
                    {
                        echo $validate_error;
                        echo $validate_error2;

                        //Redirect back to cart after failed payment attempt
                        header( "refresh:3 ; url=cart.php" );
                    }

                    echo "Redirecting...";
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