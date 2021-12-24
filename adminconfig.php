<?php 
    $servername = "localhost";
    $username = "PNWX_admin";
    $password = "2L4R/4hb6Qd6GVG3";
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password);

    //Check connection
    if (!$conn) 
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    else
    {
        echo "Connection successful!";
    }

    $sql = "CREATE DATABASE DB_PNWX";
    if (mysqli_query($conn, $sql)) 
    {
        echo "Database created successfully";
    }
    else
    {
        echo "Database creation failed:" . mysqli_error($conn);
    }

    $dbname = "DB_PNWX";
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
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