<?php
require_once __DIR__ . '/../config/init.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/') ?: '/';

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

if ($uri === '/') {
    $blogModel = new Blog();
    $categoryModel = new Category();
    $blogs = $blogModel->getAll(12, 0);
    $categories = $categoryModel->getWithCount();
    $trending = $blogModel->getTrending(5);
    include APP_PATH . '/views/home.php';
}
elseif ($uri === '/api/blogs') {
    $blogModel = new Blog();
    $offset = (int)($_GET['offset'] ?? 0);
    $limit = (int)($_GET['limit'] ?? 12);
    $blogs = $blogModel->getAll($limit, $offset);
    $total = $blogModel->count('published');
    json_response([
        'blogs' => $blogs,
        'hasMore' => ($offset + $limit) < $total
    ]);
}
elseif ($uri === '/api/search') {
    $blogModel = new Blog();
    $query = sanitize($_GET['q'] ?? '');
    $blogs = $blogModel->search($query);
    json_response(['blogs' => $blogs]);
}
elseif (preg_match('/^\/blog\/([a-z0-9-]+)$/', $uri, $matches)) {
    $blogModel = new Blog();
    $categoryModel = new Category();
    $blog = $blogModel->getBySlug($matches[1]);
    if (!$blog) {
        http_response_code(404);
        echo '404 - Blog not found';
        exit;
    }
    $blogModel->incrementViews($blog['id']);
    $related = $blogModel->getRelated($blog['category_id'], $blog['id']);
    $categories = $categoryModel->getAll();
    include APP_PATH . '/views/single.php';
}
elseif (preg_match('/^\/category\/([a-z0-9-]+)$/', $uri, $matches)) {
    $blogModel = new Blog();
    $categoryModel = new Category();
    $category = $categoryModel->getBySlug($matches[1]);
    if (!$category) {
        http_response_code(404);
        echo '404 - Category not found';
        exit;
    }
    $blogs = $blogModel->getByCategory($matches[1]);
    $categories = $categoryModel->getWithCount();
    include APP_PATH . '/views/category.php';
}
elseif ($uri === '/search') {
    $blogModel = new Blog();
    $categoryModel = new Category();
    $query = sanitize($_GET['q'] ?? '');
    $blogs = $blogModel->search($query);
    $categories = $categoryModel->getAll();
    include APP_PATH . '/views/search.php';
}
elseif ($uri === '/about') {
    include APP_PATH . '/views/pages/about.php';
}
elseif ($uri === '/contact') {
    include APP_PATH . '/views/pages/contact.php';
}
elseif ($uri === '/privacy') {
    include APP_PATH . '/views/pages/privacy.php';
}
elseif (strpos($uri, '/admin') === 0) {
    include __DIR__ . '/../admin/index.php';
}
else {
    http_response_code(404);
    include APP_PATH . '/views/404.php';
}
