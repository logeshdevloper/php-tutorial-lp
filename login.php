<?php
        session_start();
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        header('Content-Type: application/json');

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve user credentials from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Connect to the database (replace with your database credentials)
        $servername = "localhost";
        $username_db = "root";
        $password_db = "123456";
        $database = "phpfirstproject";

        $conn = new mysqli($servername, $username_db, $password_db, $database);

        // Check connection
        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
        }

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM userlogin WHERE email= $username AND user_password=$password");
        $stmt->bind_param("ss", $username, $password);

        // Execute the query
        $stmt->execute();


        // Get the result
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Check if the user exists
        if ($row) {
                // Set session variable and redirect to index.php
                $_SESSION['username'] = $username;
                header("Location: element/Firstphp.html");
        } else {
                echo json_encode(array("Error: " . $row));
                exit();
                
        }

        // Close the database connection
        $stmt->close();
        $conn->close();
        }
?>
