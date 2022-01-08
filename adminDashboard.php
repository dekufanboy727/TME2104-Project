<?php session_start(); ob_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Pictures/icon.png">
    <link rel="shortcut icon" href="Pictures/icon.png">
    <link rel="stylesheet" href="CSS/admin.css">
    <link rel="shortcut icon" href="Pictures/icon.png">
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"
     integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" 
     crossorigin="anonymous" 
     referrerpolicy="no-referrer">
    </script>
    
    <script src="clock.js" defer></script>

    <title>Admin Dashboard - PNWX</title>
</head>

<body>
    <?php
        include 'adminconfig.php';

        date_default_timezone_set("Asia/Kuching");

        $id = $email = $name = $sum_err = "";

        if(!isset($_SESSION['admin_id'])){
            header('Location: adminlogin.php');
            ob_end_flush();
        }

        $id = $_SESSION['admin_id'];
        $email = $_SESSION['admin_email'];

        $sql = "SELECT username FROM admins WHERE ID='$id'"; //Select the user id
        $isFound = mysqli_query($conn,$sql); //Check is it exists

        if (mysqli_num_rows($isFound) > 0){
            $result = mysqli_fetch_assoc($isFound);
            $name = $result['username'];
        }else{
            //echo "no results";
        }
        
        function test($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        //Create Table Users
        $sql = "CREATE TABLE registered_User (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            email VARCHAR(50) NOT NULL,
            region int(5) NOT NULL,
            phone INT(10) NOT NULL,
            pwd VARCHAR(30) NOT NULL,
            gender CHAR(30) NOT NULL,
            _state CHAR(30) NOT NULL,
            postcode INT(10) NOT NULL,
            _address VARCHAR(255) NOT NULL,
            city CHAR(30) NOT NULL,
            _login CHAR(30) NOT NULL
            )";

        //Inserting Preset Users For Functions to Work
        if ($conn->query($sql) === TRUE) {
            //echo "Table MyGuests created successfully";

            $sql = " INSERT INTO registered_user (id, firstname, lastname, email, region, phone, pwd, gender, _state, postcode, _address, city, _login) VALUES
            (1, 'Jerry', 'Mander', 'JM1@gmail.com', 60, 1910001000, 'Cc123@', 'Male', 'Selangor', 53110, '3, Jalan Terringgi 3/5 C,', 'Kuala Lumpur', 'Logged Out'),
            (2, 'Holly', 'Maddson', 'HM2@gmail.com', 60, 1110001000, 'Aa123@', 'Female', 'Penang', 37701, '2, Jalan Ferringgi 5/7B', 'GeorgeTown', 'Logged Out'),
            (3, 'Barry', 'Halselhoff', 'BH3@gmail.com', 60, 1320001000, 'Bb123@', 'Male', 'Selangor', 48000, '4, Jalan University,', 'Petaling Jaya', 'Logged Out'),
            (4, 'Darrel', 'Wong', 'DW4@gmail.com', 60, 1420001000, 'Bb123@', 'Male', 'Sarawak', 93000, '6, Jalan Rodway,', 'Kuching', 'Logged Out'),
            (5, 'Siti', 'Ahmad', 'MA5@gmail.com', 60, 1530002000, 'Bb123@', 'Female', 'Pahang', 27600, '7, Jalan Lipis,', 'Raub', 'Logged Out');";

            $result = mysqli_query($conn, $sql);
            if ($result === TRUE) {
                //echo "New record created successfully";
            } else {
                //echo "Error: " .  mysqli_error($conn);
            }
        } else {
            //echo "Error creating table: " . $conn->error;
        }

        //product
        //Create Table Products
        $sql = "CREATE TABLE product (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            productcategory VARCHAR(255) NOT NULL,
            productname VARCHAR(255) NOT NULL,
            productdetail VARCHAR(255) NOT NULL,
            price int(11) NOT NULL,
            productpic BLOB (255) NOT NULL,
            productpicadd VARCHAR(255) NOT NULL
            )";
    
            $result = mysqli_query($conn, $sql);
            if ($result === TRUE) {
              //echo "Table u created successfully or Table exists".'<br>';
              
              //setup array for dummy products
              $productcategory = array("Merchant Board ", "Merchant Board ", "Silver Recovery Systems ", "Silver Recovery Systems ", "Veterinary ", "Veterinary ", 
              "X Ray Test Meters ", "X Ray Test Meters ");
    
              $productname = array("Pacific Northway X-Ray Merchant Board for DR Panels", "PNWX Light Duty Merchant Board for Film Cassettes", 
              "Steel Wool Recovery Canisters and Accessories", "Rotex Standard Ultra Series Silver Recovery Systems", "Techno Aide Veterinary Immobilizers", 
              "Techno Aide Veterinary Positioner", "ECC Series 820 kVp Meters", "Series 815 kVp Meters");
    
              $productdetail = array("Model: 1104-C3a, box style merchant board with arms to accommodate DR Panels up to 1-1/4 thick.", 
              "Model: 1104, constructed of solid oak, adjustable tabletops ,compatible with CR.", 
              "Model: C4 Steel Wool Canister; Size: 3-1/2 gallon; Steel Wool Type: Coarse", "Model: Ultra 4; Max Recovery Rate: 0.5oz/hr Tank Capacity: 2.75 gal; Electrical Requirements: 115VAC/60Hz", 
              "Type:  Immobilizers; Model: VIT X; Size: X Large; Dimension: 36 x 14 x 9 feet high.",
              "Type:  Positioner; Model: YFCA Positioner; Size: Small; Dimensions: 7 x 12.5 x 3.", "Model: 820; X-Ray kVp Meter/Exposure; Time Meter/mA Meter/mAs; kVp Range: 45 to 125.",
              "Model: 815L;Lower kV Range Version of the 815 Meter(40 to 120kVp);For dental applications.");
    
              $price = array("1968", "770", "215", "2412", "170", "33", "2279", "1700");
    
              $productpicadd = array("itempic/item1.jpg", "itempic/item2.jpg", "itempic/item3.jpg", "itempic/item4.jpg", "itempic/item5.jpg", "itempic/item6.jpg", "itempic/item7.jpg", 
              "itempic/item8.jpg");
    
              $productpic = array("presetpic/item1.jpg", "presetpic/item2.jpg", "presetpic/item3.jpg", "presetpic/item4.jpg", "presetpic/item5.jpg", "presetpic/item6.jpg", "presetpic/item7.jpg", 
              "presetpic/item8.jpg");
              
              $index = 0;
              foreach($productcategory as $value){
                $sql = "INSERT INTO product(productcategory, productname, productdetail, price, productpic, productpicadd) 
                VALUES ('$value','$productname[$index]', '$productdetail[$index]', '$price[$index]', '$productpic[$index]', '$productpicadd[$index]')";
                $result = mysqli_query($conn, $sql);
                if ($result === TRUE) {
                  //echo "New record created successfully";
                } else {
                  //echo "Error: " . $sql  . mysqli_error($conn);
                }
                $index++;
              }
              
            } else {
              //echo "Error creating table: " . mysqli_error($conn);
            }
    

        //Create Transactions TABLE
        $sql = "CREATE TABLE transactions (
            id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            userid int(15) UNSIGNED NOT NULL,
            _date date NOT NULL,
            _time time NOT NULL,
            shipping_fee double(15,2) NOT NULL,
            merchandise_total double(15,2) NOT NULL,
            grand_total double(15,2) NOT NULL,
            is_preset tinyint(1) NOT NULL DEFAULT 0,
            FOREIGN KEY (userid) REFERENCES registered_user (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
          )";
        
        $result = mysqli_query($conn, $sql);
        if ($result == TRUE){
            //echo "Table Transactions Created Successfully".'<br>';

            //Insert Dummy Transactions for testing purpose 
            $sql = "INSERT INTO transactions (id, userid, _date, _time, shipping_fee, merchandise_total, grand_total, is_preset) VALUES
            (1, 1, '2021-12-28', '12:55:45', 100.50, 8239.00, 8339.50, 1),
            (2, 2, '2021-12-29', '08:10:05', 55.50, 340.00, 395.50, 1),
            (3, 3, '2021-12-28', '10:20:11', 340.50, 9212.00, 9552.50, 1),
            (4, 4, '2022-12-08', '15:49:59', 55.50, 3936.00, 3991.5, 1),
            (5, 5, '2022-12-08', '21:13:12', 210.50, 4950.00, 5160.5, 1)";

            $result = mysqli_query($conn, $sql);
            if ($result === TRUE) {
                //echo "New record created successfully";
            } else {
                //echo "Error: " .  mysqli_error($conn);
            }

        }else{
            //echo "Error creating table: " . $conn->error;
        }

        //Create transactions_details TABLE
        $sql = "CREATE TABLE transactions_details (
            trans_id int(11) UNSIGNED NOT NULL, 
            product_id int(30) NOT NULL,
            quantity int(15) NOT NULL,
            total_price double(15,2) NOT NULL,
            PRIMARY KEY (trans_id, product_id, quantity, total_price),
            FOREIGN KEY (trans_id) REFERENCES transactions (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
            )";

        $result = mysqli_query($conn, $sql);
        if ($result === TRUE){
            //echo "Table Transaction Details Created Successfully".'<br>';

            //Insert Dummy Transactions details for testing purpose 
            $sql = "INSERT INTO transactions_details (trans_id, product_id, quantity, total_price) VALUES
            (1, 3, 4, 860.00),
            (1, 7, 1, 2279.00),
            (1, 8, 3, 5100.00),
            (2, 5, 2, 340.00),
            (3, 4, 1, 2412.00),
            (3, 5, 40, 6800.00),
            (4, 1, 2, 3936.00),
            (5, 2, 6, 4620.00),
            (5, 6, 10, 330.00);";

            
            $result = mysqli_query($conn, $sql);
            if ($result === TRUE) {
                //echo "New record created successfully";
            } else {
                //echo "Error: " .  mysqli_error($conn);
            }

        }else{
            //echo "Error creating table: "  $conn->error;
        }

        //Transaction Report Request Handling

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $sum_option = test($_POST["rep_selection"]);
            $date = $_POST["search_date"];

            //Filtering Based on Options
            if ($sum_option === "daily"){
                $date1 = date( 'd' ,strtotime($date));
                $date2 = date('m', strtotime($date));
                $date3 = date('Y', strtotime($date));
                $sql = "SELECT id, userid, _date,  _time, shipping_fee, merchandise_total, grand_total FROM transactions WHERE DAY(_date) = '$date1' AND MONTH(_date) = '$date2' 
                AND YEAR(_date) = '$date3'";

                $result = mysqli_query($conn, $sql);

            }else if ($sum_option === "weekly"){
                $date1 = date( 'W' ,strtotime($date));
                $date2 = date( 'Y' ,strtotime($date));
                $sql = "SELECT id, userid, _date,  _time, shipping_fee, merchandise_total, grand_total FROM transactions WHERE WEEK(_date) = '$date1' AND YEAR(_date) = '$date2'";
                $result = mysqli_query($conn, $sql);

            }else if ($sum_option === "monthly"){
                $date1 = date( 'm' ,strtotime($date));
                $date2 = date( 'Y' ,strtotime($date));
                $sql = "SELECT id, userid, _date,  _time, shipping_fee, merchandise_total, grand_total FROM transactions WHERE MONTH(_date) = '$date1' AND YEAR(_date) = '$date2'";
                $result = mysqli_query($conn, $sql);

            }else{
                $sum_err = "Please Select Something";
            }
        }
    ?>
    <header class="HeaderHeader" id="Push_header">
        <a href="adminDashboard.php"> <img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc."> </a>
        
        <div class="header_login">
            Admin Dashboard
        </div>

        <div class="login_register">
            <ul> 
                <li><a href="adminlogout.php">Log Out</a></li>
                <li>&nbsp|</li>
                <li><a href=""><?php echo $name ?></a></li>
                <li><img class="image_login_register" src="Pictures/login_register_icon.png" alt="Login and register icon"></a>
            </ul>
        </div>
    
    </header>

    <div class="admin-title">
        <h1>Welcome Back!</h1>
        <hr>
    </div>

    <div class="admin-row">
        <div class="admin-container">
            <div class="wrapper">
                <div class="link_wrapper">
                    <a href="adminEditCustomer.php">Edit Customer Information</a>
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 268.832 268.832">
                        <path d="M265.17 125.577l-80-80c-4.88-4.88-12.796-4.88-17.677 0-4.882 4.882-4.882 12.796 0 17.678l58.66 58.66H12.5c-6.903 0-12.5 5.598-12.5 12.5 0 6.903 5.597 12.5 12.5 12.5h213.654l-58.66 58.662c-4.88 4.882-4.88 12.796 0 17.678 2.44 2.44 5.64 3.66 8.84 3.66s6.398-1.22 8.84-3.66l79.997-80c4.883-4.882 4.883-12.796 0-17.678z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="admin-container">
            <div class="wrapper">
                <div class="link_wrapper">
                    <a href="adminEditProduct.php">Edit Product Information</a>
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 268.832 268.832">
                        <path d="M265.17 125.577l-80-80c-4.88-4.88-12.796-4.88-17.677 0-4.882 4.882-4.882 12.796 0 17.678l58.66 58.66H12.5c-6.903 0-12.5 5.598-12.5 12.5 0 6.903 5.597 12.5 12.5 12.5h213.654l-58.66 58.662c-4.88 4.882-4.88 12.796 0 17.678 2.44 2.44 5.64 3.66 8.84 3.66s6.398-1.22 8.84-3.66l79.997-80c4.883-4.882 4.883-12.796 0-17.678z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clock-box">
        <div class="clock">HH : MM : SS</div>
        <div class="date">DD - MM - YYYY</div>
    </div>
    
    <div class="admin-title">
        <h1>Summary of Transaction Records</h1>
        <hr>
    </div>
    
    <div class="summaryRow">
        <div class="summaryColumn">
            <div class="SumTitle">
                <h3 class="section-header">Recent Buyers and States</h3>
                <hr class="section-header-hr">
            </div>
            <?php
                $sql_sum = "SELECT userid FROM transactions ORDER BY _date DESC LIMIT 5";
                $sum_result = mysqli_query($conn,$sql_sum);

                //Getting Specific Values from the Tables
                if(mysqli_num_rows($sum_result) > 0){
                    echo "<table class='displayTable'>";
                    echo "<tr><th>No</th><th>UserID</th><th>Username</th><th>State</th></tr>";
                    $key = 1;
                    while($sum_row = mysqli_fetch_assoc($sum_result)){
                        $temp_id = $sum_row["userid"];
                        $sql_name = "SELECT firstname, lastname, _state FROM registered_user WHERE id = '$temp_id'";
                        $sum_result2 = mysqli_query($conn, $sql_name);
                        $temp_name = mysqli_fetch_assoc($sum_result2);
                        echo "<tr><td>".$key."</td><td>".$sum_row["userid"]."</td><td>".$temp_name["firstname"]." ".$temp_name["lastname"]."</td><td>".$temp_name["_state"]."</td></tr>";
                        $key++;
                    }
                    echo "</table>";
                }else{
                    echo "<br>";
                    echo "<p class='noresults'> No Results </p>";
                }
            ?>
        </div>
        <div class="summaryColumn">
            <div class="SumTitle">
                <h3 class="section-header">Transactions based on States</h3>
                <hr class="section-header-hr">
            </div>
            <?php
                $sql_sum = "SELECT _state,  COUNT(transactions.id) AS custotal 
                            FROM registered_user 
                            INNER JOIN transactions 
                            ON registered_user.id = transactions.userid 
                            GROUP BY _state
                            ORDER BY custotal DESC
                            LIMIT 5";
                $sum_result = mysqli_query($conn,$sql_sum);

                //Getting Specific Values from the Tables
                if(mysqli_num_rows($sum_result) > 0){
                    echo "<table class='displayTable'>";
                    echo "<tr><th>No</th><th>State</th><th>Number</th></tr>";
                    $key = 1;
                    while($sum_row = mysqli_fetch_assoc($sum_result)){
                        echo "<tr><td>".$key."</td><td>".$sum_row["_state"]."</td><td>".$sum_row["custotal"]."</td></tr>";
                        $key++;
                    }
                    echo "</table>";
                }else{
                    echo "<br>";
                    echo "<p class='noresults'> No Results </p>";
                }
                
                // Chart for Transaction Record
                foreach($sum_result as $data)
                {
                    $state[] = $data['_state'];
                    $custotal[] = $data['custotal'];
                }
            ?>

            <!-- Chart for Transaction Record -->
            <div class="barChart-container">
                <canvas id="barChart"></canvas>
            </div>
            
            <script>
                const labels = <?php echo json_encode($state) ?>;

                const data = {
                labels: labels,
                datasets: [{
                    data: <?php echo json_encode($custotal) ?>,
                    label: 'Number of Transactions',
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.4)',
                    'rgba(255, 159, 64, 0.4)',
                    'rgba(75, 192, 192, 0.4)',
                    'rgba(54, 162, 235, 0.4)',
                    'rgba(201, 203, 207, 0.4)'
                    ],
                    borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(201, 203, 207)'
                    ],
                    barThickness: 135,
                    borderWidth: 1,
                    borderColor: '#777',
                    hoverBorderWidth: 2,
                    hoverBorderColor: '#000',
                }]
                };

                const config = {
                    type: 'bar',
                    data: data,
                        options: {
                            responsive: true,
                            plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Number of Transactions based on States',
                                font: {
                                    size: 26
                                }
                            }
                        }
                    },
                };

                // Global default chart variables
                Chart.defaults.font.family = 'Georgia';
                Chart.defaults.font.size = 14;

                const barChart = new Chart(
                document.getElementById('barChart').getContext('2d'),
                config
                );

            </script>
        </div>
    </div>

    <div class="summaryRow">
        <div class="summaryColumn">
            <div class="SumTitle">
                <h3 class="section-header">Today's Transactions</h3>
                <hr class="section-header-hr">
            </div>
            <?php
                $dated1 = date('d' ,strtotime("now"));
                $dated2 = date('m', strtotime("now"));
                $dated3 = date('Y', strtotime("now"));

                $datedsql = "SELECT id, userid, _date,  _time, shipping_fee, merchandise_total, grand_total 
                        FROM transactions WHERE DAY(_date) = '$dated1' 
                        AND MONTH(_date) = '$dated2' 
                        AND YEAR(_date) = '$dated3'
                        ORDER BY _time DESC
                        LIMIT 5";

                $datedresult = mysqli_query($conn, $datedsql);

                //Getting Specific Values from the Tables
                if(mysqli_num_rows($datedresult) > 0){
                    echo "<table class='displayTable'>";
                    echo "<tr><th>ID</th><th>UserID</th><th>Date</th><th>Time</th><th>Subtotal</th><th>Shipping Fee</th><th>Total</th></tr>";
                    while($row = mysqli_fetch_assoc($datedresult)){
                        $temp_id = $row["userid"];
                        $sql_name = "SELECT firstname, lastname FROM registered_user WHERE id = '$temp_id'";
                        $datedresult2 = mysqli_query($conn, $sql_name);
                        $temp_name = mysqli_fetch_assoc($datedresult2);
                        echo "<tr><td>".$row["id"]."</td><td>".$row["userid"].":".$temp_name["firstname"]." ".$temp_name["lastname"]."</td><td>".$row["_date"]."</td><td>".
                        $row["_time"]."</td><td>"."$".$row["merchandise_total"]."</td><td>"."$".$row["shipping_fee"]."</td><td>"."$".$row["grand_total"]."</td></tr>";
                    }
                    echo "</table>";
                }else{
                    echo "<br>";
                    echo "<p class='noresults'> No Results </p>";
                }
            ?>
        </div>
        <div class="summaryColumn">
            <div class="SumTitle">
                <h3 class="section-header">Hottest Products</h3>
                <hr class="section-header-hr">
            </div>
            <?php
                //Sql Query Declarations
                $sql_sum = "SELECT product.id AS prodID, productname, productcategory, transactions_details.quantity AS custotal
                            FROM product
                            INNER JOIN transactions_details
                            ON product.id = transactions_details.product_id
                            GROUP BY productname
                            ORDER BY custotal DESC
                            LIMIT 5";

                $sql_count = "SELECT product.id AS prodID, transactions_details.quantity AS custotal
                            FROM product
                            INNER JOIN transactions_details
                            ON product.id = transactions_details.product_id";

                echo mysqli_error($conn)."<br>";
                $sum_result = mysqli_query($conn,$sql_sum);
                $temp_array = [];

                //Getting Specific Values from the Tables
                if(mysqli_num_rows($sum_result) > 0){
                    echo "<table class='displayTable'>";
                    echo "<tr><th>No</th><th>Product</th><th>Category</th><th>Quantity Sold</th></tr>";
                    $key = 1;

                    //Filtering Products Individually
                    while($sum_row = mysqli_fetch_assoc($sum_result)){
                        $count_result = mysqli_query($conn, $sql_count);
                        $product_quantity = 0;

                        //Totalling up Quantity
                        while($counts = mysqli_fetch_assoc($count_result)){
                            if($sum_row["prodID"] === $counts["prodID"]){
                                $product_quantity += $counts["custotal"];
                            }
                        }
                        
                        //Storing values into temporary array for sorting
                        $temp_array[] = array('name' => $sum_row["productname"], 'category' => $sum_row["productcategory"], 'quantity'=>$product_quantity);
                    }

                    //For Sorting the temp array
                    function cmp($a, $b)
                    {
                        if ($a['quantity'] == $b['quantity']) {
                            return 0;
                        }
                        return ($a['quantity'] > $b['quantity']) ? -1 : 1;
                    }

                    usort($temp_array,"cmp");

                    //To Display the temp-array's Output
                    foreach($temp_array as $row){
                        echo "<tr><td>".$key."</td><td>".$row['name']."</td><td>".$row['category']."</td><td>".$row['quantity']."</td></tr>";
                        $key++;
                    }

                    echo "</table>";
                }else{
                    echo "<br>";
                    echo "<p class='noresults'> No Results </p>";
                }

                foreach($temp_array as $data)
                {
                    $productname[] = $data['name'];
                    $salestotal[] = $data['quantity'];
                };
            ?>

            <!-- Pie Chart for Hottest Products -->
            <div class="pieChart-container">
                <canvas id="pieChart"></canvas>
            </div>
            
            <script>
                const labelsPie = <?php echo json_encode($productname) ?>;

                const dataPie = {
                labels: labelsPie,
                datasets: [{
                    data: <?php echo json_encode($salestotal) ?>,
                    label: 'Hottest Products',
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.4)',
                    'rgba(255, 159, 64, 0.4)',
                    'rgba(75, 192, 192, 0.4)',
                    'rgba(54, 162, 235, 0.4)',
                    'rgba(20, 75, 207, 0.4)'
                    ],
                    borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(20, 75, 207)'
                    ],
                    borderWidth: 1,
                    borderColor: '#777',
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
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Number of quantities sold per products',
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
        </div>
    </div>

    <section class="report">
        <h1>Report of Transaction Records</h1>
        <hr>
        <div class="reptoppart" >
            <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <input type="date" class="sum_button" name="search_date"></input>
                <div class="rep_select">
                    <select name="rep_selection" id="sum_select">
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>
                <input type="submit" class="rep_button"></input>
            </form>
            <span class= "error"> <?php echo $sum_err ?></span>
        </div>
        <br><br>
        <div class="repbotpart">
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    if(mysqli_num_rows($result) > 0){
                        echo "<table class='displayTable'>";
                        echo "<tr><th>ID</th><th>UserID</th><th>Date</th><th>Time</th><th>Subtotal</th><th>Shipping Fee</th><th>Total</th></tr>";
                        while($row = mysqli_fetch_assoc($result)){
                            $temp_id = $row["userid"];
                            $sql_name = "SELECT firstname, lastname FROM registered_user WHERE id = '$temp_id'";
                            $result2 = mysqli_query($conn, $sql_name);
                            $temp_name = mysqli_fetch_assoc($result2);
                            echo "<tr><td>".$row["id"]."</td><td>".$row["userid"].":".$temp_name["firstname"]." ".$temp_name["lastname"]."</td><td>".$row["_date"]."</td><td>".
                            $row["_time"]."</td><td>"."$".$row["merchandise_total"]."</td><td>"."$".$row["shipping_fee"]."</td><td>"."$".$row["grand_total"]."</td></tr>";
                        }
                        echo "</table>";
                    }else{
                        echo "<br>";
                        echo "<p class='noresults'> No Results </p>";
                        //echo mysqli_error($conn);
                    }
                }else{
                    echo "<br>";
                    echo "<p class='noresults'> No Results </p>";
                    //echo mysqli_error($conn);
                }
                mysqli_close($conn);
            ?>
        </div>
    </section>

    <!-- Calling Scroll Animation -->
    <script src='scrollAnimation.js' defer></script>

    <footer class="FooterFooter" id="Push_footer">
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