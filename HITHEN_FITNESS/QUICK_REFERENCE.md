# HITHEN FITNESS WEBSITE - Quick Reference Guide

## 🚀 Quick Start

### Access Application
```
Public: http://localhost/DNX-FITNESS-WEBSITE/
Admin:  http://localhost/DNX-FITNESS-WEBSITE/admin/
Verify: http://localhost/DNX-FITNESS-WEBSITE/verify_setup.php
```

### Default Admin Login
```
Email:    admin
Password: admin
```

---

## 📚 Documentation Files

| File | Purpose |
|------|---------|
| `PROJECT_ANALYSIS.md` | Complete project analysis & setup guide |
| `COMPLETION_REPORT.md` | Work summary & improvements made |
| `QUICK_REFERENCE.md` | This file - quick commands |
| `config.php` | Database configuration |
| `database_helper.php` | Advanced DB operations |
| `verify_setup.php` | System verification dashboard |

---

## 🔧 Common Tasks

### 1. Using Database Connection

```php
<?php
require_once 'config.php';

// Method A: Procedural
$conn = getDBConnection();
$result = mysqli_query($conn, "SELECT * FROM userdata");
mysqli_close($conn);

// Method B: Object-Oriented
$conn = getDBConnectionOOP();
$result = $conn->query("SELECT * FROM userdata");
$conn->close();
?>
```

### 2. Using Database Helper

```php
<?php
require_once 'database_helper.php';

$db = new DatabaseHelper();

// Insert
$data = ['user' => 'John', 'email' => 'john@example.com'];
$id = $db->insert('userdata', $data);

// Update
$db->update('userdata', ['user' => 'Jane'], ['id' => $id]);

// Select
$user = $db->selectById('userdata', $id);

// Delete
$db->delete('userdata', ['id' => $id]);

// Error handling
if (!$id) {
    echo $db->getLastError();
}

$db->close();
?>
```

### 3. Prepared Statements

```php
<?php
require_once 'config.php';

$conn = getDBConnectionOOP();

$sql = "INSERT INTO userdata (user, email, mobile) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $user, $email, $mobile);

$user = "John";
$email = "john@example.com";
$mobile = "1234567890";

$stmt->execute();
$stmt->close();
$conn->close();
?>
```

---

## 📦 Database Operations

### Select
```sql
SELECT * FROM userdata;
SELECT * FROM userdata WHERE id = 1;
SELECT COUNT(*) FROM userdata;
SELECT * FROM userdata LIMIT 10;
```

### Insert
```sql
INSERT INTO userdata (user, email, mobile, comments) 
VALUES ('John', 'john@email.com', '1234567890', 'comment');
```

### Update
```sql
UPDATE userdata SET user = 'Jane' WHERE id = 1;
```

### Delete
```sql
DELETE FROM userdata WHERE id = 1;
```

---

## 🔐 Configuration

**File:** `config.php`

```php
// Database Details
define('DB_HOST', 'localhost');
define('DB_USER', 'phpmyadmin');
define('DB_PASS', 'Admin@123');
define('DB_NAME', 'fitness');

// Debug Mode (Set to false in production)
define('DEBUG_MODE', true);
```

---

## 🗄️ Database Tables

### admindata
```
id (int) - Primary Key
email (varchar) - Unique
password (varchar)
```

### userdata
```
id (int) - Primary Key
user (varchar)
email (varchar)
mobile (varchar)
comments (varchar)
```

### broadcast
```
id (int) - Primary Key
broadcaster (varchar)
message (varchar)
```

### tbl_creators
```
id (int) - Primary Key
name (varchar)
email (varchar)
roll (varchar)
```

---

## 🔍 Verification

### Check System
Visit: `http://localhost/DNX-FITNESS-WEBSITE/verify_setup.php`

This checks:
- ✓ PHP version
- ✓ MySQL extension
- ✓ Database connection
- ✓ Table existence
- ✓ Required files

---

## 🛡️ Security Tips

1. **Always use prepared statements**
   ```php
   // ✅ Good
   $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
   
   // ❌ Bad
   $conn->query("SELECT * FROM users WHERE id = $id");
   ```

2. **Escape user output**
   ```php
   // ✅ Good
   echo htmlspecialchars($user['name']);
   
   // ❌ Bad
   echo $user['name'];
   ```

3. **Validate input**
   ```php
   if (empty($_POST['email'])) {
       die("Email is required");
   }
   ```

4. **Use centralized config**
   ```php
   // ✅ Good
   require_once 'config.php';
   
   // ❌ Bad
   $password = "Admin@123"; // Hardcoded
   ```

---

## 🐛 Troubleshooting

### Connection Failed
1. Check `config.php` credentials
2. Verify MySQL is running
3. Check user permissions
4. Visit `verify_setup.php` for details

### SQL Errors
1. Check prepared statement syntax
2. Verify column names
3. Check table existence
4. Review error logs

### File Not Found
1. Check file path
2. Verify file permissions
3. Check include path
4. Review folder structure

---

## 📝 File Locations

```
DNX-FITNESS-WEBSITE/
├── config.php                    # ⭐ Configuration
├── database_helper.php           # ⭐ Helper class
├── verify_setup.php              # ⭐ Verification
├── PROJECT_ANALYSIS.md           # 📖 Full docs
├── COMPLETION_REPORT.md          # 📋 Report
├── QUICK_REFERENCE.md            # 📚 This file
│
├── db_connect.php                # Updated
├── userinfo.php                  # Updated
├── select.php                    # Updated
├── ajaxjson.php                  # Updated
├── creatorsajax.php              # Updated
│
├── admin/
│   ├── connection.php            # Updated
│   ├── admindata.php             # Updated
│   └── index.php
│
├── bmi.php
├── diet.php
├── services.php
└── index.php
```

---

## 🎯 Most Used Functions

### Config Functions
```php
getDBConnection()              // Procedural connection
getDBConnectionOOP()           // OOP connection
closeDB($conn)                 // Close connection
```

### Database Helper Methods
```php
insert($table, $data)          // Add record
update($table, $data, $where)  // Update record
delete($table, $where)         // Delete record
selectById($table, $id)        // Get by ID
selectAll($table, $where)      // Get multiple
count($table, $where)          // Count records
```

---

## 🚢 Deployment Steps

1. **Backup current database**
   ```bash
   mysqldump -u phpmyadmin -p Admin@123 fitness > backup.sql
   ```

2. **Update config.php** with production credentials

3. **Set DEBUG_MODE = false** in config.php

4. **Test verify_setup.php**

5. **Clear cache** and temp files

6. **Monitor logs** for errors

---

## 📞 Support Resources

- **Documentation:** PROJECT_ANALYSIS.md
- **Verification:** verify_setup.php
- **Database Helper:** database_helper.php
- **Configuration:** config.php

---

## 📊 Performance Tips

- Use indexes on frequently queried columns
- Limit query results with LIMIT
- Close connections after use
- Use prepared statements (faster)
- Enable query caching
- Monitor slow queries

---

## ✅ Checklist

Before deployment:
- [ ] Database created and populated
- [ ] config.php updated with credentials
- [ ] DEBUG_MODE set to false
- [ ] verify_setup.php shows all green
- [ ] All forms tested
- [ ] Admin login working
- [ ] AJAX requests functional
- [ ] No errors in logs

---

## 🎓 Learning Resources

1. **PHP MySQLi:** https://www.php.net/manual/en/book.mysqli.php
2. **SQL Injection:** https://owasp.org/www-community/attacks/SQL_Injection
3. **Prepared Statements:** https://www.php.net/manual/en/mysqli.quickstart.prepared-statements.php
4. **Password Hashing:** https://www.php.net/manual/en/function.password-hash.php

---

**Last Updated:** January 18, 2026  
**Version:** 2.0  
**Status:** ✅ Ready for Use

