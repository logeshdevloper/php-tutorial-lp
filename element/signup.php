<?php

         // Retrieve form data
         $login_user = $_POST['username'];
         $user_password = $_POST['password'];


        $servername = "localhost";
        $username = "root";
        $password = "123456";
        $database = "phpfirstproject";

        // Create a connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check the connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }


        // Insert data into SQL table using prepared statement
        $sql = "INSERT INTO userlogin (email, user_password) VALUES ('$login_user','$user_password')";

        if ($conn->query($sql) === TRUE) {
                echo "New record added successfully.";
        } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
?>
