<?php
/**
 * Database Seeder
 * Run this script to initialize the database with default data
 */

require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Settings.php';

echo "Starting database seeding...\n";

try {
    $db = Database::getInstance()->getConnection();

    // 1. Create Tables if they don't exist
    $sql = file_get_contents(__DIR__ . '/schema.sql');
    $db->exec($sql);
    echo "✓ Tables created or already exist.\n";

    // 2. Seed Admin User
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute(['admin@blog.com']);
    if (!$stmt->fetch()) {
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Admin', 'admin@blog.com', $password, 'admin']);
        echo "✓ Admin user created (admin@blog.com / admin123).\n";
    } else {
        echo "i Admin user already exists.\n";
    }

    // 3. Seed Default Settings
    $stmt = $db->query("SELECT COUNT(*) FROM site_settings");
    if ($stmt->fetchColumn() == 0) {
        $stmt = $db->prepare("INSERT INTO site_settings (key, value) VALUES (?, ?)");
        $stmt->execute(['site_config', json_encode([
            'site_name' => 'BlogTube',
            'site_description' => 'A professional PHP Blog Platform',
            'site_keywords' => 'blog, php, youtube-style',
            'footer_social_links' => [
                'facebook' => '#',
                'twitter' => '#',
                'instagram' => '#',
                'youtube' => '#'
            ]
        ])]);
        echo "✓ Default settings initialized.\n";
    } else {
        echo "i Site settings already exist.\n";
    }

    // 4. Seed Default Categories
    $stmt = $db->query("SELECT COUNT(*) FROM categories");
    if ($stmt->fetchColumn() == 0) {
        $categories = [
            ['Technology', 'technology', 'All things tech'],
            ['Lifestyle', 'lifestyle', 'Daily life and more'],
            ['Travel', 'travel', 'Explore the world']
        ];
        $stmt = $db->prepare("INSERT INTO categories (name, slug, description) VALUES (?, ?, ?)");
        foreach ($categories as $cat) {
            $stmt->execute($cat);
        }
        echo "✓ Default categories created.\n";
    }

    echo "\nSeeding completed successfully!\n";

} catch (Exception $e) {
    echo "\nError during seeding: " . $e->getMessage() . "\n";
    exit(1);
}
