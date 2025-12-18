<?php $pageTitle = 'Blog Posts'; include __DIR__ . '/layout.php'; ?>

<div class="page-actions">
    <a href="/admin/blogs/create" class="btn btn-primary">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        New Post
    </a>
</div>

<?php if (empty($blogs)): ?>
<div class="empty-state-large">
    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path>
        <polyline points="14 2 14 8 20 8"></polyline>
    </svg>
    <h2>No blog posts yet</h2>
    <p>Create your first blog post to get started</p>
    <a href="/admin/blogs/create" class="btn btn-primary">Create Post</a>
</div>
<?php else: ?>
<div class="table-container">
    <table class="data-table full-width">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Status</th>
                <th>Views</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($blogs as $blog): ?>
            <tr>
                <td>
                    <div class="blog-title-cell">
                        <?php if ($blog['featured_image']): ?>
                        <img src="<?= $blog['featured_image'] ?>" alt="" class="thumb">
                        <?php else: ?>
                        <div class="thumb placeholder"></div>
                        <?php endif; ?>
                        <a href="/admin/blogs/edit/<?= $blog['id'] ?>"><?= htmlspecialchars($blog['title']) ?></a>
                    </div>
                </td>
                <td><?= htmlspecialchars($blog['category_name'] ?? '-') ?></td>
                <td><?= htmlspecialchars($blog['author_name'] ?? 'Admin') ?></td>
                <td><span class="status-badge <?= $blog['status'] ?>"><?= ucfirst($blog['status']) ?></span></td>
                <td><?= number_format($blog['views']) ?></td>
                <td><?= formatDate($blog['created_at']) ?></td>
                <td>
                    <div class="action-buttons-inline">
                        <a href="/blog/<?= $blog['slug'] ?>" target="_blank" class="icon-btn" title="View">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </a>
                        <a href="/admin/blogs/edit/<?= $blog['id'] ?>" class="icon-btn" title="Edit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                        <a href="/admin/blogs/delete/<?= $blog['id'] ?>" class="icon-btn danger" title="Delete" onclick="return confirm('Are you sure you want to delete this post?')">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                            </svg>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php include __DIR__ . '/layout-end.php'; ?>
