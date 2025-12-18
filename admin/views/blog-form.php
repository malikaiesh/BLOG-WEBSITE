<?php 
$pageTitle = isset($blog) ? 'Edit Post' : 'Create Post'; 
include __DIR__ . '/layout.php'; 
?>

<form method="POST" enctype="multipart/form-data" class="blog-form">
    <div class="form-layout">
        <div class="form-main">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($blog['title'] ?? '') ?>" required class="large-input">
            </div>
            
            <div class="form-group">
                <label for="slug">Slug (URL)</label>
                <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($blog['slug'] ?? '') ?>" placeholder="Auto-generated from title">
            </div>
            
            <div class="form-group">
                <label for="excerpt">Excerpt</label>
                <textarea id="excerpt" name="excerpt" rows="3" placeholder="Short description for previews"><?= htmlspecialchars($blog['excerpt'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" rows="20" class="content-editor"><?= htmlspecialchars($blog['content'] ?? '') ?></textarea>
            </div>
            
            <div class="seo-section">
                <h3>SEO Settings</h3>
                <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" value="<?= htmlspecialchars($blog['meta_title'] ?? '') ?>" placeholder="Defaults to post title">
                </div>
                <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="2" placeholder="Recommended 150-160 characters"><?= htmlspecialchars($blog['meta_description'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
        
        <div class="form-sidebar">
            <div class="sidebar-card">
                <h3>Publish</h3>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="draft" <?= ($blog['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="published" <?= ($blog['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                    </select>
                </div>
                <div class="button-group">
                    <button type="submit" class="btn btn-primary btn-block"><?= isset($blog) ? 'Update' : 'Publish' ?></button>
                    <a href="/admin/blogs" class="btn btn-secondary btn-block">Cancel</a>
                </div>
            </div>
            
            <div class="sidebar-card">
                <h3>Category</h3>
                <div class="form-group">
                    <select id="category_id" name="category_id">
                        <option value="">No Category</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($blog['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="sidebar-card">
                <h3>Featured Image</h3>
                <?php if (!empty($blog['featured_image'])): ?>
                <div class="current-image">
                    <img src="<?= $blog['featured_image'] ?>" alt="Featured image">
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <input type="file" id="featured_image" name="featured_image" accept="image/*">
                </div>
            </div>
        </div>
    </div>
</form>

<?php include __DIR__ . '/layout-end.php'; ?>
