<!--------- product cards ------------------------------------------------------------------------------------------->
<?php 
            
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "DB_PNWX";
        
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }



            $sql = "SELECT id, productcategory, productname, productdetail, price, productpic FROM cat1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                  echo '<div class="column"> <div class = "card">';
                  echo '' .'<img src = "' . $row['productpic'] . '"/>' . '';
                  echo '  <div class="grid-container"> <h2>' . $row["productname"]. '</h2></div>';
                  echo '  <div class="grid-container"> <p>' . $row["productdetail"] . '</p></div>';
                  echo '  <div class="grid-container"> <p class="title">'. "$" . $row["price"] .  '</p></div>';
                  echo '<p><a href="#addcart"><button class="button">Add Cart</button></a></p>     ';
                  echo '</div></div>';

                }

            } else {
                echo "0 results";
            }
            ?>
<!--------- product cards end------------------------------------------------------------------------------>