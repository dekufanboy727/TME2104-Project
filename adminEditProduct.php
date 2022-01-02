<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/admin.css">
    <script src="https://unpkg.com/scrollreveal@4"></script>
    <title>Admin/Edit Product - PNWX</title>
</head>
<body>
    <?php
        include_once 'adminconfig.php';

        //logic goes here

    ?>

    <header class="HeaderHeader" id="Push_header">
        <a href="adminDashboard.php"> <img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc."> </a>
        
        <div class="header_login">
            Admin
        </div>

        <div class="login_register">
            <ul> 
                <li><a href="adminlogout.php">Log Out</a></li>
                <!-- <li><a href=""><?php echo $name ?></a></li> -->
                <li><img class="image_login_register" src="Pictures/login_register_icon.png" alt="Login and register icon"></a>
            </ul>
        </div>
    </header>

    <div class="admin-title">
        <h1>Edit Product Information</h1>
        <hr>
    </div>

    <table class="demTable">
		<thead>
			<tr>
				<th>Product ID</th>
                <th>Product Picture</th>
                <th>Product Name</th>
				<th>Product Category</th>
				<th>Product Detail</th>
				<th>Product Price</th>
			</tr>
		</thead>
		<tbody>
            <?php
                $table_sql = "SELECT id, productcategory, productname, productdetail, price, productpic
                            FROM product";
                $table_result = mysqli_query($conn, $table_sql);

                if(mysqli_num_rows($table_result) > 0){
                    while($row = mysqli_fetch_assoc($table_result)){
                        echo "<tr><td>"."id: ".$row['id']."</td><td>".'<image src="'.$row['productpic'].'" height ="200" width = "200"/>'."</td><td>".$row['productname']."</td><td>".$row['productcategory']."</td><td>"
                        .$row['productdetail']."</td><td>".$row['price']."</td></tr>";
                    }
                }else{
                    echo "<span class='noresults'>No Transactions Detected</span><br><br>";
                }

            ?>
		</tbody>
	</table>
    <br>

    <!-- For inserting new data -->
    <section class="padCard">
        <h1>Insert Data</h1>
        <p>*Insert Form Here</p>
        <br>

    </section>

    <!-- For deleting exsiting data -->
    <section class="padCard">
        <h1>Delete Data</h1>
        <p>*Insert Form Here</p>
        <br>
        
    </section>

    <!-- For updating existing data -->
    <section class="padCard">
        <h1>Update Data</h1>
        <p>*Insert Form Here</p>
        <br>
        
    </section>

    <!-- For animating elements as they enter/leave the viewport -->
    </div>
        <script src="scrollReveal.js"></script>
    </div>
    
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

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