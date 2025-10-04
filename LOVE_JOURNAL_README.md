# 💕 Love Journal - Couples Web Application

A beautifully designed Laravel-based web application that allows couples to create a shared love journal space with an elegant rose-themed interface.

## ✨ Features Implemented

### ✅ User Authentication
- **Registration**: Users can create an account with name, email, and password
- **Login**: Email and password authentication with "Remember Me" functionality
- **Session Management**: Secure logout with session invalidation

### ✅ Heart Connection System
A classy couple matching system where users can:
- Send "Heart Connection" requests to other users via email
- Include optional personal messages with requests (up to 500 characters)
- Accept or decline incoming heart connection requests
- Automatically create a shared couple space when a request is accepted
- View pending requests in a beautiful card-based interface

### ✅ Heart Separation System
A respectful way to end a couple relationship:
- Request "Heart Separation" when you want to end the couple connection
- Requires mutual consent - partner must approve the separation
- Optional reason field to share thoughts (up to 1000 characters)
- Cancel pending separation requests
- Automatically deletes all shared content upon approval
- Warning system to prevent accidental separations

### ✅ Memory Treasures System (NEW!)
A beautiful shared photo album and journal for couples:
- **Create Memories**: Store precious moments with heading, optional subtitle, story, and date
- **Multiple Media Types**:
  - 📝 Text-only memories for written stories
  - 🎵 Audio memories (MP3, WAV, OGG) up to 100MB
  - 🎬 Video memories (MP4, AVI, MOV, WMV) up to 100MB
- **Nostalgic Reflections**: Both partners can add thoughts about each memory
- **Memory Gallery**: Beautiful grid view of all shared memories
- **Track Creators**: See who created each memory
- **Interactive Details**: View full memory with media playback
- **Local Storage**: Files stored in `storage/app/public` for localhost use

### ✅ Elegant Dashboard
- **Single Users**: 
  - Send heart connection requests
  - View and respond to pending requests
  - Beautiful gradient cards with hover effects
  
- **Couples**: 
  - View partner information
  - Anniversary date display (if set)
  - Access to Memory Treasures gallery
  - Pending separation request notifications
  - Option to request heart separation

### ✅ Beautiful UI Design
- **Color Palette**: Rose, pink, and soft pastels (#ffeef8, #ff6b9d, #c44569)
- **Typography**: Playfair Display for headings, Poppins for body text
- **Animations**: 
  - Floating hearts background animation
  - Smooth transitions and hover effects
  - Scale transformations on buttons
  - Slide-down alerts
- **Components**:
  - Glassmorphism cards with backdrop blur
  - Gradient buttons with shadows
  - Elegant rounded corners (rounded-xl, rounded-2xl)
  - Responsive design for all screen sizes

## 📊 Database Structure

### Tables Created
1. **users** - User accounts with email and password authentication
2. **couples** - Stores couple relationships with optional anniversary date and couple name
3. **heart_connections** - Manages connection requests with status tracking (pending, accepted, declined)
4. **heart_separations** - Manages separation requests with mutual consent system (pending, approved, declined)
5. **memory_treasures** - Stores shared memories with text/audio/video content
6. **memory_reflections** - Stores nostalgic thoughts and reflections about memories

## 🎨 Design Philosophy

The application features an elegant, loving design with:
- Soft rose and pink gradients throughout
- Floating hearts in the background for a romantic atmosphere
- Clean, modern interface with glassmorphism effects
- Smooth animations and transitions
- Intuitive user experience with clear visual feedback
- Emoji integration for emotional context (💕, 💔, 💌, etc.)

## 🔧 Key Components

### Models
- `User` - User authentication and relationships with couples/connections
- `Couple` - Couple relationship with helper methods and separation tracking
- `HeartConnection` - Heart connection request management
- `HeartSeparation` - Heart separation request management with approval workflow
- `MemoryTreasure` - Shared memory storage with media support
- `MemoryReflection` - Nostalgic thoughts and reflections about memories

### Controllers
- `AuthController` - Handles registration, login, and logout
- `DashboardController` - Manages the main dashboard view with couple/single states
- `HeartConnectionController` - Manages heart connection requests
- `HeartSeparationController` - Manages heart separation requests with mutual consent
- `MemoryTreasureController` - Handles memory creation, viewing, and reflections
- `HeartSeparationController` - Manages heart separation requests with mutual consent

### Views
- **Auth**: Login and Registration pages with elegant rose design
- **Dashboard**: Conditional content based on relationship status
- **Heart Connections**: Request form with message capability
- **Heart Separations**: Separation request form with warnings
- **Memory Treasures**: Gallery view, creation form, and detailed memory pages
- **Layout**: Master layout with floating hearts, navigation, and alerts

## 📱 How It Works

1. **User Registration/Login**: 
   - Users create an account with elegant registration form
   - Login with email/password on beautiful login page
   
2. **Send Heart Connection**: 
   - Users search for partner by email
   - Add optional personal message
   - Request is sent and appears in partner's dashboard
   
3. **Accept Connection**: 
   - Receiver views request with message on dashboard
   - Can accept or decline
   - Upon acceptance, couple space is created
   
4. **Couple Space & Memory Treasures**: 
   - Shared dashboard showing partner information
   - Access to Memory Treasures gallery
   - Create memories with:
     - Text stories
     - Audio recordings (up to 100MB)
     - Video clips (up to 100MB)
   - Add nostalgic reflections to any memory
   - View who created each memory
   - See all reflections from both partners
   
5. **Request Separation**: 
   - Receiver views request with message on dashboard
   - Can accept or decline
   - Upon acceptance, couple space is created
   
4. **Couple Space**: 
   - Shared dashboard showing partner information
   - Placeholders for future features
   - Option to request separation
   
5. **Request Separation**: 
   - One partner requests separation with optional reason
   - Other partner receives notification on dashboard
   - Can approve (deletes all shared content) or decline
   - Requester can cancel pending request

## 🚀 Next Steps (Future Development)

The shared couple space is ready for additional features such as:
- 📔 Shared journal entries with rich text
- 📸 Photo albums and memory timeline
- 🎂 Special date reminders and countdowns
- 💌 Love notes and daily affirmations
- 😊 Mood tracking and emotional check-ins
- 🎁 Gift ideas and wishlist
- 📍 Shared bucket list and goals
- 📊 Relationship statistics and insights

## 🛠️ Technical Details

- **Framework**: Laravel 11.x
- **Database**: SQLite (can be changed to MySQL/PostgreSQL)
- **Frontend**: Blade templates with Tailwind CSS (CDN)
- **Authentication**: Laravel's built-in authentication
- **Fonts**: Google Fonts (Playfair Display, Poppins)
- **Styling**: Custom CSS with gradients, animations, and glassmorphism

## 🏃 Running the Application

```bash
# Start the development server
php artisan serve

# Visit http://127.0.0.1:8000
```

## 🔒 Security Features

- Password hashing with bcrypt
- CSRF protection on all forms
- Session-based authentication
- Email validation and uniqueness
- Unique constraints to prevent duplicate couples
- Authorization checks on all sensitive actions
- Confirmation dialogs for destructive actions
- Cascade delete for data integrity

## 🎯 User Experience Highlights

- **Smooth Animations**: Floating hearts, button transforms, alert slide-ins
- **Visual Feedback**: Color-coded alerts (success, error, info)
- **Intuitive Navigation**: Clear buttons and links with hover states
- **Emotional Design**: Appropriate emoji usage and loving language
- **Responsive Layout**: Works on desktop, tablet, and mobile
- **Accessibility**: Clear labels, good contrast, readable fonts

---

Built with ❤️ using Laravel | Designed for Love 💕
