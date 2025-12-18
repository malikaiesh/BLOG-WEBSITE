<?php
require_once __DIR__ . '/../config/init.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/admin', '', $uri);
$uri = rtrim($uri, '/') ?: '/';

header('Cache-Control: no-cache, no-store, must-revalidate');

if ($uri === '/login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        $userModel = new User();
        $user = $userModel->authenticate($email, $password);
        
        if ($user) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['name'];
            $_SESSION['admin_role'] = $user['role'];
            redirect('/admin');
        } else {
            $error = 'Invalid email or password';
        }
    }
    include __DIR__ . '/views/login.php';
    exit;
}

if ($uri === '/logout') {
    session_destroy();
    redirect('/admin/login');
}

requireLogin();

$blogModel = new Blog();
$categoryModel = new Category();
$userModel = new User();

if ($uri === '/' || $uri === '') {
    $stats = [
        'total_blogs' => $blogModel->count(),
        'published' => $blogModel->count('published'),
        'drafts' => $blogModel->count('draft'),
        'categories' => count($categoryModel->getAll())
    ];
    $recentBlogs = $blogModel->getAll(5, 0);
    $trending = $blogModel->getTrending(5);
    include __DIR__ . '/views/dashboard.php';
}
elseif ($uri === '/blogs') {
    $blogs = $blogModel->getAllAdmin();
    include __DIR__ . '/views/blogs.php';
}
elseif ($uri === '/blogs/create') {
    $categories = $categoryModel->getAll();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!verify_csrf($_POST['csrf_token'] ?? '')) {
            die('CSRF token validation failed');
        }
        $data = [
            'title' => sanitize($_POST['title']),
            'slug' => sanitize($_POST['slug']) ?: generateSlug($_POST['title']),
            'excerpt' => sanitize($_POST['excerpt']),
            'content' => $_POST['content'],
            'category_id' => $_POST['category_id'] ?: null,
            'status' => $_POST['status'],
            'author_id' => $_SESSION['admin_id'],
            'meta_title' => sanitize($_POST['meta_title']),
            'meta_description' => sanitize($_POST['meta_description'])
        ];
        
        if (!empty($_FILES['featured_image']['name'])) {
            $upload = uploadImage($_FILES['featured_image']);
            if (isset($upload['path'])) {
                $data['featured_image'] = $upload['path'];
            }
        }
        
        $blogModel->create($data);
        redirect('/admin/blogs');
    }
    
    include __DIR__ . '/views/blog-form.php';
}
elseif (preg_match('/^\/blogs\/edit\/(\d+)$/', $uri, $matches)) {
    $blog = $blogModel->getById($matches[1]);
    if (!$blog) redirect('/admin/blogs');
    
    $categories = $categoryModel->getAll();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!verify_csrf($_POST['csrf_token'] ?? '')) {
            die('CSRF token validation failed');
        }
        $data = [
            'title' => sanitize($_POST['title']),
            'slug' => sanitize($_POST['slug']) ?: generateSlug($_POST['title']),
            'excerpt' => sanitize($_POST['excerpt']),
            'content' => $_POST['content'],
            'category_id' => $_POST['category_id'] ?: null,
            'status' => $_POST['status'],
            'meta_title' => sanitize($_POST['meta_title']),
            'meta_description' => sanitize($_POST['meta_description'])
        ];
        
        if (!empty($_FILES['featured_image']['name'])) {
            $upload = uploadImage($_FILES['featured_image']);
            if (isset($upload['path'])) {
                $data['featured_image'] = $upload['path'];
            }
        }
        
        $blogModel->update($matches[1], $data);
        redirect('/admin/blogs');
    }
    
    include __DIR__ . '/views/blog-form.php';
}
elseif (preg_match('/^\/blogs\/delete\/(\d+)$/', $uri, $matches)) {
    if (!verify_csrf($_GET['token'] ?? '')) {
        die('CSRF token validation failed');
    }
    $blogModel->delete($matches[1]);
    redirect('/admin/blogs');
}
elseif ($uri === '/categories') {
    $categories = $categoryModel->getWithCount();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!verify_csrf($_POST['csrf_token'] ?? '')) {
            die('CSRF token validation failed');
        }
        $action = $_POST['action'] ?? '';
        
        if ($action === 'create') {
            $categoryModel->create([
                'name' => sanitize($_POST['name']),
                'description' => sanitize($_POST['description'])
            ]);
        } elseif ($action === 'update' && isset($_POST['id'])) {
            $categoryModel->update($_POST['id'], [
                'name' => sanitize($_POST['name']),
                'description' => sanitize($_POST['description'])
            ]);
        } elseif ($action === 'delete' && isset($_POST['id'])) {
            $categoryModel->delete($_POST['id']);
        }
        
        redirect('/admin/categories');
    }
    
    include __DIR__ . '/views/categories.php';
}
else {
    redirect('/admin');
}
