<?php
/**
 * Database Connection File - Admin Panel
 * Uses centralized config for consistency
 */

require_once dirname(__DIR__) . '/config.php';

// Get database connection using procedural approach
$con = getDBConnection();

// Verify connection
if (!$con) {
    if (DEBUG_MODE) {
        die('Please check your database connection: ' . mysqli_connect_error());
    } else {
        die('Database connection error. Please contact administrator.');
    }
}

?>
