<?php
/**
 * DNX FITNESS WEBSITE - Database Helper Utilities
 * Advanced database operations and query builders
 */

require_once __DIR__ . '/config.php';

class DatabaseHelper {
    private $conn;
    private $last_error;
    private $last_query;
    
    /**
     * Constructor - Initialize database connection
     */
    public function __construct() {
        $this->conn = getDBConnectionOOP();
    }
    
    /**
     * Get last error message
     * @return string Error message
     */
    public function getLastError() {
        return $this->last_error;
    }
    
    /**
     * Get last executed query
     * @return string Last query
     */
    public function getLastQuery() {
        return $this->last_query;
    }
    
    /**
     * Insert record into database
     * @param string $table Table name
     * @param array $data Associative array of column => value
     * @return bool|int Insert ID on success, false on failure
     */
    public function insert($table, $data) {
        if (empty($data)) {
            $this->last_error = "No data provided for insert";
            return false;
        }
        
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        
        $this->last_query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        $stmt = $this->conn->prepare($this->last_query);
        if ($stmt === false) {
            $this->last_error = $this->conn->error;
            return false;
        }
        
        // Build bind parameters dynamically
        $types = $this->getParamTypes($data);
        $values = array_values($data);
        
        $stmt->bind_param($types, ...$values);
        
        if (!$stmt->execute()) {
            $this->last_error = $stmt->error;
            $stmt->close();
            return false;
        }
        
        $insert_id = $stmt->insert_id;
        $stmt->close();
        
        return $insert_id;
    }
    
    /**
     * Update record in database
     * @param string $table Table name
     * @param array $data Column => value pairs to update
     * @param array $where Where conditions (column => value)
     * @return bool|int Number of affected rows
     */
    public function update($table, $data, $where) {
        if (empty($data) || empty($where)) {
            $this->last_error = "Update requires data and where conditions";
            return false;
        }
        
        $set_clause = implode(", ", array_map(fn($k) => "$k = ?", array_keys($data)));
        $where_clause = implode(" AND ", array_map(fn($k) => "$k = ?", array_keys($where)));
        
        $this->last_query = "UPDATE $table SET $set_clause WHERE $where_clause";
        
        $stmt = $this->conn->prepare($this->last_query);
        if ($stmt === false) {
            $this->last_error = $this->conn->error;
            return false;
        }
        
        // Merge data and where values
        $all_values = array_merge(array_values($data), array_values($where));
        $types = $this->getParamTypes($all_values);
        
        $stmt->bind_param($types, ...$all_values);
        
        if (!$stmt->execute()) {
            $this->last_error = $stmt->error;
            $stmt->close();
            return false;
        }
        
        $affected = $stmt->affected_rows;
        $stmt->close();
        
        return $affected;
    }
    
    /**
     * Delete record from database
     * @param string $table Table name
     * @param array $where Where conditions
     * @return bool|int Number of affected rows
     */
    public function delete($table, $where) {
        if (empty($where)) {
            $this->last_error = "Delete requires where conditions";
            return false;
        }
        
        $where_clause = implode(" AND ", array_map(fn($k) => "$k = ?", array_keys($where)));
        $this->last_query = "DELETE FROM $table WHERE $where_clause";
        
        $stmt = $this->conn->prepare($this->last_query);
        if ($stmt === false) {
            $this->last_error = $this->conn->error;
            return false;
        }
        
        $types = $this->getParamTypes($where);
        $values = array_values($where);
        
        $stmt->bind_param($types, ...$values);
        
        if (!$stmt->execute()) {
            $this->last_error = $stmt->error;
            $stmt->close();
            return false;
        }
        
        $affected = $stmt->affected_rows;
        $stmt->close();
        
        return $affected;
    }
    
    /**
     * Select record by ID
     * @param string $table Table name
     * @param int $id Record ID
     * @param string $id_column ID column name (default: 'id')
     * @return array|null Record data or null
     */
    public function selectById($table, $id, $id_column = 'id') {
        $this->last_query = "SELECT * FROM $table WHERE $id_column = ?";
        
        $stmt = $this->conn->prepare($this->last_query);
        if ($stmt === false) {
            $this->last_error = $this->conn->error;
            return null;
        }
        
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        
        $stmt->close();
        
        return $data;
    }
    
    /**
     * Select all records from table
     * @param string $table Table name
     * @param array $where Optional where conditions
     * @param int $limit Optional limit
     * @param int $offset Optional offset
     * @return array Array of records
     */
    public function selectAll($table, $where = [], $limit = null, $offset = null) {
        $query = "SELECT * FROM $table";
        
        if (!empty($where)) {
            $where_clause = implode(" AND ", array_map(fn($k) => "$k = ?", array_keys($where)));
            $query .= " WHERE $where_clause";
        }
        
        if ($limit !== null) {
            $query .= " LIMIT $limit";
            if ($offset !== null) {
                $query .= " OFFSET $offset";
            }
        }
        
        $this->last_query = $query;
        
        $stmt = $this->conn->prepare($this->last_query);
        if ($stmt === false) {
            $this->last_error = $this->conn->error;
            return [];
        }
        
        if (!empty($where)) {
            $types = $this->getParamTypes($where);
            $values = array_values($where);
            $stmt->bind_param($types, ...$values);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        $stmt->close();
        
        return $data;
    }
    
    /**
     * Count records in table
     * @param string $table Table name
     * @param array $where Optional where conditions
     * @return int Count of records
     */
    public function count($table, $where = []) {
        $query = "SELECT COUNT(*) as count FROM $table";
        
        if (!empty($where)) {
            $where_clause = implode(" AND ", array_map(fn($k) => "$k = ?", array_keys($where)));
            $query .= " WHERE $where_clause";
        }
        
        $this->last_query = $query;
        
        $stmt = $this->conn->prepare($this->last_query);
        if ($stmt === false) {
            $this->last_error = $this->conn->error;
            return 0;
        }
        
        if (!empty($where)) {
            $types = $this->getParamTypes($where);
            $values = array_values($where);
            $stmt->bind_param($types, ...$values);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        $stmt->close();
        
        return intval($row['count']);
    }
    
    /**
     * Execute raw query with parameters
     * @param string $query SQL query with ? placeholders
     * @param array $params Query parameters
     * @return mysqli_result|bool Query result
     */
    public function query($query, $params = []) {
        $this->last_query = $query;
        
        if (empty($params)) {
            return $this->conn->query($query);
        }
        
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            $this->last_error = $this->conn->error;
            return false;
        }
        
        $types = $this->getParamTypes($params);
        $stmt->bind_param($types, ...$params);
        
        if (!$stmt->execute()) {
            $this->last_error = $stmt->error;
            return false;
        }
        
        return $stmt->get_result();
    }
    
    /**
     * Get parameter types for bind_param
     * @param array $data Data to analyze
     * @return string Type string (i, d, s, b)
     */
    private function getParamTypes($data) {
        $types = '';
        
        foreach ($data as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } elseif (is_string($value)) {
                $types .= 's';
            } else {
                $types .= 'b'; // blob
            }
        }
        
        return $types;
    }
    
    /**
     * Close database connection
     */
    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
    
    /**
     * Destructor - Ensure connection is closed
     */
    public function __destruct() {
        $this->close();
    }
}

// Export for use
return DatabaseHelper::class;
?>

