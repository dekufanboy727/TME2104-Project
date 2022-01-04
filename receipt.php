<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Receipt - PNWX</title>
        <link rel="icon" href="Pictures/icon.png">
        <link rel="shortcut icon" href="Pictures/icon.png">
        <link rel="stylesheet" href="CSS/receipt.css">
    </head>

    <body>
        <?php 
            include 'connection.php';
            $userid = $_SESSION['user_id'];
            //Retrieve the trans id through get method
            $_SESSION['receipt'] = $_GET['receipt'];
            $receipt_no = $_SESSION['receipt'];
        ?>

        <header>
            <img class="logo" src="Pictures/logo receipt.png" alt="Pacific Northwest X-Ray Inc.">
            <p>Pacific Northwest X-Ray Inc.</p>
            <p>Receipt</p>
        </header>

        <main>
            <p>To </p><br>

            <!--Upper Portion-->
            <?php
                //Select user related info
                $sql = "SELECT firstname, lastname, region, phone, _state, postcode, _address, city 
                FROM registered_user WHERE id='$userid'";
                $result = mysqli_query($conn,$sql); 
                $receipt_user = mysqli_fetch_assoc($result); //Fetch the selected info

                echo '<p>'.$receipt_user['lastname']." ".$receipt_user['firstname'].'<br>';
                echo "+".$receipt_user['region']." ".$receipt_user['phone'].'<br>';
                echo $receipt_user['_address'].",".'<br>';
                echo $receipt_user['city'].", ".$receipt_user['postcode'].", ".'<br>';
                echo $receipt_user['_state'].", Malaysia.".'</p>';

                //Select transaction related info
                $sql = "SELECT * FROM transactions WHERE id='$receipt_no'";
                $result_trans = mysqli_query($conn,$sql); 
                $receipt = mysqli_fetch_assoc($result_trans); //Fetch the selected info

                echo '<p>'."Payment Date: ".$receipt['_date'];
                echo "Payment Time: ".$receipt['_time'].'</p>';
            ?>

            <table>
            <tr style="background-color: #C0C0C0">
                <td style="background-color: #FFFFFF"></td>
                <td style= "width:50%" align= center >Product(s)</td>
                <td></td>
                <td>Quantity</td>
                <td></td>
                <td>Unit Price</td>
                <td>Subtotal</td>
                <td></td>
                <td style="background-color: #FFFFFF"></td>
            </tr>
            </table>

            <!--Lower Portion-->
            <?php
                $sql = "SELECT * FROM transactions_details WHERE trans_id = '$receipt_no'"; 

                $result_trans_detail = mysqli_query($conn, $sql);                
                if ($result_trans_detail == true)
                {
                    echo "FOUND transactions_details!";
                }
                else
                {
                    echo "Error finding transactions_details: " . mysqli_error($conn);
                }

                if(mysqli_num_rows($result_trans_detail) > 0)
                {
                    $counter = 0;
                    while($row_trans = mysqli_fetch_assoc($result_trans_detail))
                    {
                        $counter++;
                        $product_id = $row_trans['product_id'];
                        //Fetch product details
                        $sql = "SELECT * FROM product WHERE id = '$product_id'"; 
                        $result_pro = mysqli_query($conn, $sql);  
                        $row_pro = mysqli_fetch_assoc($result_pro);
                        

                        //To ensure the price doesnt change due to some modification
                        $unit_price = $row_trans['total_price']/$row_trans['quantity'];

                        echo'<table><tr align = "center">';
                        echo'<td></td>';
                        echo '<td>'.$counter. '</td>';
                        echo '<td >'.$row_pro['productname']. '</td>';
                        echo '<td>'.$row_trans['quantity'].'</td>';
                        echo '<td>' .$unit_price. '</td>';
                        echo '<td>' .$row_trans['total_price']. '</td>';
                        echo'</tr></table>';
                    }

                    echo "Merchandise Subtotal: ".$receipt['merchandise_total'];
                    echo "Shipping Subtotal: ".$receipt['shipping_fee'];
                    echo "Total: ".$receipt['grand_total'];
                }
                $result = mysqli_query ($conn,$sql);
            ?>

        </main>

        <p>Thank You for Purchasing with Us!</p>
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
                <sub class="Disclaimer">©1997-2021 Pacific Northwest X-Ray Inc. - Sales & Marketing Division - All Rights Reserved</sub>
                </div>
        </footer>


    </body>

</html>