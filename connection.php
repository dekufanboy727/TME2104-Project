<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "DB_PNWX";
    
    $sql = "CREATE DATABASE DB_PNWX";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
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