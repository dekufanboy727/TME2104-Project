<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/adminProduct.css">
    <link rel="icon" href="Pictures/icon.png">
    <link rel="shortcut icon" href="Pictures/icon.png">
    <script src="https://unpkg.com/scrollreveal"></script>

    <title>Admin/Edit Product - PNWX</title>
</head>
<body>
    <?php
        include_once 'adminconfig.php';

        //Value Declarations

        $productid = $productname = $productprice = $productdesc = $productcategory = $productpic = $productpicERR = $createSUC = $deleteMes = "";
        $editstat = FALSE;
        $shownid = 0;

        $productnameERR = $productpriceERR = $productdescERR = "";

        

        //Some Form Validation
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $targetDir = "itempic/";
            $filename = basename($_FILES["productpic"]["name"]);
            $targetFilePath = $targetDir . $filename;
            $imagefileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            $uploadOk = 1;
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');

            if(empty($_POST["productname"])){
                $productnameERR = "You can't leave this space empty!";
            }else{
                $productname = test($_POST["productname"]);
            }

            if(empty($_POST["productprice"])){
                $productpriceERR = "You can't leave this space empty!";
            }else{
                $productprice = test($_POST["productprice"]);

                if(!is_numeric($productprice)){
                    $productpriceERR = "Only Numbers Are Allowed!";
                }else if(strlen($productprice)>10){
                    $productpriceERR = "The Price Can't Exceed 10 digits";
                }
            }
            
            if(empty($_POST["productdesc"])){
                $productdescERR = "You can't leave this space empty!";
            }else{
                $productdesc = test($_POST["productdesc"]);
            }
            
            
            if(empty($_FILES["productpic"])){
                $uploadOk = 0;
                $productpicERR = "Please Select A Picture to Upload";
                
            }else if(file_exists($targetFilePath)){
                $uploadOk = 0;
                $productpicERR = "Your filename already exists";

            }else if(!in_array($imagefileType, $allowTypes)){
                $uploadOk = 0;
                $productpicERR = "Your file is not an image, only JPG, JPEG, PNG and GIF allowed";

            }else if($_FILES["productpic"]["size"] > 500000){
                $uploadOk = 0;
                $productpicERR = "Your file is too large";

            }else if(!move_uploaded_file($_FILES["productpic"]["tmp_name"], $targetFilePath)){
                $uploadOk = 0;
                $productpicERR ="There was an error in uploading your file";
            } 
            
        }

        function test($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        //Create Record
        if(isset($_POST['create'])){
            if($productnameERR == "" && $productdescERR == "" && $productpriceERR == "" && $productpicERR == "" && $productname != "" 
            && $productdesc != "" && $productprice != "" && $uploadOk == 1){

                $productcategory = $_POST["productcategory"];
                //Inserting data into product table
                $sql = "INSERT INTO product (productcategory, productname, productdetail, price, productpic, productpicadd)
                        VALUES ('$productcategory', '$productname', '$productdesc', '$productprice', '$targetFilePath', '$targetFilePath')";

                if(mysqli_query($conn, $sql)){
                    $createSUC = "New Record Added Successfully!";

                    $productid = $productname = $productprice = $productdesc = $productcategory = $productpic = $productpicERR = $createSUC = "";

                    $productnameERR = $productpriceERR = $productdescERR = $targetFilePath = "";
                    
                }else {
                    $createSUC = "Error: Record cannot be added successfully!" /*. $sql . "<br>" . mysqli_error($conn)*/;
                }
            }
        }

        // Delete Record
        if(isset($_GET["delete"])){
            //Gets the id from the superglobal
            $deleteid = $_GET["delete"];
            $deletesql = "SELECT productpicadd FROM product WHERE id = '$deleteid'";
            $deletephoto = mysqli_query($conn,$deletesql);
            $deletephotoresult = mysqli_fetch_assoc($deletephoto);
            unlink($deletephotoresult["productpicadd"]);
            $deletesql = "DELETE FROM product WHERE id = '$deleteid'";
            $deleteresult = mysqli_query($conn, $deletesql);
            if( $deleteresult === TRUE){
                $deleteMes = "Record has been succesfully deleted.";
            }else
            {
                $deleteMes = "Record can't be deleted" /*. mysqli_error($conn)*/;
            }
        }

        // Edit Mode Initiate
        if(isset($_GET["edit"])){
            $editid = $_GET["edit"];
            $editsql = "SELECT * FROM product WHERE id = '$editid'";
            $editresult = mysqli_query($conn, $editsql) or die($mysqli_error($conn));
            if (mysqli_num_rows($editresult) > 0){
                $editstat = TRUE;
                $editrow = mysqli_fetch_assoc($editresult);
                $shownid = $editid;
                $productname = $editrow["productname"];
                $productcategory = $editrow["productcategory"];
                echo $productcategory;
                $productdesc = $editrow["productdetail"];
                $productprice = $editrow["price"];
                $productpic = $editrow["productpic"];

            }else{
                $createSUC = "0 results";
            }

        }

        // To exit out of edit mode
        if(isset($_GET["canceledit"])){
            $editstat = FALSE;
            $productname = "";
            $productcategory = "";
            $productdesc = "";
            $productprice = "";
            $productpic = "";

            $shownid = 0;
        }

        //To Clear Values
        if(isset($_GET["clearvalues"])){
            $productname = "";
            $productcategory = "";
            $productdesc = "";
            $productprice = "";
            $productpic = "";

            $productnameERR = $productpriceERR = $productdescERR = $productpicERR = $createSUC = $deleteMes = "";
            $shownid = 0;
        }

        //Update Logic
        if(isset($_POST["update"])){
            $productcategory = $_POST["productcategory"];
            if($productnameERR == "" && $productdescERR == "" && $productpriceERR == "" && $productname != "" 
            && $productdesc != "" && $productprice != "" ){
                
                $shownid = $_POST['productid'];
                $updatesql = "UPDATE product SET productname = '$productname', productcategory = '$productcategory', productdetail = '$productdesc', 
                            price= '$productprice' WHERE id = '$shownid'";

                if(mysqli_query($conn, $updatesql)){
                    $deleteMes = "Record ".$shownid." Updated";
                }else{
                    $deleteMes = "Update Error";
                }

                if($_POST["uploadphoto"] === "yes"){
                    if(empty($_FILES["productpic"]["name"])){
                        $deleteMes = "No photo detected";
                    }else if ($_FILES['productpic']['error'] == UPLOAD_ERR_NO_FILE){
                        $deleteMes = "No photo detected";
                    }else if(!file_exists($_FILES['productpic']['tmp_name']) || !is_uploaded_file($_FILES['productpic']['tmp_name'])){
                        $deleteMes = "No photo detected";
                    }else
                    {
                        //delete old photo
                        $deleteid = $shownid;
                        $deletesql = "SELECT productpicadd FROM product WHERE id = '$deleteid'";
                        $deletephoto = mysqli_query($conn,$deletesql);
                        $deletephotoresult = mysqli_fetch_assoc($deletephoto);
                        unlink($deletephotoresult["productpicadd"]);

                        //update photo
                        $updatesql = "UPDATE product SET productpic = '$targetFilePath', productpicadd = '$targetFilePath' WHERE id = '$shownid'";
                        if(mysqli_query($conn, $updatesql)){
                            $deleteMes = "Picture ".$shownid." Updated";
                        }else{
                            $deleteMes = "Update Error";
                        }
                        
                    }
                }
            }     
        }
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

    <table class="displayTable">
		<thead>
			<tr>
				<th>Product ID</th>
                <th>Product Picture</th>
                <th>Product Name</th>
				<th>Product Category</th>
				<th>Product Detail</th>
				<th>Product Price</th>
                <th></th>
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
                        .$row['productdetail']."</td><td>".$row['price']."</td><td>";

                        echo '<a class="butt" href= "adminEditProduct.php?edit='.$row['id'].'"><button class="button" type="button value="edit">Edit</button></a>'.
                             '<a class="butt" href= "adminEditProduct.php?delete='.$row['id'].'"><button class="button" type="button" value="delete">Delete</button></a>'
                             ."</td></tr>"; 
                    }
                }else{
                    echo "<span class='noresults'>No Transactions Detected</span><br><br>";
                }

            ?>
		</tbody>
	</table>
    <br>
    
    <!-- For inserting new product data -->
    <div class="column-form">
        <div class="columnB-form">
            <h1><?php if($editstat == TRUE){echo "Update ";}else{echo "Insert ";}?> Product Data</h1>
            <span class="correct-record"> <?php echo $createSUC; ?> </span>
            <span class="correct-record"> <?php echo $deleteMes; ?> </span>
            <form name="insert" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                <input type="hidden" name="productid" value="<?php echo $editid; ?>">

                <table class="formTable">
                    <th>
                        Category
                    </th>
                    <th>
                        Fields
                    </th>
                    <tr>
                        <td>
                            <label for="productname">Name</label>
                        </td>
                        <td>
                            <input type="text" name="productname" placeholder="Product Name goes here..." value ="<?php echo $productname;?>" enctype="multipart/form-data">
                            <span class="error"> <br> <?php echo $productnameERR; ?> </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="productcategory">Category</label>
                        </td>
                        <td>
                            <select name="productcategory" id="prodcat">
                                <option value="Merchant Board" <?php if($productcategory === "Merchant Board "){ echo "selected";} ?>>Merchant Board</option>
                                <option value="Silver Recovery Systems" <?php if($productcategory === "Silver Recovery Systems "){ echo "selected";} ?>>Silver Recovery Systems</option>
                                <option value="Veterinary" <?php if($productcategory === "Veterinary "){ echo "selected";} ?>>Veterinary</option>
                                <option value="X Ray Test Meters" <?php if($productcategory === "X Ray Test Meters "){ echo "selected";} ?>>X Ray Test Meters</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="productdesc">Description</label>
                        </td>
                        <td>
                            <input type="text" name="productdesc" placeholder="Product Detail goes here..." value ="<?php echo $productdesc;?>">
                            <span class="error"> <br> <?php echo $productdescERR; ?> </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="productprice">Price</label>
                        </td>
                        <td>
                            <input type="text" name="productprice" placeholder="Product Price goes here..." value ="<?php echo $productprice;?>">
                            <span class="error"> <br> <?php echo $productpriceERR; ?> </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="productpic">Picture Upload</label>
                        </td>
                        <td>
                            <input type="file" name="productpic" id= "productpic" value ="">
                            <span class="error"> <br> <?php echo $productpicERR; ?> </span>
                        </td>
                    </tr>
                    <?php if($editstat === TRUE): ?>
                    <tr>
                        <td>
                            <img src="<?php echo $productpic ?>" height = "300" width = "300">
                        </td>
                        <td>
                            <p> Make Changes to the Photo? </p>
                            <label for="noupload">No
                                <input type="radio" id= "noupload" name = "uploadphoto" value ="no">
                            </label>
                            <label for="yesupload">Yes
                                <input type="radio" id= "yesupload" name = "uploadphoto" value ="yes">
                            </label>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <td>
                        <?php if ($editstat === TRUE):?>
                            <input type="submit" name = "update" value="Update" >
                        <?php else: ?>
                            <input type="submit" name = "create" value="Create" >
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($editstat === TRUE):?>
                            <a href="adminEditProduct.php?canceledit=1"><input type="button" value="Cancel" ></a>
                        <?php else: ?>
                            <a href="adminEditProduct.php?clearvalues=1"><input type="button" name = "reset" value="Clear" ></a>
                        <?php endif; ?>
                    </td>
                </table>
            </form>
            <br>
        </div>
    </div>
       
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