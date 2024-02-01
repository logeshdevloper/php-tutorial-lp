<?php
header('Content-Type: application/json');

$servername = "192.164.1.42";
$username = "root";
$password = "123456";
$database = "phpfirstproject";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize data and prevent SQL injection
function sanitizeInput($conn, $input) {
    return mysqli_real_escape_string($conn, $input);
}

// Check the HTTP method
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // SELECT operation
    $sql = "SELECT * FROM newformdata";
    $result = $conn->query($sql);

    if ($result === FALSE) {
        $response['error'] = "Error: " . $sql . "<br>" . $conn->error;
    } else {
        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $response['data'] = $data;
    }
} elseif ($method === 'POST') {
    // INSERT operation
    $data = json_decode(file_get_contents("php://input"), true);

    $firstname = sanitizeInput($conn, $data['firstname']);
    $lastname = sanitizeInput($conn, $data['lastname']);
    $email = sanitizeInput($conn, $data['email']);

    if ($firstname == '' || $lastname == '' || $email == '') {
        $response = array("error" => "Firstname, lastname, and email cannot be empty.");
    } else {
        $sql = "INSERT INTO newformdata (firstname, lastname, email) VALUES ('$firstname', '$lastname', '$email')";

        if ($conn->query($sql) === TRUE) {
            $response = array("success" => "New record added successfully.", "data" => array("firstname" => $firstname, "lastname" => $lastname, "email" => $email));
        } else {
            $response = array("error" => "Error: " . $sql . "<br>" . $conn->error);
        }
    }
} else {
    $response = array("error" => "Unsupported HTTP method.");
}

echo json_encode($response);

$conn->close();
?>
