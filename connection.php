<?php 
    $servername = "localhost";
    $username = "id18251758_db_user";
    $password = "WopK1kfEG(*mZE%3";
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password);

    //Check connection
    if (!$conn) 
    {
        //die("Connection failed: " . mysqli_connect_error());
    }
    else
    {
        //echo "Connection successful!";
    }

    /*$sql = "CREATE DATABASE DB_PNWX";
    $result = mysqli_query($conn, $sql);
    if ($result === TRUE) 
    {
        //echo "Database created successfully";
    }
    else
    {
        //echo "Database creation failed:" . mysqli_error($conn);
    }*/

    $dbname = "id18251758_db_pnwx";
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    //Check connection
    if (!$conn) 
    {
        //die("Connection failed: " . mysqli_connect_error());
    }
    else
    {
        //echo "Connection successful!";
    }

    
?>