<?php
require_once __DIR__ . '/../config/database.php';

$db = Database::getInstance()->getConnection();

echo "Running database migrations...\n";

try {
    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(50) DEFAULT 'author',
            bio TEXT,
            avatar VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS categories (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) UNIQUE NOT NULL,
            description TEXT
        );

        CREATE TABLE IF NOT EXISTS blogs (
            id SERIAL PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            slug VARCHAR(255) UNIQUE NOT NULL,
            excerpt TEXT,
            content TEXT NOT NULL,
            featured_image VARCHAR(255),
            category_id INTEGER REFERENCES categories(id) ON DELETE SET NULL,
            author_id INTEGER REFERENCES users(id) ON DELETE SET NULL,
            status VARCHAR(50) DEFAULT 'draft',
            views INTEGER DEFAULT 0,
            meta_title VARCHAR(255),
            meta_description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS site_settings (
            id SERIAL PRIMARY KEY,
            key VARCHAR(255) UNIQUE NOT NULL,
            value TEXT,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS quick_links (
            id SERIAL PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            url VARCHAR(500) NOT NULL,
            sort_order INTEGER DEFAULT 0
        );

        CREATE TABLE IF NOT EXISTS custom_code (
            id SERIAL PRIMARY KEY,
            location VARCHAR(50) NOT NULL,
            code TEXT,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");

    echo "Tables created successfully!\n";

    $existingSettings = $db->query("SELECT COUNT(*) as count FROM site_settings")->fetch();
    if ($existingSettings['count'] == 0) {
        echo "Inserting default settings...\n";
        $db->exec("
            INSERT INTO site_settings (key, value) VALUES
            ('site_name', 'Modern Blog'),
            ('site_tagline', 'Explore ideas that matter'),
            ('footer_copyright', '© 2026 Modern Blog. All rights reserved.'),
            ('footer_social_links', '{\"twitter\": \"#\", \"facebook\": \"#\", \"instagram\": \"#\", \"linkedin\": \"#\"}'),
            ('meta_title', 'Modern Blog - Fresh Perspectives'),
            ('meta_description', 'A modern blog covering technology, travel, lifestyle and more.')
        ");
        echo "Default settings inserted!\n";
    }

    $existingCode = $db->query("SELECT COUNT(*) as count FROM custom_code")->fetch();
    if ($existingCode['count'] == 0) {
        echo "Inserting default custom code entries...\n";
        $db->exec("
            INSERT INTO custom_code (location, code) VALUES
            ('header', ''),
            ('footer', '')
        ");
        echo "Default custom code entries inserted!\n";
    }

    echo "Migration completed successfully!\n";

} catch (Exception $e) {
    die("Migration failed: " . $e->getMessage() . "\n");
}
