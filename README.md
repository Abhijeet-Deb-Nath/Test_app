# Love Journal

A Laravel web app for couples to share a love journal.

## Features
- User authentication
- Heart Connection (couple matching)
- Heart Separation (mutual consent breakup)
- Memory Treasures (shared journal with text/image/audio/video)
- Nostalgic Reflections

## Setup
```bash
composer install
php artisan migrate
php artisan storage:link
php artisan serve
```

Visit http://127.0.0.1:8000

## Tech
- Laravel 11.x
- SQLite
- Blade + Tailwind CSS
