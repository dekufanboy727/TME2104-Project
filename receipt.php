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

            //Used to check whether we need to send receipt thru email?
            //If the user is checking the transaction list, then no
            //If the user is making new transaction (check out), then yes
            $check = $_GET['check'];
        ?>

        <header>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td style="width: 80px"></td>
        <td colspan="2"><img class="logo" style="width:20%" src="Pictures/logo receipt.png" alt="Pacific Northwest X-Ray Inc."></td>
        <td colspan="2" style="font-size:50px"><p>RECEIPT</p></td>
        <td style="width: 80px"></td>
        </tr>
        </header>

        <!--CONTENT FOR EMAIL-->
        <?php
            $message = '
            <html lang="en">
                <head>
                    <title>Receipt</title>
                </head>
                <body>
                    <header>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <td></td>
                        <td colspan="3"><img class="logo" src="https://i.imgur.com/SUPr5Gf.png" alt="Pacific Northwest X-Ray Inc."></td>
                        <td colspan="5" style="font-size:50px"><p>RECEIPT</p></td>
                        <td></td>
                        </tr>
                    </header>';
        ?>
        <!--CONTENT FOR EMAIL-->

        <main>


            <!--Upper Portion-->
            <?php

                //Select transaction related info
                $sql = "SELECT * FROM transactions WHERE id='$receipt_no'";
                $result_trans = mysqli_query($conn,$sql); 
                $receipt = mysqli_fetch_assoc($result_trans); //Fetch the selected info

                echo '<tr><td colspan="3"></td><td>'."Receipt No: ".$receipt_no. '</td></tr>';
                echo '<tr><td colspan="3"></td><td>'."Payment Date: ".$receipt['_date'].'</td></tr>';
                echo '<tr><td colspan="3"></td><td>'."Payment Time: ".$receipt['_time'].'</td></tr>';

                //CONTENT FOR EMAIL
                $message .= '
                        <tr><td colspan="3"></td><td> Receipt No: '.$receipt_no.'</td></tr>'.
                        '<tr><td colspan="3"></td><td> Payment Date: '.$receipt['_date'].'</td></tr>
                        <tr><td colspan="3"></td><td> Payment Time: '.$receipt['_time'].'</td></tr>';
                //CONTENT FOR EMAIL


                //Select user related info
                $sql = "SELECT firstname, lastname, email, region, phone, _state, postcode, _address, city 
                FROM registered_User WHERE id='$userid'";
                $result = mysqli_query($conn,$sql); 
                $receipt_user = mysqli_fetch_assoc($result); //Fetch the selected info

                //Store the user email for later use
                $email = $receipt_user['email'];

                echo '<tr><td></td><td><p>To</p></td></tr>';
                echo '<tr><td></td><td>'.$receipt_user['lastname']." ".$receipt_user['firstname'].'</td></tr>';
                echo '<tr><td></td><td>'."+".$receipt_user['region']." ".$receipt_user['phone'].'</td></tr>';
                echo '<tr><td></td><td>'.$receipt_user['_address'].",".'</td></tr>';
                echo '<tr><td></td><td>'.$receipt_user['city'].", ".$receipt_user['postcode'].", ".'</td></tr>';
                echo '<tr><td></td><td>'.$receipt_user['_state'].", Malaysia.".'</td></tr>';

                //CONTENT FOR EMAIL
                $message .= '
                    <main>
                    <tr><td></td><td><p>To</p></td></tr>'.
                    '<tr><td></td><td>'.$receipt_user['lastname']." ".$receipt_user['firstname'].'</td></tr>'.
                    ' <tr><td></td><td> +'.$receipt_user['region']." ".$receipt_user['phone'].'</td></tr>'.
                    ' <tr><td></td><td> +'.$receipt_user['_address'].",".'</td></tr>'.
                    ' <tr><td></td><td> +'.$receipt_user['city'].", ".$receipt_user['postcode'].", ".'</td></tr>'.
                    ' <tr><td></td><td> +'.$receipt_user['_state'].", Malaysia.".'</td></tr>';
                //CONTENT FOR EMAIL


            ?>

            
            <tr style="background-color: #C0C0C0" align= center>
                <td style="background-color: #FFFFFF; width: 75px"></td>
                <td >Product(s)</td>
                <td >Quantity</td>
                <td >Unit Price</td>
                <td >Subtotal</td>
                <td style="background-color: #FFFFFF; width:80px"></td>
            </tr>
            

            <!--CONTENT FOR EMAIL-->
            <?php 
                $message .= '
                <tr style="background-color: #C0C0C0" align= center>
                <td style="background-color: #FFFFFF; width: 75px"></td>
                <td >Product(s)</td>
                <td >Quantity</td>
                <td >Unit Price</td>
                <td >Subtotal</td>
                <td style="background-color: #FFFFFF; width:80px"></td>
                </tr>';
            ?>
            <!--CONTENT FOR EMAIL-->

            <!--Lower Portion-->
            <?php
                $sql = "SELECT * FROM transactions_details WHERE trans_id = '$receipt_no'"; 

                $result_trans_detail = mysqli_query($conn, $sql);                
                if ($result_trans_detail == true)
                {
                    echo '<tr><td></td><td>'."FOUND transactions_details!".'</td></tr>';
                }
                else
                {
                    echo '<tr><td></td><td>'."Error finding transactions_details: " . mysqli_error($conn). '</td></tr>';
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
                        echo '<td>' .$counter. '</td>';
                        echo '<td>' .$row_pro['productname']. '</td>';
                        echo '<td>' .$row_trans['quantity'].'</td>';
                        echo '<td>' .$unit_price. '</td>';
                        echo '<td>' .$row_trans['total_price']. '</td>';

                        //CONTENT FOR EMAIL
                        $message .= '
                            <table><tr align = "center">
                            <td>' .$counter. '</td>
                            <td>' .$row_pro['productname']. '</td>
                            <td>' .$row_trans['quantity'].'</td>
                            <td>' .$unit_price. '</td>
                            <td>' .$row_trans['total_price']. '</td>';
                        //CONTENT FOR EMAIL
                    }
                    echo'</tr></table>';
                    echo "Merchandise Subtotal: ".$receipt['merchandise_total'].'<br>';
                    echo "Shipping Subtotal: ".$receipt['shipping_fee'].'<br>';
                    echo "Total: ".$receipt['grand_total'].'<br>';

                    //CONTENT FOR EMAIL
                    $message .= '
                            </tr></table>
                            Merchandise Subtotal: '.$receipt['merchandise_total'].'<br>
                            Shipping Subtotal: '.$receipt['shipping_fee'].'<br>
                            Total: '.$receipt['grand_total'].'<br>
                            </main>';
                    //CONTENT FOR EMAIL
                }
                
            ?>

        </main>

        <tr><td></td><td>Thank You for Purchasing with Us!</td></tr>
        </table>
        <br><br><br>
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

        <?php
            //CONTENT FOR EMAIL
            $message .= '
                    <footer>
                        <p>Thank You for Purchasing with Us!</p>
                    </footer></body></html>';
            //CONTENT FOR EMAIL

            //If user making new order, then send email
            if($check == true)
            {
                //Get user email
                $to = $email;
                
                //Subject
                $subject = "PNWX - Receipt No ".$receipt_no;

                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                // More headers
                $headers .= 'From: <PNWX@hotmail.com>' . "\r\n";

                

                $MAIL = mail($to,$subject,$message,$headers);
                if($MAIL == true)
                {
                    echo "SUCCESS MAIL!";
                }
                else if($MAIL == false)
                {
                    echo "FAILED MAIL!";
                }
            }
        ?>

    </body>

</html>