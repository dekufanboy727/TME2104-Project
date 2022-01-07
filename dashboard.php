<?php session_start() ?>

<!DOCTYPE html>
<html>
    <head>
        <title>My Dashboard - PNWX</title>
        <meta charset="UTF-8">
        <link rel="icon" href="Pictures/icon.png">
        <link rel="shortcut icon" href="Pictures/icon.png">
        <link rel="stylesheet" href="CSS/dashboard.css">
    </head>

    <body>
        <?php 
            include 'connection.php';
            $userid = $_SESSION['user_id'];
        ?>
        <header>
            <a href="index.php"> <img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc."> </a>
            <span class = "menu">
                <a href="myProfile.php"> My Profile </a>
                <a id="active" href="dashboard.php"> Dashboard </a>
                <a href="index.php"> Catalog </a>
                <a class = "cart_position" href="cart.php"> <img id="cart" src="Pictures/cart.png" alt="Cart"> </a>
            </span>
            <span class= "logout"> 
                <a id = "logout" href="logout.php">Logout</a>
                <span>&nbsp|&nbsp</span>
                <a href="myProfile.php"  >My Profile</a>
                <img class="image_login_register" src="Pictures/login_register_icon.png" alt="Login and register icon">
            </span>
        </header>

        <main>
            <!--CHART-->
            <?php
                //Initialise array
                $month = array(0,0,0,0,0,0,0,0,0,0,0,0);

                //Retrieve current year
                $currentyear = date("Y");

                //Number of Transactions in a year by month CHART
                $sql = "SELECT id, _date FROM transactions WHERE userid = '$userid'";
                $result = mysqli_query($conn,$sql); 

                if(mysqli_num_rows($result) > 0)
                {
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $temp_year = date('Y', strtotime($row['_date']));
                        $temp_month = date('m', strtotime($row['_date']));
                        if($temp_year === $currentyear)
                        {
                            
                            if($temp_month === '01')
                                $month[0] ++;
                            else if ($temp_month === '02')
                                $month[1] ++;
                            else if ($temp_month === '03')
                                $month[2] ++;
                            else if ($temp_month === '04')
                                $month[3] ++;
                            else if ($temp_month === '05')
                                $month[4] ++;
                            else if ($temp_month === '06')
                                $month[5] ++;
                            else if ($temp_month === '07')
                                $month[6] ++;
                            else if ($temp_month === '08')
                                $month[7] ++;
                            else if ($temp_month === '09')
                                $month[8] ++;
                            else if ($temp_month === '10')
                                $month[9] ++;
                            else if ($temp_month === '11')
                                $month[10] ++;
                            else if ($temp_month === '12')
                                $month[11] ++;
                        }
                        
                    }
                }

                //CHART
                echo '<table>
                     <tr><td>Month</td><td>Number of Transaction</td></tr>
                     <tr><td>Jan</td><td>'.$month[0].'</td></tr>
                     <tr><td>Feb</td><td>'.$month[1].'</td></tr>
                     <tr><td>March</td><td>'.$month[2].'</td></tr>
                     <tr><td>April</td><td>'.$month[3].'</td></tr>
                     <tr><td>May</td><td>'.$month[4].'</td></tr>
                     <tr><td>June</td><td>'.$month[5].'</td></tr>
                     <tr><td>July</td><td>'.$month[6].'</td></tr>
                     <tr><td>Aug</td><td>'.$month[7].'</td></tr>
                     <tr><td>September</td><td>'.$month[8].'</td></tr>
                     <tr><td>October</td><td>'.$month[9].'</td></tr>
                     <tr><td>November</td><td>'.$month[10].'</td></tr>
                     <tr><td>December</td><td>'.$month[11].'</td></tr></table>';


                //Preferred Products by name CHART

                $preferredproduct = array();

                $sql = "SELECT id FROM transactions WHERE userid = '$userid'";
                $result = mysqli_query($conn,$sql); 

                
                if(mysqli_num_rows($result) > 0)
                {
                    //Loop transactions TABLE
                    while($row = mysqli_fetch_assoc($result))
                    {
                        
                        $transid = $row['id'];echo $transid .'<br>';
                        $sql_2 = "SELECT product_name, quantity FROM transactions_details WHERE trans_id = '$transid'";
                        $result_2 = mysqli_query($conn,$sql_2);

                        if(mysqli_num_rows($result_2) > 0)
                        {
                            //Loop transactions detail TABLE
                            while($row_2 = mysqli_fetch_assoc($result_2))
                            {
                                $Found_sameItem = false; 
                                
                                $current_productName = $row_2['product_name'];
                                $current_productQuantity = $row_2['quantity'];

                                //Loop array
                                $array_count = 0;
                                foreach ($preferredproduct as $array)
                                {
                                    if($array['productName'] === $current_productName) //Found the same item in array
                                    {
                                        $array['productCount'] = $array['productCount'] + $current_productQuantity; //Total up the quantity
                                        $preferredproduct[$array_count] = $array;
                                        
                                        $Found_sameItem = true; 
                                        break; //Stop the loop when found
                                    }
                                    $array_count ++;
                                }

                                if($Found_sameItem === false) //Not able to find the same item in array
                                {
                                    //Add new array element
                                    array_push($preferredproduct, array("productName" => $current_productName, "productCount" => $current_productQuantity));   
                                }

                            }//End Loop transactions detail TABLE
                        }

                    }//End Loop transactions TABLE
                }

                //SORT
                //Retrieve the column quantity
                $column_quantity = array_column($preferredproduct, 'productCount');
                //Sort the whole array by quantity in descending order
                array_multisort($column_quantity, SORT_DESC, $preferredproduct);

                $prefer_name = array();
                $prefer_quantity = array();

                $i = 0;
                foreach ($preferredproduct as $value)
                {
                    $prefer_quantity[$i] = $value['productCount'];
                    $prefer_name[$i] = $value['productName'];
                    $i++;
                }

                //CHART
                echo '<br><table>
                     <tr><td>ProductName</td><td>Quantity</td></tr>
                     <tr><td>'.$prefer_name[0].'</td><td>'.$prefer_quantity[0].'</td></tr>
                     <tr><td>'.$prefer_name[1].'</td><td>'.$prefer_quantity[1].'</td></tr>
                     <tr><td>'.$prefer_name[2].'</td><td>'.$prefer_quantity[2].'</td></tr>
                     </table>';

                     

            ?>


            <!--Transaction History-->

            <p>Transaction History</p>
            <p>Please allow POP UP window!</p>

            <?php
                $sql = "SELECT id, _date, _time, grand_total FROM transactions WHERE userid = '$userid'";
                $isFound = mysqli_query($conn,$sql); 

                if(mysqli_num_rows($isFound) > 0)
                {
                    while($row = mysqli_fetch_assoc($isFound))
                    {
                        //The list is a button that generate the receipt
                        echo '<a href="receipt.php?receipt='.$row['id'].'&check=false" target="_blank">';
                        echo "Transaction ID: " .$row['id'].
                             " Date: ".$row['_date']." ".$row['_time']."... Order Total: ".$row['grand_total'].
                             '</br></a>';
                    }
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