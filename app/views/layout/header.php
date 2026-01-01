<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'BlogTube - Modern Blog Platform' ?></title>
    <meta name="description" content="<?= $metaDescription ?? 'Discover amazing content on BlogTube' ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= SITE_URL . $_SERVER['REQUEST_URI'] ?>">
    
    <meta property="og:title" content="<?= $pageTitle ?? 'BlogTube' ?>">
    <meta property="og:description" content="<?= $metaDescription ?? 'Discover amazing content' ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= SITE_URL . $_SERVER['REQUEST_URI'] ?>">
    <?php if (isset($ogImage)): ?>
    <meta property="og:image" content="<?= SITE_URL . $ogImage ?>">
    <?php endif; ?>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <?php 
    $headerSettings = (new Settings())->getAll();
    echo $headerSettings['custom_head_code'] ?? ''; 
    
    // SEO & Schema
    if (($headerSettings['seo_auto_schema'] ?? 'enabled') === 'enabled') {
        if (isset($blog)) {
            echo generateSchema('BlogPosting', [
                'title' => $blog['title'],
                'excerpt' => $blog['excerpt'],
                'featured_image' => $blog['featured_image'],
                'author_name' => $blog['author_name'],
                'created_at' => $blog['created_at'],
                'updated_at' => $blog['updated_at']
            ]);
        } else {
            echo generateSchema('WebSite', [
                'site_name' => $headerSettings['site_name'] ?? 'BlogTube',
                'site_description' => $headerSettings['site_description'] ?? ''
            ]);
        }
    }
    ?>
</head>
<body>
    <?php echo $headerSettings['custom_body_code'] ?? ''; ?>
    <header class="main-header">
        <nav class="navbar">
            <a href="/" class="logo">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                </svg>
                <span>BlogTube</span>
            </a>
            
            <div class="search-container">
                <form action="/" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Search articles..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" class="search-input" id="searchInput">
                    <button type="submit" class="search-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="M21 21l-4.35-4.35"></path>
                        </svg>
                    </button>
                </form>
                <div class="search-suggestions" id="searchSuggestions"></div>
            </div>
            
            <div class="nav-actions">
                <button class="theme-toggle" id="themeToggle" title="Toggle theme">
                    <svg class="sun-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5"></circle>
                        <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"></path>
                    </svg>
                    <svg class="moon-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
                    </svg>
                </button>
                <a href="/admin" class="admin-link">Admin</a>
            </div>
        </nav>
    </header>
    
    <main class="main-content">
