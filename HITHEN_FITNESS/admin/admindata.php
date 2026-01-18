 <?php
session_start();
require_once dirname(__DIR__) . '/config.php';

if (isset($_SESSION['User'])) {
    $conn = getDBConnectionOOP();
    
    // Validate required fields
    if (empty($_POST['username']) || empty($_POST['password'])) {
        echo "Username and password are required.";
        $conn->close();
        exit;
    }
    
    $user = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    
    // Note: In production, hash passwords with password_hash() and verify with password_verify()
    $sql = "INSERT INTO admindata (email, password)
    VALUES (?, ?)";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo "Prepare failed: " . $conn->error;
        $conn->close();
        exit;
    }
    
    $stmt->bind_param("ss", $user, $password);
    
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    
    header('Location: insert.php');
    exit;
} else {
    header("Location: index.php");
    exit;
}
