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
$settingsModel = new Settings();

function runInterlinking($blogModel) {
    $blogs = $blogModel->getAllAdmin();
    foreach ($blogs as $targetBlog) {
        $content = $targetBlog['content'];
        $modified = false;
        foreach ($blogs as $sourceBlog) {
            if ($targetBlog['id'] === $sourceBlog['id']) continue;
            $title = $sourceBlog['title'];
            $url = SITE_URL . '/blog/' . $sourceBlog['slug'];
            $pattern = '/(?<!<a href=")(?<!">)\b' . preg_quote($title, '/') . '\b(?!<\/a>)/i';
            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, '<a href="' . $url . '">' . $title . '</a>', $content, 1);
                $modified = true;
            }
        }
        if ($modified) {
            $blogModel->update($targetBlog['id'], ['content' => $content, 'title' => $targetBlog['title']]);
        }
    }
}

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
        
        // Auto interlinking
        $settings = $settingsModel->getAll();
        if ($settings['auto_interlinking'] ?? false) {
            runInterlinking($blogModel);
        }
        
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
        
        // Auto interlinking
        $settings = $settingsModel->getAll();
        if ($settings['auto_interlinking'] ?? false) {
            runInterlinking($blogModel);
        }
        
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
elseif ($uri === '/settings') {
    $settings = $settingsModel->getAll();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!verify_csrf($_POST['csrf_token'] ?? '')) {
            die('CSRF token validation failed');
        }
        
        $data = [
            'site_name' => sanitize($_POST['site_name']),
            'site_description' => sanitize($_POST['site_description']),
            'site_keywords' => sanitize($_POST['site_keywords']),
            'footer_social_links' => $_POST['social']
        ];
        
        if (!empty($_FILES['logo']['name'])) {
            $upload = uploadImage($_FILES['logo']);
            if (isset($upload['path'])) {
                $data['logo_url'] = $upload['path'];
            }
        }
        
        if (!empty($_FILES['favicon']['name'])) {
            $upload = uploadImage($_FILES['favicon']);
            if (isset($upload['path'])) {
                $data['favicon_url'] = $upload['path'];
            }
        }
        
        $settingsModel->update($data);
        redirect('/admin/settings?success=1');
    }
    
    $pageTitle = 'Settings';
    include __DIR__ . '/views/settings.php';
}
elseif ($uri === '/custom-code') {
    $settings = $settingsModel->getAll();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!verify_csrf($_POST['csrf_token'] ?? '')) {
            die('CSRF token validation failed');
        }
        
        $data = [
            'custom_head_code' => $_POST['custom_head_code'],
            'custom_body_code' => $_POST['custom_body_code'],
            'custom_footer_code' => $_POST['custom_footer_code']
        ];
        
        $settingsModel->update($data);
        redirect('/admin/custom-code');
    }
    
    $pageTitle = 'Custom Code';
    include __DIR__ . '/views/custom-code.php';
}
elseif ($uri === '/seo') {
    $settings = $settingsModel->getAll();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!verify_csrf($_POST['csrf_token'] ?? '')) {
            die('CSRF token validation failed');
        }
        
        $data = [
            'seo_sitemap_status' => $_POST['seo_sitemap_status'],
            'seo_auto_schema' => $_POST['seo_auto_schema'],
            'seo_schema_type' => $_POST['seo_schema_type']
        ];
        
        $settingsModel->update($data);
        redirect('/admin/seo?success=1');
    }
    
    $pageTitle = 'SEO Optimization';
    include __DIR__ . '/views/seo.php';
}
elseif ($uri === '/webmaster-tools') {
    include __DIR__ . '/views/webmaster-tools.php';
}
elseif ($uri === '/interlinking') {
    include __DIR__ . '/views/interlinking.php';
}
elseif ($uri === '/quick-links') {
    include __DIR__ . '/views/quick-links.php';
}
else {
    redirect('/admin');
}
