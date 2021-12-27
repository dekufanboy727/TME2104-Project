<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/admin.css">
    <script src="https://unpkg.com/scrollreveal@4"></script>
    <title>Admin Dashboard - PNWX</title>
</head>
<body>
    <?php
        include 'adminconfig.php';

        date_default_timezone_set("Asia/Kuching");

        $id = $email = $name = $sum_err = "";

        $id = $_SESSION['admin_id'];
        $email = $_SESSION['email'];

        $sql = "SELECT username FROM admins WHERE ID='$id'"; //Select the user id
        $isFound = mysqli_query($conn,$sql); //Check is it exists

        if (mysqli_num_rows($isFound) > 0){
            $result = mysqli_fetch_assoc($isFound);
            $name = $result['username'];
        }else{
            echo "no results";
        }
        
        function test($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

         //Create Dummy Transactions and Transaction Details
         $sql = "CREATE TABLE transactions (
            id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            userid int(15) NOT NULL,
            _date date NOT NULL,
            total double(15,2) NOT NULL,
            is_preset tinyint(1) NOT NULL DEFAULT 0
          );";

        if (mysqli_query($conn, $sql) == TRUE){
            echo "Table Transactions Created Successfully".'<br>';

            $sql = "INSERT INTO `transactions` (`id`, `userid`, `_date`, `total`, `is_preset`) VALUES
            (1, 1, '2021-12-28', 8239.00, 1),
            (2, 2, '2021-12-29', 340.00, 1),
            (3, 3, '2021-12-28', 9212.50, 1),
            (4, 4, '2022-12-08', 3936.00, 1),
            (5, 5, '2022-12-08', 4950.00, 1);";

            if (mysqli_query($conn, $sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " .  mysqli_error($conn);
            }

        }else{
            echo "Error creating table: " . $conn->error;
        }

        $sql = "CREATE TABLE transactions_details (
            trans_id int(15) UNSIGNED NOT NULL, 
            product_id int(30) NOT NULL,
            quantity int(15) NOT NULL,
            total_price double(15,2) NOT NULL,
            PRIMARY KEY (trans_id, product_id, quantity, total_price),
            FOREIGN KEY (trans_id) REFERENCES transactions (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
            )";

        if (mysqli_query($conn, $sql) == TRUE){
            echo "Table Transaction Details Created Successfully".'<br>';

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

            if (mysqli_query($conn, $sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " .  mysqli_error($conn);
            }

        }else{
            echo "Error creating table: " . $conn->error;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $sum_option = test($_POST["summary_selection"]);
            $date = $_POST["search_date"];

            if ($sum_option === "daily"){
                $date1 = date( 'd' ,strtotime($date));
                $date2 = date('m', strtotime($date));
                $date3 = date('Y', strtotime($date));
                $sql = "SELECT id, userid, _date, total FROM transactions WHERE DAY(_date) = '$date1' AND MONTH(_date) = '$date2' 
                AND YEAR(_date) = '$date3'";

                $result = mysqli_query($conn, $sql);

            }else if ($sum_option === "weekly"){
                $date1 = date( 'W' ,strtotime($date));
                $date2 = date( 'Y' ,strtotime($date));
                $sql = "SELECT id, userid, _date, total FROM transactions WHERE WEEK(_date) = '$date1' AND YEAR(_date) = '$date2'";
                $result = mysqli_query($conn, $sql);

            }else if ($sum_option === "monthly"){
                $date1 = date( 'm' ,strtotime($date));
                $date2 = date( 'Y' ,strtotime($date));
                $sql = "SELECT id, userid, _date, total FROM transactions WHERE MONTH(_date) = '$date1' AND YEAR(_date) = '$date2'";
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

    
    
    
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    <div class="admin-title">
        <h1>Report of Transaction Records</h1>
        <hr>
    </div>


    <section class="summary">
        <div class="sumtoppart" >
            <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <input type="date" class="sum_button" name="search_date"></input>
                <div class="sum_select">
                    <select name="summary_selection" id="sum_select">
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>
                <input type="submit" class="sum_button" value ="show"></input>
            </form>
            <span class= "error"> <?php echo $sum_err ?></span>
        </div>
        <br><br>
        <div class="sumbotpart">
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    if(mysqli_num_rows($result) > 0){
                        echo "<table class='demTable'>";
                        echo "<tr><th>ID</th><th>UserID</th><th>Date</th><th>Total</th></tr>";
                        while($row = mysqli_fetch_assoc($result)){
                            $temp_id = $row["id"];
                            $sql_name = "SELECT firstname, lastname FROM registered_user WHERE id = '$temp_id'";
                            $result2 = mysqli_query($conn, $sql_name);
                            $temp_name = mysqli_fetch_assoc($result2);
                            echo "<tr><td>".$row["id"]."</td><td>".$row["userid"].":".$temp_name["firstname"]." ".$temp_name["lastname"]."</td><td>".$row["_date"]."</td><td>".
                            "$".$row["total"]."</td></tr>";
                        }
                        echo "</table>";
                    }else{
                        echo "<br>";
                        echo "<p class='noresults'> No Results </p>";
                    }
                }else{
                    echo "<br>";
                    echo "<p class='noresults'> No Results </p>";
                }
                mysqli_close($conn);
            ?>
        </div>
    </section>


    <!-- For animating elements as they enter/leave the viewport -->
    </div>
        <script src="scrollReveal.js"></script>
    </div>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>

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