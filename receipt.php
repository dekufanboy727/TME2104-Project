<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Receipt - PNWX</title>
        <link rel="icon" href="Pictures/icon.png">
        <link rel="shortcut icon" href="Pictures/icon.png">
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
        <td style="width: 5%"></td>
        <td colspan="2"><img class="logo" style="width:20%" src = "Pictures/logo receipt.png" alt="Pacific Northwest X-Ray Inc."></td>
        <td colspan="2" style="font-size:50px"><p>RECEIPT</p></td>
        <td style="width: 5%"></td>
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
                        <td style="width: 5%"></td>
                        <td colspan="2"><img class="logo" style="width:20%" src = "https://i.imgur.com/SUPr5Gf.png" alt="Pacific Northwest X-Ray Inc."></td>
                        <td colspan="2" style="font-size:50px"><p>RECEIPT</p></td>
                        <td style="width: 5%"></td>
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

                echo '<tr style="font-size:17px;"><td colspan="3"></td><td>'."Receipt No: ".$receipt_no. '</td></tr>';
                echo '<tr style="font-size:17px;"><td colspan="3"></td><td>'."Payment Date: ".$receipt['_date'].'</td></tr>';
                echo '<tr style="font-size:17px;"><td colspan="3"></td><td>'."Payment Time: ".$receipt['_time'].'</td></tr>';

                //CONTENT FOR EMAIL
                $message .= '
                        <tr style="font-size:17px;"><td colspan="3"></td><td> Receipt No: '.$receipt_no.'</td></tr>'.
                        '<tr style="font-size:17px;"><td colspan="3"></td><td> Payment Date: '.$receipt['_date'].'</td></tr>
                        <tr style="font-size:17px;"><td colspan="3"></td><td> Payment Time: '.$receipt['_time'].'</td></tr>';
                //CONTENT FOR EMAIL


                //Select user related info
                $sql = "SELECT firstname, lastname, email, region, phone, _state, postcode, _address, city 
                FROM registered_User WHERE id='$userid'";
                $result = mysqli_query($conn,$sql); 
                $receipt_user = mysqli_fetch_assoc($result); //Fetch the selected info

                //Store the user email for later use
                $email = $receipt_user['email'];

                echo '<tr style="font-size:17px;"><td></td><td><p>To:</p></td></tr>';
                echo '<tr style="font-size:17px;"><td></td><td>'.$receipt_user['lastname']." ".$receipt_user['firstname'].'</td></tr>';
                echo '<tr style="font-size:17px;"><td></td><td>'."+".$receipt_user['region']." ".$receipt_user['phone'].'</td></tr>';
                echo '<tr style="font-size:17px;"><td></td><td>'.$receipt_user['_address'].",".'</td></tr>';
                echo '<tr style="font-size:17px;"><td></td><td>'.$receipt_user['city'].", ".$receipt_user['postcode'].", ".'</td></tr>';
                echo '<tr style="font-size:17px;"><td></td><td>'.$receipt_user['_state'].", Malaysia.".'</td></tr>';
                echo '</table> <br>';

                //CONTENT FOR EMAIL
                $message .= '
                    <main>
                    <tr style="font-size:17px;"><td></td><td><p>To:</p></td></tr>'.
                    '<tr style="font-size:17px;"><td></td><td>'.$receipt_user['lastname']." ".$receipt_user['firstname'].'</td></tr>'.
                    ' <tr style="font-size:17px;"><td></td><td> +'.$receipt_user['region']." ".$receipt_user['phone'].'</td></tr>'.
                    ' <tr style="font-size:17px;"><td></td><td> '.$receipt_user['_address'].",".'</td></tr>'.
                    ' <tr style="font-size:17px;"><td></td><td> '.$receipt_user['city'].", ".$receipt_user['postcode'].", ".'</td></tr>'.
                    ' <tr style="font-size:17px;"><td></td><td> '.$receipt_user['_state'].", Malaysia.".'</td></tr>'.
                    '</table> <br>';
                //CONTENT FOR EMAIL

            ?>

            <table width="100%">
            <tr style="background-color: #C0C0C0; height: 70px; font-size: 20px;" align= center>
                <td style="background-color: #FFFFFF; width: 5%"></td>
                <td width="10%"> No. </td>
                <td width="50%">Product(s)</td>
                <td width="10%">Quantity</td>
                <td width="10%">Unit Price</td>
                <td width="10%">Subtotal</td>
                <td style="background-color: #FFFFFF; width:5%"></td>
            </tr>
            

            <!--CONTENT FOR EMAIL-->
            <?php 
                $message .= '
                <table width="100%">
                <tr style="background-color: #C0C0C0; height: 70px; font-size: 20px;" align= center>
                    <td style="background-color: #FFFFFF; width: 75px"></td>
                    <td> No. </td>
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
                   // echo '<tr><td></td><td>'."FOUND transactions_details!".'</td></tr>';
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
                        
                        //To ensure the price doesnt change due to modification in admin side
                        $unit_price = $row_trans['total_price']/$row_trans['quantity'];

                        echo'<tr align = "center" style="height: 70px; font-size: 19px;">';
                        echo '<td></td>';
                        echo '<td>' .$counter. '</td>';
                        echo '<td>' .$row_trans['product_name']. '</td>';
                        echo '<td>' .$row_trans['quantity'].'</td>';
                        echo '<td>' .$unit_price. '</td>';
                        echo '<td>' .$row_trans['total_price']. '</td>';

                        //CONTENT FOR EMAIL
                        $message .= '
                            <tr align = "center" style="height: 70px; font-size: 19px;">
                            <td></td>
                            <td>' .$counter. '</td>
                            <td>' .$row_trans['product_name']. '</td>
                            <td>' .$row_trans['quantity'].'</td>
                            <td>' .$unit_price. '</td>
                            <td>' .$row_trans['total_price']. '</td>';
                        //CONTENT FOR EMAIL
                    }
                    echo'</tr>';
                    echo '<tr style="height: 50px; font-size: 19px;"><td></td><td style="border-top: 1px solid #C0C0C0;" colspan="4" align=right>'. "Merchandise Subtotal: ".
                    '</td><td align=center style="border-top: 1px solid #C0C0C0;">'.$receipt['merchandise_total'].'</td></tr>';
                    echo '<tr style="height: 50px; font-size: 19px;"><td colspan="5" align=right>'."Shipping Subtotal: ".'</td><td align=center>'.$receipt['shipping_fee'].'</td></tr>';
                    echo '<tr style="height: 50px; font-size: 19px; font-weight: bold;"><td colspan="5" align=right>'."Total: ".'</td><td align=center>'.$receipt['grand_total'].'</td></tr>';

                    //CONTENT FOR EMAIL
                    $message .= '
                            <tr style="height: 50px; font-size: 19px;"><td></td><td style="border-top: 1px solid #C0C0C0;" colspan="4" align=right>'. "Merchandise Subtotal: ".
                            '</td><td align=center style="border-top: 1px solid #C0C0C0;">'.$receipt['merchandise_total'].'</td></tr>
                            <tr style="height: 50px; font-size: 19px;"><td colspan="5" align=right> Shipping Subtotal: '.'</td><td align=center>'.$receipt['shipping_fee'].'</td></tr>
                            <tr style="height: 50px; font-size: 19px; font-weight: bold;"><td colspan="5" align=right> Total: '.'</td><td align=center>'.$receipt['grand_total'].'</td></tr></tr>
                            </table></main>';
                    //CONTENT FOR EMAIL
                }
                
            ?>
            </table>
        </main>
       

        <br><br><br>
        <footer style="padding-top:10em;margin-top:auto;">
            <h3 align=center> Thank You for Purchasing with Us!</h3>
            <hr style="margin-left:70px; margin-right:70px; border-top: 1px solid gray;">
                <div align=center style="font-size:17px;">
                    <p>Address: P.O. Box 625, Gresham, OR 97030 U.S.A. &nbsp||&nbsp 
                     Tel: 503-667-3000  &nbsp||&nbsp  Toll-Free: 800-827-9729  &nbsp||&nbsp  Fax: 503-666-8855 </p>
                    <p>©1997-2021 Pacific Northwest X-Ray Inc. - Sales & Marketing Division - All Rights Reserved </p>
                </div>

        </footer>

        <?php
            //CONTENT FOR EMAIL
            $message .= '
                    <br><br><br>
                    <footer style="padding-top:10em;margin-top:auto;">
                    <h3 align=center> Thank You for Purchasing with Us!</h3>
                    <hr style="margin-left:70px; margin-right:70px; border-top: 1px solid gray;">
                            <div align=center style="font-size:17.5px;">
                                <p>Address: P.O. Box 625, Gresham, OR 97030 U.S.A. &nbsp||&nbsp 
                                 Tel: 503-667-3000  &nbsp||&nbsp  Toll-Free: 800-827-9729  &nbsp||&nbsp  Fax: 503-666-8855 </p>
                                <p>©1997-2021 Pacific Northwest X-Ray Inc. - Sales & Marketing Division - All Rights Reserved </p>
                            </div>
            
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