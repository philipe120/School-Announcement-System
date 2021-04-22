<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "pcssdb";

    //echo "Connecting to server: $db";
    //Create connection
    $conn = new mysqli($servername, $username, $password,$db);

    //Check connection
    if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected&nbspsuccessfully<br>";
?>