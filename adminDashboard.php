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
    <header class="HeaderHeader" id="Push_header">
        <a href="adminDashboard.php"> <img class="logo" src="Pictures/LOGO.jpeg" alt="Pacific Northwest X-Ray Inc."> </a>
        
        <div class="header_login">
            Admin Dashboard
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
        <h1>Summary of Transaction Records</h1>
        <hr>
    </div>

    <table class="demTable">
		<thead>
			<tr>
				<th>Payment ID</th>
				<th>Header 1</th>
				<th>Header 2</th>
				<th>Header 3</th>
				<th>Header 4</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</tbody>
    </table>
    <br>

    <!-- For inserting new data -->
    <section class="padCard">
        <h1>Insert Data</h1>
        <p>*Insert Form Here</p>
        <br>

    </section>

    <!-- For deleting existing data -->
    <section class="padCard">
        <h1>Delete Data</h1>
        <p>*Insert Form Here</p>
        <br>
        
    </section>

    <!-- For updating exsting data -->
    <section class="padCard">
        <h1>Update Data</h1>
        <p>*Insert Form Here</p>
        <br>
        
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