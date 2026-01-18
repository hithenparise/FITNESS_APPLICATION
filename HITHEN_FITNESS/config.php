<?php
/**
 * DNX FITNESS WEBSITE - Centralized Configuration
 * Database connection configuration and utility functions
 */

// ============================================================================
// DATABASE CONFIGURATION
// ============================================================================
// XAMPP Default Settings (adjust if needed)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');           // Default XAMPP user
define('DB_PASS', '');               // XAMPP default: empty password
define('DB_NAME', 'fitness');

// Alternative: If you have set up a custom database user:
// define('DB_USER', 'phpmyadmin');
// define('DB_PASS', 'Admin@123');

// Connection Type - 'mysqli' or 'pdo'
define('DB_TYPE', 'mysqli');

// Display Errors in Development (disable in production)
define('DEBUG_MODE', true);

/**
 * Get Database Connection (MySQLi Procedural)
 * @return mysqli|false Connection resource or false on failure
 */
function getDBConnection() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if (!$conn) {
        if (DEBUG_MODE) {
            die("Database Connection Failed: " . mysqli_connect_error());
        } else {
            die("A database error occurred. Please try again later.");
        }
    }
    
    // Set charset to UTF-8
    mysqli_set_charset($conn, 'utf8mb4');
    
    return $conn;
}

/**
 * Get Database Connection (MySQLi Object-Oriented)
 * @return mysqli|null Connection object or null on failure
 */
function getDBConnectionOOP() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        if (DEBUG_MODE) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            die("A database error occurred. Please try again later.");
        }
    }
    
    // Set charset to UTF-8
    $conn->set_charset('utf8mb4');
    
    return $conn;
}

/**
 * Escape string for SQL queries (MySQLi)
 * Note: Use prepared statements instead of this when possible
 * @param string $string String to escape
 * @return string Escaped string
 */
function escapeSQL($string) {
    $conn = getDBConnection();
    $escaped = mysqli_real_escape_string($conn, $string);
    mysqli_close($conn);
    return $escaped;
}

/**
 * Execute query and return results
 * @param string $query SQL query
 * @return mixed Query result or false on failure
 */
function executeQuery($query) {
    $conn = getDBConnection();
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        if (DEBUG_MODE) {
            die("Query Error: " . mysqli_error($conn));
        }
        mysqli_close($conn);
        return false;
    }
    
    mysqli_close($conn);
    return $result;
}

/**
 * Get single row from query
 * @param string $query SQL query
 * @return array|null Single row as associative array or null
 */
function getRow($query) {
    $result = executeQuery($query);
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

/**
 * Get all rows from query
 * @param string $query SQL query
 * @return array Array of rows or empty array
 */
function getAllRows($query) {
    $result = executeQuery($query);
    $rows = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
    
    return $rows;
}

/**
 * Close database connection
 * @param mysqli $conn Connection resource
 */
function closeDB($conn) {
    if ($conn) {
        mysqli_close($conn);
    }
}

/**
 * Get last insert ID
 * @param mysqli $conn Connection resource
 * @return int Last inserted ID
 */
function getLastInsertID($conn) {
    return mysqli_insert_id($conn);
}

/**
 * Get number of affected rows
 * @param mysqli $conn Connection resource
 * @return int Number of affected rows
 */
function getAffectedRows($conn) {
    return mysqli_affected_rows($conn);
}

?>

