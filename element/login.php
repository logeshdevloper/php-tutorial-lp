<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user credentials from the request
    $data = json_decode(file_get_contents("php://input"), true);

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

    $username = $data['username'];
    $password = $data['password'];

    echo "Username: $username, Password: $password";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM userlogin WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $username);

    // Execute the query
    $stmt->execute();

    if (!$stmt->execute()) {
        die("Error: " . $stmt->error);
    }


    // Get the result
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['user_password'];

        // Check if the password is correct
        if (password_verify($password, $hashed_password)) {
            // Set session variable and send a success message
            $_SESSION['username'] = $username;
            echo json_encode(array("success" => true, "message" => "Login successful"));
        } else {
            echo json_encode(array("success" => false, "message" => "Incorrect password"));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "User not found"));
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // If the request method is not POST, send an error response
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
?>
