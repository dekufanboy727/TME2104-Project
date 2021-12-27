<?php 
    session_start(); 

    include 'connection.php';

    if(isset($_SESSION['login']))
    {
        $_SESSION['update_pro'] = $_GET['update_pro'];
        $_SESSION['update_cart_id'] = $_GET['update_cart_id'];
    
        $cart_id = $_SESSION['update_cart_id'];
        $proid = $_SESSION['update_pro'] ;
    
        $sql = "DELETE FROM Cart_Item WHERE Cart_id = '$cart_id' AND Product_id = '$proid'";
        $isFound = mysqli_query($conn,$sql); 
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
                break;
            } 
            $i ++;
        }
        unset($_SESSION['cart'][$i]);
    }

    header('Location:cart.php');
    
?>

