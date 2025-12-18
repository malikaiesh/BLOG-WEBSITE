<?php 
$pageTitle = htmlspecialchars($blog['meta_title'] ?: $blog['title']) . ' - BlogTube';
$metaDescription = htmlspecialchars($blog['meta_description'] ?: excerpt($blog['content'], 160));
$ogImage = $blog['featured_image'];
include APP_PATH . '/views/layout/header.php'; 
?>

<div class="reading-progress" id="readingProgress"></div>

<div class="single-container">
    <article class="blog-article">
        <nav class="breadcrumb">
            <a href="/">Home</a>
            <?php if ($blog['category_name']): ?>
            <span>/</span>
            <a href="/category/<?= $blog['category_slug'] ?>"><?= htmlspecialchars($blog['category_name']) ?></a>
            <?php endif; ?>
            <span>/</span>
            <span><?= htmlspecialchars($blog['title']) ?></span>
        </nav>
        
        <header class="article-header">
            <?php if ($blog['category_name']): ?>
            <a href="/category/<?= $blog['category_slug'] ?>" class="article-category"><?= htmlspecialchars($blog['category_name']) ?></a>
            <?php endif; ?>
            
            <h1 class="article-title"><?= htmlspecialchars($blog['title']) ?></h1>
            
            <div class="article-meta">
                <div class="author-info">
                    <div class="author-avatar">
                        <?= strtoupper(substr($blog['author_name'] ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="author-details">
                        <span class="author-name"><?= htmlspecialchars($blog['author_name'] ?? 'Admin') ?></span>
                        <div class="meta-stats">
                            <span><?= formatDate($blog['created_at']) ?></span>
                            <span>•</span>
                            <span><?= readingTime($blog['content']) ?></span>
                            <span>•</span>
                            <span><?= number_format($blog['views']) ?> views</span>
                        </div>
                    </div>
                </div>
                
                <div class="article-actions">
                    <button class="action-btn like-btn" id="likeBtn" data-id="<?= $blog['id'] ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                        </svg>
                        <span>Like</span>
                    </button>
                    <button class="action-btn save-btn" id="saveBtn" data-id="<?= $blog['id'] ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"></path>
                        </svg>
                        <span>Save</span>
                    </button>
                    <button class="action-btn share-btn" id="shareBtn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="18" cy="5" r="3"></circle>
                            <circle cx="6" cy="12" r="3"></circle>
                            <circle cx="18" cy="19" r="3"></circle>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                        </svg>
                        <span>Share</span>
                    </button>
                </div>
            </div>
        </header>
        
        <?php if ($blog['featured_image']): ?>
        <figure class="article-image">
            <img src="<?= $blog['featured_image'] ?>" alt="<?= htmlspecialchars($blog['title']) ?>">
        </figure>
        <?php endif; ?>
        
        <div class="article-content">
            <?= $blog['content'] ?>
        </div>
        
        <div class="article-footer">
            <div class="share-section">
                <h4>Share this article</h4>
                <div class="share-buttons">
                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode(SITE_URL . '/blog/' . $blog['slug']) ?>&text=<?= urlencode($blog['title']) ?>" target="_blank" class="share-btn twitter">Twitter</a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(SITE_URL . '/blog/' . $blog['slug']) ?>" target="_blank" class="share-btn facebook">Facebook</a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode(SITE_URL . '/blog/' . $blog['slug']) ?>" target="_blank" class="share-btn linkedin">LinkedIn</a>
                </div>
            </div>
            
            <div class="author-box">
                <div class="author-avatar large">
                    <?= strtoupper(substr($blog['author_name'] ?? 'A', 0, 1)) ?>
                </div>
                <div class="author-info">
                    <h4><?= htmlspecialchars($blog['author_name'] ?? 'Admin') ?></h4>
                    <p><?= htmlspecialchars($blog['author_bio'] ?? 'Content creator and blogger.') ?></p>
                </div>
            </div>
        </div>
    </article>
    
    <?php if (!empty($related)): ?>
    <section class="related-posts">
        <h2>Related Articles</h2>
        <div class="related-grid">
            <?php foreach ($related as $post): ?>
            <article class="blog-card small">
                <a href="/blog/<?= $post['slug'] ?>" class="card-image">
                    <?php if ($post['featured_image']): ?>
                    <img src="<?= $post['featured_image'] ?>" alt="<?= htmlspecialchars($post['title']) ?>" loading="lazy">
                    <?php else: ?>
                    <div class="placeholder-image">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor" opacity="0.3">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/>
                        </svg>
                    </div>
                    <?php endif; ?>
                </a>
                <div class="card-content">
                    <a href="/blog/<?= $post['slug'] ?>" class="card-title"><?= htmlspecialchars($post['title']) ?></a>
                    <span class="card-date"><?= timeAgo($post['created_at']) ?></span>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</div>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "<?= htmlspecialchars($blog['title']) ?>",
    "datePublished": "<?= date('c', strtotime($blog['created_at'])) ?>",
    "dateModified": "<?= date('c', strtotime($blog['updated_at'])) ?>",
    "author": {
        "@type": "Person",
        "name": "<?= htmlspecialchars($blog['author_name'] ?? 'Admin') ?>"
    },
    "publisher": {
        "@type": "Organization",
        "name": "BlogTube"
    }
}
</script>

<?php include APP_PATH . '/views/layout/footer.php'; ?>
