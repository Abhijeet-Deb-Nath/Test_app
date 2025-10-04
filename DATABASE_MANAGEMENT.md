# Database Management Guide

## Your Database Location
**Path:** `C:\Users\Ankon\example-app\database\database.sqlite`

## Option 1: Using DB Browser for SQLite (Recommended - GUI Tool)

### Download & Install:
1. Download from: https://sqlitebrowser.org/dl/
2. Install DB Browser for SQLite
3. Open the application
4. Click **"Open Database"**
5. Navigate to: `C:\Users\Ankon\example-app\database\database.sqlite`

### View/Edit/Delete Data:
- Click **"Browse Data"** tab
- Select table from dropdown (users, couples, heart_connections, etc.)
- View all records in a spreadsheet-like interface
- **Delete rows:** Right-click on row → Delete Record
- **Edit data:** Double-click any cell to edit
- Click **"Write Changes"** to save

---

## Option 2: Using Laravel Tinker (Command Line)

### View All Users:
```bash
php artisan tinker --execute="App\Models\User::all(['id', 'name', 'email'])"
```

### Count Users:
```bash
php artisan tinker --execute="App\Models\User::count()"
```

### Delete Specific User by Email:
```bash
php artisan tinker --execute="App\Models\User::where('email', 'example@email.com')->delete()"
```

### Delete User by ID:
```bash
php artisan tinker --execute="App\Models\User::find(1)->delete()"
```

### Delete All Users:
```bash
php artisan tinker --execute="App\Models\User::truncate()"
```

### View All Couples:
```bash
php artisan tinker --execute="App\Models\Couple::all()"
```

### View All Heart Connections:
```bash
php artisan tinker --execute="App\Models\HeartConnection::with(['sender', 'receiver'])->get()"
```

### View All Memories:
```bash
php artisan tinker --execute="App\Models\MemoryTreasure::with('creator')->get()"
```

---

## Option 3: Using SQLite Command Line

### Open Database:
```bash
sqlite3 database\database.sqlite
```

### Common SQLite Commands:
```sql
-- Show all tables
.tables

-- View all users
SELECT * FROM users;

-- View user count
SELECT COUNT(*) FROM users;

-- Delete user by email
DELETE FROM users WHERE email = 'example@email.com';

-- View couples
SELECT * FROM couples;

-- View heart connections with status
SELECT * FROM heart_connections;

-- Exit SQLite
.exit
```

---

## Option 4: Using VS Code Extension (In Your Editor)

### Install SQLite Extension:
1. Open VS Code
2. Go to Extensions (Ctrl+Shift+X)
3. Search for **"SQLite"** by alexcvzz
4. Install it
5. Press Ctrl+Shift+P → Type "SQLite: Open Database"
6. Select: `database/database.sqlite`
7. View/edit in **SQLite Explorer** sidebar

---

## Quick Reference: Database Tables

| Table Name | Description |
|------------|-------------|
| `users` | User accounts (name, email, password) |
| `couples` | Couple relationships |
| `heart_connections` | Connection requests (pending/accepted/declined) |
| `heart_separations` | Separation requests |
| `memory_treasures` | Shared memories with media |
| `memory_reflections` | Nostalgic thoughts on memories |
| `memory_comments` | Comments/replies on reflections |
| `sessions` | Active login sessions |
| `cache` | Application cache |
| `password_reset_tokens` | Password reset tokens |

---

## Important Notes:
- **Always backup** before manual deletions
- **Cascade deletes** are configured: deleting a couple deletes all shared memories
- **Remember tokens** stored in users table for "Remember Me" functionality
- **Session lifetime** is now set to **30 days** (43200 minutes)
