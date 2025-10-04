# 💕 Love Journal - Couples Web Application

A Laravel-based web application that allows couples to create a shared love journal space.

## Features Implemented

### ✅ User Authentication
- **Registration**: Users can create an account with name, email, and password
- **Login**: Email and password authentication
- **Session Management**: Remember me functionality and secure logout

### ✅ Heart Connection System
A classy couple matching system where users can:
- Send "Heart Connection" requests to other users via email
- Include optional personal messages with requests
- Accept or decline incoming heart connection requests
- Automatically create a shared couple space when a request is accepted

### ✅ Dashboard
- Shows user's current status (single or in a couple)
- Displays pending heart connection requests
- Shows connected partner information
- Easy navigation to send new heart connection requests

## Database Structure

### Tables Created
1. **users** - User accounts with email and password authentication
2. **couples** - Stores couple relationships with optional anniversary date and couple name
3. **heart_connections** - Manages connection requests with status tracking (pending, accepted, declined)

## Key Components

### Models
- `User` - User authentication and relationships
- `Couple` - Couple relationship with helper methods
- `HeartConnection` - Heart connection request management

### Controllers
- `AuthController` - Handles registration, login, and logout
- `DashboardController` - Manages the main dashboard view
- `HeartConnectionController` - Manages heart connection requests

### Views
- Login and Registration pages with modern design
- Dashboard with conditional content based on couple status
- Heart Connection request form
- Beautiful gradient UI with Tailwind CSS

## How It Works

1. **User Registration/Login**: Users create an account or log in
2. **Send Heart Connection**: Users can send a heart connection request to another user's email
3. **Accept Request**: The receiver can accept or decline the request from their dashboard
4. **Couple Space Created**: Once accepted, both users are connected in a couple relationship
5. **Shared Space**: The couple space is ready for future features (journal entries, memories, etc.)

## Next Steps (Future Development)

The shared couple space is ready for additional features such as:
- Shared journal entries
- Memory timeline
- Photo albums
- Special date reminders
- Love notes and messages
- Mood tracking
- And more...

## Technical Details

- **Framework**: Laravel 11.x
- **Database**: SQLite (can be changed to MySQL/PostgreSQL)
- **Frontend**: Blade templates with Tailwind CSS
- **Authentication**: Laravel's built-in authentication
- **Styling**: Custom gradient themes with heart emojis 💕

## Running the Application

```bash
# Start the development server
php artisan serve

# Visit http://127.0.0.1:8000
```

## Security Features

- Password hashing
- CSRF protection on all forms
- Session-based authentication
- Email validation
- Unique constraints to prevent duplicate couples
- Authorization checks on heart connection actions

---

Built with ❤️ using Laravel
