<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Cart - PNWX</title>
        <link rel="icon" href="Pictures/icon.png">
        <link rel="shortcut icon" href="Pictures/icon.png">
        <link rel="stylesheet" href="CSS/cart.css">
    </head>

    <body>
        <?php
            //For buttons in HEADER
            $signup = $login = $logout = $myprofile = "";
            //Check if session login is defined
            if (isset($_SESSION['login'])) 
            {
                //If it is defined, then we check is it Logged in 
                if($_SESSION['login'] === "Logged In")
                {
                    $logout = "Logout";
                    $myprofile = "My Profile     |";
                }
                else //Or logged out
                {
                    $signup = "Sign Up";
                    $login = "Login     |";
                }
            }
            else //session login not set yet
            {
                $signup = "Sign Up";
                $login = "Login     |";
            }

            // Create onnection
            include 'connection.php';
            //Create table Cart_Item to link user's cart and products
            $sql = "CREATE TABLE Cart_Item (
                Cart_id INT(11) UNSIGNED NOT NULL,
                Product_id INT(11) UNSIGNED NOT NULL,
                Quantity INT(30) NOT NULL,
                Subtotal FLOAT (20,2) NOT NULL,
                FOREIGN KEY (Cart_id) REFERENCES ShoppingCart(id)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
                FOREIGN KEY (Product_id) REFERENCES Product(id)
                ON DELETE CASCADE
                ON UPDATE CASCADE
                )";

                if (mysqli_query($conn, $sql) === TRUE)
                {
                    echo "Table cartITEM created successfully or Table exists".'<br>';
                }
                else
                {
                    echo "Error creating table cart: " . mysqli_error($conn);
                }
        
            //Get the product id & quantity thru the Add Cart InputField in Index.php
            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                //Get the product id and its quantity
                $pro_id = $_POST["product_id"];
                $pro_quantity = $_POST["quantity"];
            
                //Someone has logged in & NOT public user
                if (isset($_SESSION['login'])) 
                {
                    $isFound_Update = false;
                    $userid = $_SESSION['user_id']; //Retrieve userid for that person
                    $sql = "SELECT id FROM ShoppingCart WHERE User_id='$userid'"; //Select the cart id From SHOPPING CART
                    $isFound = mysqli_query($conn,$sql); 

                    //Fetch the cart id
                    $result = mysqli_fetch_assoc($isFound); 

                    //Store the cart id
                    $cartid = $result["id"]; 
                    $_SESSION['cartid'] = $cartid;

                    $sql = "SELECT price FROM Product WHERE id='$pro_id'"; //Select the product price
                    $isFound = mysqli_query($conn,$sql); 

                    //Fetch the price
                    $result = mysqli_fetch_assoc($isFound); 
                    $pro_price = $result["price"]; //Store the price
                    $subtotal = $pro_price * $pro_quantity; //Calculate subtotal
                    
                    //Select all productID for that PERSON in Cart_Item TABLE (use cartID to identify that PERSON)
                    $sql = "SELECT Product_id FROM Cart_Item WHERE Cart_id = $cartid"; 
                    $isFound = mysqli_query($conn,$sql); 

                    //That PERSON already added some products into cart
                    if(mysqli_num_rows($isFound) > 0)
                    {
                        while($row = mysqli_fetch_assoc($isFound))
                        {
                            if($row['Product_id'] === $pro_id ) //Found the same product id in CART
                            {
                                //Update the quantity
                                $sql = "SELECT Quantity FROM Cart_Item WHERE Cart_id= '$cartid' && Product_id = '$pro_id'"; //Select the product price
                                $isFound = mysqli_query($conn,$sql); 
                                $result = mysqli_fetch_assoc($isFound); //Fetch the Quantity
                                $Ori_quantity =  $result['Quantity'];
                                $Ori_quantity = $Ori_quantity + $pro_quantity ; //Add the quantity

                                $sql = "SELECT price FROM Product WHERE id='$pro_id'"; //Select the product price
                                $isFound = mysqli_query($conn,$sql); 
                                $result = mysqli_fetch_assoc($isFound); //Fetch the price
                                $pro_price = $result["price"]; //Store the price

                                //Calculate new subtotal with new quantity
                                $subtotal = $Ori_quantity * $pro_price;

                                //Update the cart_Item with new quantity
                                $sql = "UPDATE Cart_Item 
                                SET Quantity='$Ori_quantity',
                                WHERE Product_id='$pro_id'";
                                $result = mysqli_query ($conn,$sql);

                                //Once found, break the loop
                                $isFound_Update = true; 
                                break;
                            }
                            
                        }

                        //The ITEM HAS NOT BEEN FOUND after the LOOP is completed
                        if($isFound_Update !== true) 
                        {
                            //Insert the NEW ITEM into TABLE
                            $sql = "INSERT INTO Cart_Item (Cart_id, Product_id, Quantity, Subtotal)
                            VALUES ('$cartid', '$pro_id', '$pro_quantity', '$subtotal')";
        
                            if (mysqli_query($conn, $sql) === TRUE)
                            {
                                echo "cart item added successfully".'<br>';
                            }
                            else
                            {
                                echo "Error adding cart item: " . mysqli_error($conn);
                            }
                        }
                    }
                    else //Never added any item yet
                    {
                        //Insert the ITEM
                        $sql = "INSERT INTO Cart_Item (Cart_id, Product_id, Quantity, Subtotal)
                        VALUES ('$cartid', '$pro_id', '$pro_quantity', '$subtotal')";
    
                        if (mysqli_query($conn, $sql) === TRUE)
                        {
                            echo "cart item added successfully".'<br>';
                        }
                        else
                        {
                            echo "Error adding cart item: " . mysqli_error($conn);
                        }
                    }
                    
                }
                else //Public users!
                {
                    $Proid = $_POST["product_id"];
                    $Proquantity = $_POST["quantity"];
                    $isFound_Update = false;
                    
                    //Cart is not SET
                    if(!isset($_SESSION['cart'])) //INITALISED only ONCE
                    {
                        $_SESSION['cart'] = array(); //Declare the variable as ARRAY 
                    }

                    $i = 0;
                    foreach($_SESSION['cart'] as $product)
                    {
                        if($product['Proid'] === $Proid) //If same product found
                        {
                            $product['Proquantity'] =  $product['Proquantity'] + $Proquantity;
                            //Assign the new quantity back into the ARRAY using counter i
                            $_SESSION['cart'][$i] = $product;
                            //Once found, break the loop
                            $isFound_Update = true; 
                            break;
                        }
                        $i++;
                    }
                    
                    if($isFound_Update !== true)
                    {
                        //Push the value into the ARRAY ONCE
                        array_push($_SESSION['cart'], array("Proid" => $Proid, "Proquantity" => $Proquantity));   
                    }
                }
            }
            
        ?>

        
        <header class="HeaderHeader">
            <a href="index.php"> <img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc."> </a>
            <span class = "menu">
                <h3>Shopping Cart</h3>
                <a class = "cart_position" href="cart.php"> <img id="cart" src="Pictures/cart.png" alt="Cart"> </a>
            </span>
            <div class="login_register">
                <ul>
                  <li><a href="register.php"><?php echo $signup?></a></li>
                  <li><a href="login.php" ><?php echo $login?></a></li>
                  <li><a href="logout.php"  ><?php echo $logout?></a></li>
                  <li><a href="myProfile.php"  ><?php echo $myprofile?></a></li>
                  <li><img class="image_login_register" src="Pictures/login_register_icon.png" alt="Login and register icon"></a>
                </ul>
            </div>
        </header>
        
        <div class= "row-title">
            <ul>
            <li>Item(s)</li>
            <li>Quantity</li>
            <li>Unit Price</li>
            <li>Subtotal</li>
            </ul>
        </div>
            
        <?php 
            //To calculate GRAND TOTAL
            $temp_total = $temp_subtotal = 0.00;
            
            //The CARTID session variable is only SET when USERs did log in
            if(isset($_SESSION['login']))
            {
                $cartid = $_SESSION['cartid'];
                
                //Join the product and cart_item tables to DISPLAY CART ITEM
                $sql = "SELECT Cart_Item.Cart_id, product.id, product.productname, Cart_Item.Quantity, product.price, Cart_Item.Subtotal 
                FROM Cart_Item
                INNER JOIN product
                ON Cart_Item.Product_id = product.id /*Find the same PRODUCT ID*/
                WHERE Cart_Item.Cart_id = '$cartid'"; /*Locate that person's CART ID*/

                if (mysqli_query($conn, $sql) == true)
                {
                    echo "Join cart and product SUCCESS!";
                }
                else
                {
                    echo "Error joining cart: " . mysqli_error($conn);
                }

                $result = mysqli_query ($conn,$sql);
                
                //If there is more than 0 rows
                if(mysqli_num_rows($result) > 0)
                {
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo '<td color="white">'.$row['productname']. '</td>';
                        echo '<a href="minus_quantity.php?update_pro='.$row['id'].'&update_pro_quantity='.$row['Quantity'].'&update_cart_id='.$row['Cart_id'].'"><img src = "Pictures/minus.png"></a>';
                        echo '<td>'.$row['Quantity'].'</td>';
                        echo '<a href="plus_quantity.php?update_pro='.$row['id'].'&update_pro_quantity='.$row['Quantity'].'&update_cart_id='.$row['Cart_id'].'"><img src = "Pictures/plus.png"></a>';
                        echo '<td>' .$row['price']. '</td>';
                        echo '<td>' .$row['Subtotal']. '</td>';
                        echo '<a href="remove_item.php?update_pro='.$row['id'].'&update_cart_id='.$row['Cart_id'].'"><img src = "Pictures/remove_item.png"></a>';
                                
                        $temp_subtotal = $row['Subtotal'];
                        $temp_total = $temp_total + $temp_subtotal;
                    }
                    
                    echo '<br>'."Total: $" .$temp_total;
                }
                else
                {
                    echo "Empty Cart!";
                }
            }
            else //Public User!
            {
                $counter = 0;
                $isEmpty = 0;

                foreach($_SESSION['cart'] as $product)
                {
                    if(isset($product['Proid']))
                    {
                        $isEmpty = 1;
                        $proid = $product['Proid'];
                        $proquan = $product['Proquantity'];

                        $sql = "SELECT id, productname, price FROM product WHERE id = '$proid'";
                        $isFound = mysqli_query($conn,$sql); 
                        $row = mysqli_fetch_assoc($isFound);

                        echo $row['productname'];
                        echo '<a href="minus_quantity.php?update_pro='.$row['id'].'"><img src = "Pictures/minus.png"></a>';
                        echo '<td>'.$proquan.'</td>';
                        echo '<a href="plus_quantity.php?update_pro='.$row['id'].'"><img src = "Pictures/plus.png"></a>';
                        echo '<td>' .$row['price']. '</td>';

                        $temp_subtotal = $row['price'] * $proquan;
                        echo '<td>' .$temp_subtotal. '</td>';

                        echo '<a href="remove_item.php?update_pro='.$row['id'].'"><img src = "Pictures/remove_item.png"></a>';
                                
                        
                        $temp_total = $temp_total + $temp_subtotal;
                        echo '<br>';

                        $counter ++ ;
                    }
                        
                }

                if($isEmpty === 1)
                {
                    echo '<br>'."Total: $" .$temp_total;
                }
                else
                {
                    echo "Empty Cart!";
                }
                
                
            }
        ?>

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