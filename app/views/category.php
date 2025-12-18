<?php 
$pageTitle = htmlspecialchars($category['name']) . ' - BlogTube';
$metaDescription = $category['description'] ?: 'Browse articles in ' . $category['name'];
include APP_PATH . '/views/layout/header.php'; 
?>

<div class="category-container">
    <header class="category-header">
        <nav class="breadcrumb">
            <a href="/">Home</a>
            <span>/</span>
            <span><?= htmlspecialchars($category['name']) ?></span>
        </nav>
        <h1><?= htmlspecialchars($category['name']) ?></h1>
        <?php if ($category['description']): ?>
        <p class="category-desc"><?= htmlspecialchars($category['description']) ?></p>
        <?php endif; ?>
    </header>
    
    <div class="blog-grid">
        <?php if (empty($blogs)): ?>
        <div class="no-posts">
            <h2>No posts in this category yet</h2>
            <p>Check back soon for amazing content!</p>
            <a href="/" class="btn">Back to Home</a>
        </div>
        <?php else: ?>
        <?php foreach ($blogs as $blog): ?>
        <article class="blog-card">
            <a href="/blog/<?= $blog['slug'] ?>" class="card-image">
                <?php if ($blog['featured_image']): ?>
                <img src="<?= $blog['featured_image'] ?>" alt="<?= htmlspecialchars($blog['title']) ?>" loading="lazy">
                <?php else: ?>
                <div class="placeholder-image">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" opacity="0.3">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/>
                    </svg>
                </div>
                <?php endif; ?>
            </a>
            <div class="card-content">
                <a href="/blog/<?= $blog['slug'] ?>" class="card-title">
                    <?= htmlspecialchars($blog['title']) ?>
                </a>
                <p class="card-excerpt"><?= excerpt($blog['excerpt'] ?: $blog['content'], 100) ?></p>
                <div class="card-meta">
                    <span class="date"><?= timeAgo($blog['created_at']) ?></span>
                    <span class="dot">•</span>
                    <span class="reading-time"><?= readingTime($blog['content']) ?></span>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include APP_PATH . '/views/layout/footer.php'; ?>
