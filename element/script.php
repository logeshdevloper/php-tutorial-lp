                <?php

                        header('Content-Type: application/json');

                        $servername = "192.164.1.42";
                        $username = "root";
                        $password = "123456";
                        $database = "kiastore";

                        // Create a connection
                        $conn = new mysqli($servername, $username, $password, $database);

                        // Check the connection
                        if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                        }

                        // ...

                        // Check if the "table" parameter is set in the JSON request
                        if (isset($_GET['table'])) {
                        $table = $_GET['table'];

                        // Perform different actions based on the provided table parameter
                        switch ($table) {
                                case 'jobs':
                                $sql = "SELECT * FROM jobs";
                                break;
                                case 'pages':
                                $sql = "SELECT * FROM pages";
                                break;
                                // Add more cases for additional tables if needed
                                default:
                                echo json_encode(array("message" => "Invalid table parameter"));
                                exit; // Terminate script
                        }

                        $result = $conn->query($sql);

                        if ($result === FALSE) {
                                echo json_encode(array("message" => "Error: " . $sql . "<br>" . $conn->error));
                                exit; // Terminate script
                        }

                        $data = array();

                        if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                $data[] = $row;
                                }

                                echo json_encode($data);
                        } else {
                                echo json_encode(array("message" => "No results found for the specified table"));
                        }
                        } else {
                        echo json_encode(array("message" => "Table parameter is not provided"));
                        }

                        // Close the connection
                        $conn->close();
                ?>
