 <?php
require_once 'config.php';

$conn = getDBConnectionOOP();

// Validate required fields
if (empty($_POST['username']) || empty($_POST['email'])) {
    echo "Username and email are required fields.";
    $conn->close();
    exit;
}

$user = $conn->real_escape_string($_POST['username']);
$email = $conn->real_escape_string($_POST['email']);
$mobile = isset($_POST['mobile']) ? $conn->real_escape_string($_POST['mobile']) : '';
$comment = isset($_POST['comment']) ? $conn->real_escape_string($_POST['comment']) : '';

$sql = "INSERT INTO userdata (user, email, mobile, comments)
VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo "Prepare failed: " . $conn->error;
    $conn->close();
    exit;
}

$stmt->bind_param("ssss", $user, $email, $mobile, $comment);

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header('Location: index.php');
exit;
