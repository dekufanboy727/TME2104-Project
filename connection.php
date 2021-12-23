<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Db_PNWX";
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $sql = "CREATE DATABASE DB_PNWX";
    if (mysqli_query($conn, $sql)) 
    {
        echo "Database created successfully";
    }
    else
    {
        echo "Database creation failed:" . mysqli_error($conn);
    }
    
    //Check connection
    if (!$conn) 
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    else
    {
        echo "Connection successful!";
    }
?>