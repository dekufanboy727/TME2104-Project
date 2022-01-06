<?php 
    ob_start();
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
        $check_last_item = 0;

        foreach ($_SESSION['cart'] as $product)
        {
            if(isset($product))
            {
                $check_last_item ++; //Calculate remaining no of item in the session array
            }
            
        }

        //If there is only one item before delete
        if($check_last_item === 1)
        {
            session_destroy(); //Destroy session
        }
        else
        {
            foreach($_SESSION['cart'] as $product)
            {
                if($product['Proid'] === $proid)//If same product found
                {
                    unset($_SESSION['cart'][$i]);
                    break;
                } 
                $i ++;
            }
        }
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    header('Location:cart.php');
    ob_end_flush();
?>

