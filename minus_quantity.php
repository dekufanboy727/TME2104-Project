<?php 
    session_start(); 

    include 'connection.php';

    if(isset($_SESSION['login']))
    {
        $_SESSION['update_pro'] = $_GET['update_pro'];
        $_SESSION['update_pro_quantity'] = $_GET['update_pro_quantity'];
        $_SESSION['update_cart_id'] = $_GET['update_cart_id'];
    
        $cart_id = $_SESSION['update_cart_id'];
        $proid = $_SESSION['update_pro'] ;
        $quantity = $_SESSION['update_pro_quantity'] ;
        $quantity = $quantity -1;
    
        $sql = "SELECT price FROM Product WHERE id='$proid'"; //Select the product price
        $isFound = mysqli_query($conn,$sql); 
        $result = mysqli_fetch_assoc($isFound); //Fetch the price
        $pro_price = $result["price"]; //Store the price
        $subtotal = $quantity * $pro_price; //Calculate new subtotal
    
    
        $sql = "UPDATE Cart_Item SET Quantity='$quantity', Subtotal = '$subtotal' WHERE Product_id='$proid' AND Cart_id='$cart_id' ";
        $result = mysqli_query ($conn,$sql);
    }
    else
    {
        $_SESSION['update_pro'] = $_GET['update_pro'];
        $proid = $_SESSION['update_pro'] ;
        $i = 0;
        foreach($_SESSION['cart'] as $product)
        {
            if($product['Proid'] === $proid)//If same product found
            {
                $product['Proquantity'] =  $product['Proquantity'] - 1;
                
                $_SESSION['cart'][$i] = $product;
                break;
            } 
            $i ++;
        }
    }

    header('Location:cart.php');
    
?>

