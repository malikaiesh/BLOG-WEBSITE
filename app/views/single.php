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
                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode(SITE_URL . '/blog/' . $blog['slug']) ?>&text=<?= urlencode($blog['title']) ?>" target="_blank" class="share-btn twitter" title="Share on Twitter">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(SITE_URL . '/blog/' . $blog['slug']) ?>" target="_blank" class="share-btn facebook" title="Share on Facebook">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode(SITE_URL . '/blog/' . $blog['slug']) ?>" target="_blank" class="share-btn linkedin" title="Share on LinkedIn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.2225 0z"/></svg>
                    </a>
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
