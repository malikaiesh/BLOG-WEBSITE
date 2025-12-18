<?php $pageTitle = 'Dashboard'; include __DIR__ . '/layout.php'; ?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value"><?= $stats['total_blogs'] ?></span>
            <span class="stat-label">Total Posts</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon green">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value"><?= $stats['published'] ?></span>
            <span class="stat-label">Published</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon orange">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value"><?= $stats['drafts'] ?></span>
            <span class="stat-label">Drafts</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon purple">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"></path>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value"><?= $stats['categories'] ?></span>
            <span class="stat-label">Categories</span>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <div class="dashboard-card">
        <div class="card-header">
            <h2>Recent Posts</h2>
            <a href="/admin/blogs" class="link">View All</a>
        </div>
        <div class="card-content">
            <?php if (empty($recentBlogs)): ?>
            <p class="empty-state">No posts yet. <a href="/admin/blogs/create">Create one</a></p>
            <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentBlogs as $blog): ?>
                    <tr>
                        <td><a href="/admin/blogs/edit/<?= $blog['id'] ?>"><?= htmlspecialchars($blog['title']) ?></a></td>
                        <td><span class="status-badge <?= $blog['status'] ?>"><?= ucfirst($blog['status']) ?></span></td>
                        <td><?= formatDate($blog['created_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="dashboard-card">
        <div class="card-header">
            <h2>Trending Posts</h2>
        </div>
        <div class="card-content">
            <?php if (empty($trending)): ?>
            <p class="empty-state">No trending posts yet</p>
            <?php else: ?>
            <ul class="trending-list">
                <?php foreach ($trending as $index => $post): ?>
                <li>
                    <span class="rank"><?= $index + 1 ?></span>
                    <div class="info">
                        <a href="/admin/blogs/edit/<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a>
                        <span class="views"><?= number_format($post['views']) ?> views</span>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="quick-actions">
    <h2>Quick Actions</h2>
    <div class="action-buttons">
        <a href="/admin/blogs/create" class="action-btn">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            New Post
        </a>
        <a href="/admin/categories" class="action-btn">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"></path>
            </svg>
            Manage Categories
        </a>
        <a href="/" target="_blank" class="action-btn">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="2" y1="12" x2="22" y2="12"></line>
                <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"></path>
            </svg>
            View Website
        </a>
    </div>
</div>

<?php include __DIR__ . '/layout-end.php'; ?>
