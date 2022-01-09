<?php session_start() ?>

<!DOCTYPE html>
<html>
    <head>
        <title>My Dashboard - PNWX</title>
        <meta charset="UTF-8">
        <link rel="icon" href="Pictures/icon.png">
        <link rel="shortcut icon" href="Pictures/icon.png">
        <link rel="stylesheet" href="CSS/dashboard.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"
        integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" 
        crossorigin="anonymous" 
        referrerpolicy="no-referrer"></script>
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
                <img class="image_login_register" src="Pictures/login_register_icon.png" alt="Login and register icon" style="height:30px; width:50px;margin-right:-14px">
            </span>
        </header>

        <main>
            <!--CHART-->
            <?php
                //Initialise array
                $month = array(0,0,0,0,0,0,0,0,0,0,0,0);
                $m2 = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

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
                /*
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
                     */

                     //Preferred Products by name CHART

                $preferredproduct = array();

                $sql = "SELECT id FROM transactions WHERE userid = '$userid'";
                $result = mysqli_query($conn,$sql); 

                
                if(mysqli_num_rows($result) > 0)
                {
                    //Loop transactions TABLE
                    while($row = mysqli_fetch_assoc($result))
                    {
                        
                        $transid = $row['id'];
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
                    if($i === 3)
                    {
                        break;
                    }
                    $prefer_quantity[$i] = $value['productCount'];
                    $prefer_name[$i] = $value['productName'];
                    $i++;
                }

                //CHART
                /*
                echo '<br><table>
                     <tr><td>ProductName</td><td>Quantity</td></tr>
                     <tr><td>'.$prefer_name[0].'</td><td>'.$prefer_quantity[0].'</td></tr>
                     <tr><td>'.$prefer_name[1].'</td><td>'.$prefer_quantity[1].'</td></tr>
                     <tr><td>'.$prefer_name[2].'</td><td>'.$prefer_quantity[2].'</td></tr>
                     <tr><td>'.$prefer_name[3].'</td><td>'.$prefer_quantity[3].'</td></tr>
                     <tr><td>'.$prefer_name[4].'</td><td>'.$prefer_quantity[4].'</td></tr>
                     <tr><td>'.$prefer_name[5].'</td><td>'.$prefer_quantity[5].'</td></tr>
                     <tr><td>'.$prefer_name[6].'</td><td>'.$prefer_quantity[6].'</td></tr>
                     <tr><td>'.$prefer_name[7].'</td><td>'.$prefer_quantity[7].'</td></tr>
                     </table>';
                     */


            ?>


<div class="row">
  <div class="leftcol">
    <!--Number of Transactions in a year by month CHART -->
    <div class="barChart-container" align=center>
        <canvas id="barChart" style="width:100%;max-width:700px;max-height:500px"></canvas>
    </div>
    
    <script>
        const labels = <?php echo json_encode($m2) ?>;

        const data = {
        labels: labels,
        datasets: [{
            data: <?php echo json_encode($month) ?>,
            label: 'Months',
            backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(255, 205, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
            '#DE3163',
            '#FF7F50',
            '#FFBF00',
            '#40E0D0',
            '#6495ED',
            '#DA70D6',
            '#808080'
            ],
            borderWidth: 1,
            hoverBorderWidth: 2,
            hoverBorderColor: '#000',
        }]
        };

        const config = {
            type: 'bar',
            data: data,
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Number of Transactions in a Year by Month',
                        font: {
                            size: 26
                        }
                    }
                }
            },
        };

        // Global default chart variables
        Chart.defaults.font.family = 'Maiandra GD';
        Chart.defaults.font.size = 15;

        const barChart = new Chart(
        document.getElementById('barChart').getContext('2d'),
        config
        );

        </script>
    </div>
    <div class="rightcol">
            <!-- Preferred Products by name -->
            <div class="pieChart-container" align=center>
                <canvas id="pieChart" style="width:100%;max-width:500px"></canvas>
            </div>
            
            <script>
                const labelsPie = <?php echo json_encode($prefer_name) ?>;

                const dataPie = {
                labels: labelsPie,
                datasets: [{
                    data: <?php echo json_encode($prefer_quantity) ?>,
                    label: 'Products',
                    backgroundColor: [
                        '#9B3192',
                        '#EA5F89',
                        '#F7B7A3',
                    ],
                    borderColor: [
                        '#FFFFFF',
                        '#FFFFFF',
                        '#FFFFFF',
                    ],
                    borderWidth: 2,
                    hoverBorderWidth: 2,
                    hoverBorderColor: '#000'
                }]
                };

                const configPie = {
                type: 'pie',
                data: dataPie,
                options: {
                    responsive: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: true,
                            text: 'Preferred Products by Name',
                            font: {
                                size: 26
                            }
                        }
                    }
                }
                };

                const pieChart = new Chart(
                document.getElementById('pieChart').getContext('2d'),
                configPie
                );

            </script>

            <?php
                if(!isset($prefer_quantity[0]))
                {
                    echo '<p class="no_result_pie">'."No Results!".'</p>';
                }
            ?>

  </div>
</div>

            <!--Transaction History-->
            <hr>
            <h2 style="text-align:center; font-weight: bold; font-size: 30px;">Transaction History</h2>

            <?php
                $sql = "SELECT id, _date, _time, grand_total FROM transactions WHERE userid = '$userid'";
                $isFound = mysqli_query($conn,$sql); 

                if(mysqli_num_rows($isFound) > 0)
                {
                    echo '<br><br>';
                    while($row = mysqli_fetch_assoc($isFound))
                    {
                        //The list is a button that generate the receipt
                        echo '<table>';
                        echo '<tr><td><a href="receipt.php?receipt='.$row['id'].'&check=false" target="_blank">';
                        echo "Transaction ID:".'&nbsp' .$row['id'].'&nbsp&nbsp'.
                             " Date:".'&nbsp'.$row['_date']." ".$row['_time']."...".'&nbsp&nbsp'."Order Total:".'&nbsp'.$row['grand_total'].
                             '</a></td></tr></table>';
                    }
                    echo '<div class="empty_btm"></div>';
                }
                else //mysqli_num_rows($isFound) = 0
                {
                    echo '<p class="no_trans">'."No Transactions being Made Yet!".'</p>';
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