<?php 
$pageTitle = 'BlogTube - Modern Blog Platform';
$metaDescription = 'Discover amazing articles, tutorials, and insights on BlogTube';
include APP_PATH . '/views/layout/header.php'; 
?>

<div class="home-container">
    <aside class="sidebar">
        <div class="sidebar-section">
            <h3>Categories</h3>
            <ul class="category-list">
                <?php foreach ($categories as $cat): ?>
                <li>
                    <a href="/category/<?= $cat['slug'] ?>">
                        <span class="cat-name"><?= htmlspecialchars($cat['name']) ?></span>
                        <span class="cat-count"><?= $cat['post_count'] ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <div class="sidebar-section">
            <h3>Trending</h3>
            <ul class="trending-list">
                <?php foreach ($trending as $index => $post): ?>
                <li>
                    <a href="/blog/<?= $post['slug'] ?>">
                        <span class="trend-num"><?= $index + 1 ?></span>
                        <div class="trend-info">
                            <span class="trend-title"><?= htmlspecialchars($post['title']) ?></span>
                            <span class="trend-views"><?= number_format($post['views']) ?> views</span>
                        </div>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </aside>
    
    <section class="main-feed">
        <div class="feed-header">
            <h1>Latest Articles</h1>
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="latest">Latest</button>
                <button class="filter-tab" data-filter="popular">Popular</button>
                <button class="filter-tab" data-filter="trending">Trending</button>
            </div>
        </div>
        
        <div class="blog-grid" id="blogGrid">
            <?php if (empty($blogs)): ?>
            <div class="no-posts">
                <h2>No posts yet</h2>
                <p>Check back soon for amazing content!</p>
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
                    <?php if ($blog['category_name']): ?>
                    <span class="category-badge"><?= htmlspecialchars($blog['category_name']) ?></span>
                    <?php endif; ?>
                </a>
                <div class="card-content">
                    <a href="/blog/<?= $blog['slug'] ?>" class="card-title">
                        <?= htmlspecialchars($blog['title']) ?>
                    </a>
                    <p class="card-excerpt"><?= excerpt($blog['excerpt'] ?: $blog['content'], 100) ?></p>
                    <div class="card-meta">
                        <span class="author"><?= htmlspecialchars($blog['author_name'] ?? 'Admin') ?></span>
                        <span class="dot">•</span>
                        <span class="date"><?= timeAgo($blog['created_at']) ?></span>
                        <span class="dot">•</span>
                        <span class="reading-time"><?= readingTime($blog['content']) ?></span>
                    </div>
                    <div class="card-stats">
                        <span class="views">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            <?= number_format($blog['views']) ?>
                        </span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="load-more-container">
            <button class="load-more-btn" id="loadMoreBtn" data-offset="12">
                <span class="btn-text">Load More</span>
                <span class="btn-loader"></span>
            </button>
        </div>
        
        <div class="skeleton-container" id="skeletonLoader" style="display: none;">
            <?php for ($i = 0; $i < 4; $i++): ?>
            <div class="blog-card skeleton">
                <div class="skeleton-image"></div>
                <div class="skeleton-content">
                    <div class="skeleton-title"></div>
                    <div class="skeleton-text"></div>
                    <div class="skeleton-meta"></div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </section>
</div>

<?php include APP_PATH . '/views/layout/footer.php'; ?>
