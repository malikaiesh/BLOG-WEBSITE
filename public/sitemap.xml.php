<?php
require_once __DIR__ . '/../config/init.php';

$blogModel = new Blog();
$categoryModel = new Category();

$blogs = $blogModel->getAll(1000);
$categories = $categoryModel->getAll();

header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

// Home
echo '  <url>' . PHP_EOL;
echo '    <loc>' . SITE_URL . '/</loc>' . PHP_EOL;
echo '    <priority>1.0</priority>' . PHP_EOL;
echo '  </url>' . PHP_EOL;

// Blogs
foreach ($blogs as $blog) {
    echo '  <url>' . PHP_EOL;
    echo '    <loc>' . SITE_URL . '/blog/' . $blog['slug'] . '</loc>' . PHP_EOL;
    echo '    <lastmod>' . date('Y-m-d', strtotime($blog['updated_at'])) . '</lastmod>' . PHP_EOL;
    echo '    <priority>0.8</priority>' . PHP_EOL;
    echo '  </url>' . PHP_EOL;
}

// Categories
foreach ($categories as $cat) {
    echo '  <url>' . PHP_EOL;
    echo '    <loc>' . SITE_URL . '/category/' . $cat['slug'] . '</loc>' . PHP_EOL;
    echo '    <priority>0.5</priority>' . PHP_EOL;
    echo '  </url>' . PHP_EOL;
}

echo '</urlset>';