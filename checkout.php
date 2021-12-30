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

            <a href = "payment.php"><button class="b2"> Place Order </button></a>

        

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