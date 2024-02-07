<?php
// Assuming signup.php is handling a POST request

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the request body
    $data = json_decode(file_get_contents("php://input"), true);


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

    // Process and use the data as needed
    $username = $data['name'];
    $password = $data['password'];

    // Your further processing logic goes here...

    // Insert data into SQL table using prepared statement (to prevent SQL injection)
    $sql = "INSERT INTO userlogin (email, user_password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ss", $username, $password);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Data received and inserted successfully']);
    } else {
        echo json_encode(['error' => 'Error inserting data']);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle other HTTP methods or return an error
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Invalid request method']);
}
?>
