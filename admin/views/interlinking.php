<?php 
$pageTitle = 'Blog Interlinking';
include __DIR__ . '/layout.php'; 

$settingsModel = new Settings();
$blogModel = new Blog();
$settings = $settingsModel->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        die('CSRF token validation failed');
    }
    
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_settings') {
        $data = [
            'auto_interlinking' => isset($_POST['auto_interlinking'])
        ];
        $settingsModel->update($data);
        redirect('/admin/interlinking?success=1');
    }
    
    if ($action === 'run_manual') {
        // Simple interlinking logic: find matching titles in content
        $blogs = $blogModel->getAllAdmin();
        $processedCount = 0;
        
        foreach ($blogs as $targetBlog) {
            $content = $targetBlog['content'];
            $modified = false;
            
            foreach ($blogs as $sourceBlog) {
                if ($targetBlog['id'] === $sourceBlog['id']) continue;
                
                $title = $sourceBlog['title'];
                $url = SITE_URL . '/blog/' . $sourceBlog['slug'];
                
                // Avoid double linking and link only once per keyword
                $pattern = '/(?<!<a href=")(?<!">)\b' . preg_quote($title, '/') . '\b(?!<\/a>)/i';
                if (preg_match($pattern, $content)) {
                    $content = preg_replace($pattern, '<a href="' . $url . '">' . $title . '</a>', $content, 1);
                    $modified = true;
                }
            }
            
            if ($modified) {
                $blogModel->update($targetBlog['id'], ['content' => $content, 'title' => $targetBlog['title']]); // Simple update
                $processedCount++;
            }
        }
        redirect('/admin/interlinking?processed=' . $processedCount);
    }
}
?>

<div class="card">
    <div class="card-header">
        <h2>Blog Interlinking</h2>
    </div>
    <div class="card-content">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert success" style="background: #e8f5e9; color: #2e7d32; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                Settings updated successfully!
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['processed'])): ?>
            <div class="alert info" style="background: #e3f2fd; color: #1976d2; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                Manual interlinking completed. <?= (int)$_GET['processed'] ?> articles updated.
            </div>
        <?php endif; ?>

        <form action="/admin/interlinking" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="hidden" name="action" value="update_settings">
            
            <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-bottom: 24px;">
                <input type="checkbox" name="auto_interlinking" id="auto_interlinking" <?= ($settings['auto_interlinking'] ?? false) ? 'checked' : '' ?> style="width: 20px; height: 20px;">
                <label for="auto_interlinking" style="font-weight: 600;">Enable Automatic Interlinking on Publish</label>
            </div>
            
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
        
        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--border-color);">
            <h3>Manual Interlinking</h3>
            <p class="text-secondary" style="margin-bottom: 20px;">Click the button below to scan all existing blog posts and insert links where article titles match keywords in other articles.</p>
            
            <form action="/admin/interlinking" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="action" value="run_manual">
                <button type="submit" class="btn btn-secondary" style="background: #6c757d; color: white;">Run Manual Interlinking Now</button>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layout-end.php'; ?>