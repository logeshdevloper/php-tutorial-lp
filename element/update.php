<?php

         // Retrieve form data
         $id = $_POST['id'];
         $firstname = $_POST['firstname'];
         $last_name = $_POST['lastname'];
         $phone =  $_POST['phone'];
         $email = $_POST['email'];


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

        $sql = "INSERT INTO formdata (id, firstname, lastname, phone, email) VALUES ('$id','$firstname', '$last_name', '$phone', '$email')";

        if ($conn->query($sql) === TRUE) {
                echo "New record added successfully.";
        } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
?>
