# BlogTube - PHP Blog CMS

## Overview
A professional, scalable, SEO-optimized Blog Website with YouTube-style card layout and admin panel. Built with PHP using MVC architecture with PostgreSQL database.

## Project Structure
```
/app
  /controllers     # Request handlers
  /models          # Database models (Blog, Category, User)
  /views           # PHP templates
  /helpers         # Utility functions
  /middleware      # Authentication, etc.
/public
  /assets          # CSS, JS, images
  /uploads         # User uploaded files
  index.php        # Main router
/admin
  /controllers     # Admin request handlers
  /views           # Admin templates
  /assets          # Admin CSS/JS
  index.php        # Admin router
/config
  database.php     # Database connection
  init.php         # App initialization
/storage
  /cache           # File cache
  /logs            # Error logs
```

## Key Features
- **YouTube-style Homepage**: Grid-based blog cards with categories, trending sidebar
- **AJAX Load More**: Dynamic content loading with skeleton loaders
- **Admin Panel**: Blog/category management, SEO settings
- **Dark Mode**: Theme toggle with localStorage persistence
- **SEO Optimized**: Meta tags, JSON-LD schema, clean URLs
- **Responsive**: Mobile-first design

## Running the Project
The project runs on PHP's built-in server:
```
cd public && php -S 0.0.0.0:5000
```

## Database
PostgreSQL with tables. To initialize or reset the database, run:
```bash
php database/seed.php
```

Tables:
- `users` - Admin accounts
- `categories` - Blog categories
- `blogs` - Blog posts with SEO fields
- `site_settings` - Global configuration, logos, and verification codes
- `quick_links` - "More Website" sidebar links
- `custom_code` - Header/Body/Footer script injections

## Admin Access
- URL: `/admin`
- Email: `admin@blogtube.com`
- Password: `password`

## Recent Changes
- December 18, 2025: Initial build with full CMS functionality
