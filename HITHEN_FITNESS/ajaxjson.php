 <?php
require_once 'config.php';

$servername = "localhost";
$username = "phpmyadmin";
$password = "Admin@123";
$dbname = "fitness";

// Create connection using object-oriented approach
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    if (DEBUG_MODE) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        die("Database error. Please try again later.");
    }
}

$sql = "SELECT * FROM creators";
$results = $conn->query($sql);

if (!$results) {
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    $conn->close();
    exit;
}

$data = array();

while ($row = $results->fetch_assoc()) {
    $data[] = $row;  // Collect all rows
}

// Return JSON encoded data
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
