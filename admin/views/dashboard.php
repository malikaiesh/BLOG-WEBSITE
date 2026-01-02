<?php $pageTitle = 'Dashboard'; include __DIR__ . '/layout.php'; ?>

<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; margin-bottom: 24px;">
    <div class="stat-card" style="padding: 12px;">
        <div class="stat-icon cyan" style="width: 32px; height: 32px; padding: 6px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 00-3-3.87"></path>
                <path d="M16 3.13a4 4 0 010 7.75"></path>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" style="font-size: 1.2rem;">1,284</span>
            <span class="stat-label" style="font-size: 0.75rem;">Active Users</span>
        </div>
    </div>

    <div class="stat-card" style="padding: 12px;">
        <div class="stat-icon green" style="width: 32px; height: 32px; padding: 6px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <line x1="19" y1="8" x2="19" y2="14"></line>
                <line x1="16" y1="11" x2="22" y2="11"></line>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" style="font-size: 1.2rem;">342</span>
            <span class="stat-label" style="font-size: 0.75rem;">New Users</span>
        </div>
    </div>

    <div class="stat-card" style="padding: 12px;">
        <div class="stat-icon blue" style="width: 32px; height: 32px; padding: 6px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 00-3-3.87"></path>
                <path d="M16 3.13a4 4 0 010 7.75"></path>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" style="font-size: 1.2rem;">942</span>
            <span class="stat-label" style="font-size: 0.75rem;">Returning Users</span>
        </div>
    </div>

    <div class="stat-card" style="padding: 12px;">
        <div class="stat-icon red" style="width: 32px; height: 32px; padding: 6px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"></path>
                <path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"></path>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" style="font-size: 1.2rem;">45,201</span>
            <span class="stat-label" style="font-size: 0.75rem;">Page Views</span>
        </div>
    </div>

    <div class="stat-card" style="padding: 12px;">
        <div class="stat-icon indigo" style="width: 32px; height: 32px; padding: 6px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"></path>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" style="font-size: 1.2rem;">3.2%</span>
            <span class="stat-label" style="font-size: 0.75rem;">CTR</span>
        </div>
    </div>

    <div class="stat-card" style="padding: 12px;">
        <div class="stat-icon yellow" style="width: 32px; height: 32px; padding: 6px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" style="font-size: 1.2rem;">4m 32s</span>
            <span class="stat-label" style="font-size: 0.75rem;">Stay Time</span>
        </div>
    </div>

    <div class="stat-card" style="padding: 12px;">
        <div class="stat-icon pink" style="width: 32px; height: 32px; padding: 6px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="3" y1="9" x2="21" y2="9"></line>
                <line x1="9" y1="21" x2="9" y2="9"></line>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" style="font-size: 1.2rem;"><?= $stats['pages_count'] ?></span>
            <span class="stat-label" style="font-size: 0.75rem;">Pages</span>
        </div>
    </div>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 24px;">
    <div class="stat-card" style="padding: 12px;">
        <div class="stat-icon blue" style="width: 32px; height: 32px; padding: 6px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" style="font-size: 1.2rem;"><?= $stats['total_blogs'] ?></span>
            <span class="stat-label" style="font-size: 0.75rem;">Total Posts</span>
        </div>
    </div>
    
    <div class="stat-card" style="padding: 12px;">
        <div class="stat-icon green" style="width: 32px; height: 32px; padding: 6px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" style="font-size: 1.2rem;"><?= $stats['published'] ?></span>
            <span class="stat-label" style="font-size: 0.75rem;">Published</span>
        </div>
    </div>
    
    <div class="stat-card" style="padding: 12px;">
        <div class="stat-icon orange" style="width: 32px; height: 32px; padding: 6px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" style="font-size: 1.2rem;"><?= $stats['drafts'] ?></span>
            <span class="stat-label" style="font-size: 0.75rem;">Drafts</span>
        </div>
    </div>
    
    <div class="stat-card" style="padding: 12px;">
        <div class="stat-icon purple" style="width: 32px; height: 32px; padding: 6px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"></path>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value" style="font-size: 1.2rem;"><?= $stats['categories'] ?></span>
            <span class="stat-label" style="font-size: 0.75rem;">Categories</span>
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
