# Database Setup Guide

## Issue Found
The error `Access denied for user 'phpmyadmin'@'localhost'` means the MySQL user doesn't exist with those credentials.

## Solution

### Option 1: Use Default XAMPP Settings (RECOMMENDED)
XAMPP comes with MySQL using:
- **User:** `root`
- **Password:** (empty/blank)

✅ **This is already configured in config.php**

---

## Verify Your Database Setup

### Step 1: Check if MySQL is Running
1. Open XAMPP Control Panel
2. Make sure **MySQL** is running (green light)
3. Port should be **3306**

### Step 2: Access phpMyAdmin
1. Go to: `http://localhost/phpmyadmin`
2. You should see the phpMyAdmin interface
3. If asked for login, use `root` with empty password

### Step 3: Verify the 'fitness' Database
In phpMyAdmin:
1. Look in the left sidebar
2. Click on **fitness** database
3. You should see these tables:
   - `admindata`
   - `userdata`
   - `broadcast`

### Step 4: Create the Database (if missing)
If the `fitness` database doesn't exist:

1. In phpMyAdmin, click **Databases** tab
2. Create new database called: `fitness`
3. Set charset to: `utf8mb4_unicode_ci`
4. Import the [fitness.sql](fitness.sql) file:
   - In phpMyAdmin, select `fitness` database
   - Click **Import** tab
   - Choose `fitness.sql` file from the project folder
   - Click **Go**

---

## Option 2: Use Custom Database User
If you want to use a different user (like 'phpmyadmin'):

### In phpMyAdmin:
1. Click **User accounts** (admin tab)
2. **Add user account**
   - User name: `phpmyadmin`
   - Host: `localhost`
   - Password: `Admin@123`
   - Confirm password: `Admin@123`
3. Select **Database for user account** → Select `fitness`
4. Grant all privileges
5. Click **Go**

### Then update config.php:
Change these lines:
```php
define('DB_USER', 'root');
define('DB_PASS', '');
```

To:
```php
define('DB_USER', 'phpmyadmin');
define('DB_PASS', 'Admin@123');
```

---

## Test Your Connection

### Method 1: Use verify_setup.php
1. Go to: `http://localhost/DNX-FITNESS-WEBSITE-main/verify_setup.php`
2. You should see a green checkmark for "Database Connection"
3. All tables should show record counts

### Method 2: View This Page
1. Go to: `http://localhost/DNX-FITNESS-WEBSITE-main/userinfo.php`
2. You should see the user information page
3. If it loads without errors, the connection works

### Method 3: Check PHP Error Logs
If you still see errors:
1. Open: `C:\xampp\apache\logs\error.log`
2. Look for MySQL connection errors
3. The last error will tell you the exact issue

---

## Common Issues

### Issue: "Access denied for user 'root'@'localhost'"
**Solution:** 
- Your MySQL has a password set
- In config.php, change `define('DB_PASS', '');` to your actual password

### Issue: "Unknown database 'fitness'"
**Solution:**
- The fitness database doesn't exist
- Create it in phpMyAdmin (see Step 4 above)
- Or import fitness.sql file

### Issue: "No such file or directory" for fitness.sql
**Solution:**
- The SQL file is in the project root folder
- Make sure you're importing from: `C:\xampp\htdocs\DNX-FITNESS-WEBSITE-main\fitness.sql`

---

## Quick Checklist

- [ ] XAMPP is running (MySQL is started)
- [ ] `http://localhost/phpmyadmin` loads successfully
- [ ] 'fitness' database exists in phpMyAdmin
- [ ] Database has admindata, userdata, broadcast tables
- [ ] Database user has proper credentials in config.php
- [ ] `http://localhost/DNX-FITNESS-WEBSITE-main/verify_setup.php` shows green checkmarks
- [ ] `http://localhost/DNX-FITNESS-WEBSITE-main/index.php` loads without errors

---

## After Setup

Once your database is configured:
1. All pages will work: `http://localhost/DNX-FITNESS-WEBSITE-main/[page].php`
2. Admin panel: `http://localhost/DNX-FITNESS-WEBSITE-main/admin/`
3. Dashboard: `http://localhost/DNX-FITNESS-WEBSITE-main/dashboard.html`
4. Verification: `http://localhost/DNX-FITNESS-WEBSITE-main/verify_setup.php`

---

**Need Help?** Check the error message on your page - it will tell you exactly what's wrong!
