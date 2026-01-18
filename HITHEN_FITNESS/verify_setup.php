<?php
/**
 * DNX FITNESS WEBSITE - Setup Verification Script
 * Run this to verify all configurations and connections
 */

header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DNX FITNESS - Setup Verification</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 900px;
            width: 100%;
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }
        
        .content {
            padding: 40px;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section h2 {
            color: #667eea;
            font-size: 1.3em;
            margin-bottom: 15px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        
        .check-item {
            padding: 12px 15px;
            margin-bottom: 10px;
            border-left: 4px solid #ddd;
            border-radius: 4px;
            background: #f9f9f9;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .check-item.success {
            border-left-color: #4caf50;
            background: #f1f8f5;
        }
        
        .check-item.error {
            border-left-color: #f44336;
            background: #fdf3f3;
        }
        
        .check-item.warning {
            border-left-color: #ff9800;
            background: #fff8f3;
        }
        
        .check-icon {
            font-size: 1.5em;
            font-weight: bold;
            width: 30px;
            text-align: center;
        }
        
        .check-text {
            flex: 1;
        }
        
        .check-label {
            font-weight: 600;
            color: #333;
        }
        
        .check-detail {
            font-size: 0.9em;
            color: #666;
            margin-top: 4px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }
        
        .status-badge.success {
            background: #4caf50;
            color: white;
        }
        
        .status-badge.error {
            background: #f44336;
            color: white;
        }
        
        .status-badge.warning {
            background: #ff9800;
            color: white;
        }
        
        .summary {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            border: 2px solid #667eea;
        }
        
        .summary h3 {
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .summary-stat {
            display: inline-block;
            margin-right: 20px;
            font-size: 1.1em;
        }
        
        .code-block {
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 12px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
            overflow-x: auto;
        }
        
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
        
        .info-box strong {
            color: #1976d2;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        table th {
            background: #f5f5f5;
            font-weight: 600;
        }
        
        .footer {
            background: #f9f9f9;
            padding: 20px 40px;
            text-align: center;
            color: #666;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚙️ DNX FITNESS WEBSITE</h1>
            <p>Setup Verification & Configuration Check</p>
        </div>
        
        <div class="content">
            <?php
            
            $checks = [
                'success' => 0,
                'error' => 0,
                'warning' => 0
            ];
            
            echo '<div class="section">';
            echo '<h2>🔍 System Requirements</h2>';
            
            // PHP Version
            $php_version = phpversion();
            $php_ok = version_compare($php_version, '7.4.0', '>=');
            $checks[$php_ok ? 'success' : 'error']++;
            
            echo '<div class="check-item ' . ($php_ok ? 'success' : 'error') . '">';
            echo '<div class="check-icon">' . ($php_ok ? '✓' : '✗') . '</div>';
            echo '<div class="check-text">';
            echo '<div class="check-label">PHP Version</div>';
            echo '<div class="check-detail">Installed: ' . $php_version . ' (Required: 7.4.0+)</div>';
            echo '</div>';
            echo '</div>';
            
            // Required Extensions
            $extensions = ['mysqli', 'json'];
            foreach ($extensions as $ext) {
                $ext_ok = extension_loaded($ext);
                $checks[$ext_ok ? 'success' : 'error']++;
                
                echo '<div class="check-item ' . ($ext_ok ? 'success' : 'error') . '">';
                echo '<div class="check-icon">' . ($ext_ok ? '✓' : '✗') . '</div>';
                echo '<div class="check-text">';
                echo '<div class="check-label">PHP Extension: ' . strtoupper($ext) . '</div>';
                echo '<div class="check-detail">' . ($ext_ok ? 'Enabled' : 'Not Found') . '</div>';
                echo '</div>';
                echo '</div>';
            }
            
            echo '</div>';
            
            // Config File Check
            echo '<div class="section">';
            echo '<h2>📋 Configuration Files</h2>';
            
            $config_file = __DIR__ . '/config.php';
            $config_exists = file_exists($config_file);
            $checks[$config_exists ? 'success' : 'error']++;
            
            echo '<div class="check-item ' . ($config_exists ? 'success' : 'error') . '">';
            echo '<div class="check-icon">' . ($config_exists ? '✓' : '✗') . '</div>';
            echo '<div class="check-text">';
            echo '<div class="check-label">config.php</div>';
            echo '<div class="check-detail">' . ($config_exists ? 'Found and readable' : 'Not found') . '</div>';
            echo '</div>';
            echo '</div>';
            
            if ($config_exists) {
                require_once 'config.php';
                
                echo '<div class="info-box">';
                echo '<strong>Configuration Status:</strong><br>';
                echo 'Database: ' . DB_NAME . '<br>';
                echo 'Host: ' . DB_HOST . '<br>';
                echo 'User: ' . DB_USER . '<br>';
                echo 'Debug Mode: ' . (DEBUG_MODE ? 'Enabled' : 'Disabled');
                echo '</div>';
            }
            
            echo '</div>';
            
            // Database Connection Check
            echo '<div class="section">';
            echo '<h2>🗄️ Database Connection</h2>';
            
            if ($config_exists) {
                try {
                    $conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    
                    if ($conn) {
                        $checks['success']++;
                        echo '<div class="check-item success">';
                        echo '<div class="check-icon">✓</div>';
                        echo '<div class="check-text">';
                        echo '<div class="check-label">MySQL Connection</div>';
                        echo '<div class="check-detail">Successfully connected to ' . DB_HOST . '/' . DB_NAME . '</div>';
                        echo '</div>';
                        echo '</div>';
                        
                        // Check Tables
                        $tables = ['admindata', 'userdata', 'broadcast'];
                        echo '<div style="margin-top: 15px;">';
                        
                        foreach ($tables as $table) {
                            $result = mysqli_query($conn, "SELECT 1 FROM $table LIMIT 1");
                            $table_ok = ($result !== false);
                            $checks[$table_ok ? 'success' : 'warning']++;
                            
                            if ($table_ok) {
                                $count = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM $table");
                                $row = mysqli_fetch_assoc($count);
                                $record_count = $row['cnt'];
                                
                                echo '<div class="check-item success">';
                                echo '<div class="check-icon">✓</div>';
                                echo '<div class="check-text">';
                                echo '<div class="check-label">Table: ' . $table . '</div>';
                                echo '<div class="check-detail">Found - ' . $record_count . ' records</div>';
                                echo '</div>';
                                echo '</div>';
                            } else {
                                echo '<div class="check-item warning">';
                                echo '<div class="check-icon">⚠</div>';
                                echo '<div class="check-text">';
                                echo '<div class="check-label">Table: ' . $table . '</div>';
                                echo '<div class="check-detail">Not found - Please import fitness.sql</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        
                        echo '</div>';
                        
                        mysqli_close($conn);
                    } else {
                        $checks['error']++;
                        echo '<div class="check-item error">';
                        echo '<div class="check-icon">✗</div>';
                        echo '<div class="check-text">';
                        echo '<div class="check-label">MySQL Connection Failed</div>';
                        echo '<div class="check-detail">Error: ' . mysqli_connect_error() . '</div>';
                        echo '</div>';
                        echo '</div>';
                        
                        echo '<div class="info-box">';
                        echo '<strong>Troubleshooting:</strong><br>';
                        echo '1. Verify MySQL server is running<br>';
                        echo '2. Check config.php credentials<br>';
                        echo '3. Ensure database "' . DB_NAME . '" exists<br>';
                        echo '4. Verify user "' . DB_USER . '" has proper permissions';
                        echo '</div>';
                    }
                } catch (Exception $e) {
                    $checks['error']++;
                    echo '<div class="check-item error">';
                    echo '<div class="check-icon">✗</div>';
                    echo '<div class="check-text">';
                    echo '<div class="check-label">Connection Error</div>';
                    echo '<div class="check-detail">' . $e->getMessage() . '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            
            echo '</div>';
            
            // Project Files Check
            echo '<div class="section">';
            echo '<h2>📁 Project Files</h2>';
            
            $files_to_check = [
                'index.php' => 'Home page',
                'admin/index.php' => 'Admin login page',
                'header.php' => 'Navigation header',
                'style.css' => 'Main stylesheet',
                'bmi.php' => 'BMI Calculator',
                'diet.php' => 'Diet information'
            ];
            
            foreach ($files_to_check as $file => $desc) {
                $file_path = __DIR__ . '/' . $file;
                $file_exists = file_exists($file_path);
                $checks[$file_exists ? 'success' : 'warning']++;
                
                echo '<div class="check-item ' . ($file_exists ? 'success' : 'warning') . '">';
                echo '<div class="check-icon">' . ($file_exists ? '✓' : '⚠') . '</div>';
                echo '<div class="check-text">';
                echo '<div class="check-label">' . $desc . ' (' . $file . ')</div>';
                echo '<div class="check-detail">' . ($file_exists ? 'Found' : 'Missing') . '</div>';
                echo '</div>';
                echo '</div>';
            }
            
            echo '</div>';
            
            // Summary
            echo '<div class="summary">';
            echo '<h3>📊 Verification Summary</h3>';
            echo '<div class="summary-stat"><span class="status-badge success">✓ ' . $checks['success'] . ' Passed</span></div>';
            if ($checks['warning'] > 0) {
                echo '<div class="summary-stat"><span class="status-badge warning">⚠ ' . $checks['warning'] . ' Warnings</span></div>';
            }
            if ($checks['error'] > 0) {
                echo '<div class="summary-stat"><span class="status-badge error">✗ ' . $checks['error'] . ' Failed</span></div>';
            }
            
            if ($checks['error'] === 0) {
                echo '<p style="margin-top: 15px; color: #4caf50; font-weight: 600;">✓ System is ready for operation!</p>';
            } else {
                echo '<p style="margin-top: 15px; color: #f44336; font-weight: 600;">✗ Please resolve errors before deployment.</p>';
            }
            
            echo '</div>';
            
            ?>
        </div>
        
        <div class="footer">
            <p>DNX FITNESS WEBSITE - System Verification Report</p>
            <p style="font-size: 0.9em; margin-top: 5px;">Generated on <?php echo date('Y-m-d H:i:s'); ?></p>
        </div>
    </div>
</body>
</html>

