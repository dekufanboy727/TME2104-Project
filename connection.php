<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    
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
    $result = mysqli_query($conn, $sql);
    if ($result === TRUE) 
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