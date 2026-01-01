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
                    <a href="https://api.whatsapp.com/send?text=<?= urlencode($blog['title'] . ' ' . SITE_URL . '/blog/' . $blog['slug']) ?>" target="_blank" class="share-btn whatsapp" title="Share on WhatsApp">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                    <a href="https://www.pinterest.com/pin/create/button/?url=<?= urlencode(SITE_URL . '/blog/' . $blog['slug']) ?>&media=<?= urlencode(SITE_URL . $blog['featured_image']) ?>&description=<?= urlencode($blog['title']) ?>" target="_blank" class="share-btn pinterest" title="Share on Pinterest">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.966 1.406-5.966s-.359-.72-.359-1.781c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.261 7.929-7.261 4.162 0 7.398 2.967 7.398 6.93 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146 1.124.347 2.317.535 3.554.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/></svg>
                    </a>
                    <a href="https://www.reddit.com/submit?url=<?= urlencode(SITE_URL . '/blog/' . $blog['slug']) ?>&title=<?= urlencode($blog['title']) ?>" target="_blank" class="share-btn reddit" title="Share on Reddit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 11.5c0-1.65-1.35-3-3-3-.41 0-.78.11-1.12.27C18.15 7.03 15.54 6.03 12.63 6.03l1.11-4.73 3.61.77c.04.85.76 1.54 1.61 1.54 1.1 0 2-.9 2-2s-.9-2-2-2c-.51 0-.96.2-1.3.52l-4.14-.88a.5.5 0 00-.59.38l-1.24 5.29c-3 .02-5.69 1.03-7.39 2.74-.34-.16-.71-.27-1.12-.27-1.65 0-3 1.35-3 3 0 1.21.72 2.25 1.76 2.73-.01.09-.01.18-.01.27 0 2.22 2.05 4.19 5.34 5.32 1.35.46 2.87.71 4.41.71 1.54 0 3.06-.25 4.41-.71 3.29-1.13 5.34-3.1 5.34-5.32 0-.09 0-.18-.01-.27 1.04-.48 1.76-1.52 1.76-2.73zM7.03 13.5c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2zm9.64 5.3c-1.13 1.13-3.21 1.22-4.67 1.22s-3.54-.09-4.67-1.22a.501.501 0 01.71-.71c.71.71 2.37.81 3.96.81s3.25-.1 3.96-.81a.501.501 0 11.71.71zm-.34-3.3c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/></svg>
                    </a>
                    <a href="mailto:?subject=<?= urlencode($blog['title']) ?>&body=<?= urlencode('Check out this article: ' . SITE_URL . '/blog/' . $blog['slug']) ?>" class="share-btn email" title="Share via Email">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
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
