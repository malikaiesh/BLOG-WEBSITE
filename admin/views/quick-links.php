<?php
require_once __DIR__ . '/../../config/init.php';
$quickLinkModel = new QuickLink();

$editLink = null;
if (isset($_GET['edit'])) {
    $editLink = $quickLinkModel->getById($_GET['edit']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        die('CSRF token validation failed');
    }
    
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create') {
        $quickLinkModel->create([
            'title' => sanitize($_POST['title']),
            'url' => sanitize($_POST['url']),
            'sort_order' => (int)$_POST['sort_order']
        ]);
    } elseif ($action === 'update' && isset($_POST['id'])) {
        $quickLinkModel->update($_POST['id'], [
            'title' => sanitize($_POST['title']),
            'url' => sanitize($_POST['url']),
            'sort_order' => (int)$_POST['sort_order']
        ]);
    } elseif ($action === 'delete' && isset($_POST['id'])) {
        $quickLinkModel->delete($_POST['id']);
    }
    
    redirect('/admin/quick-links');
}

$quickLinks = $quickLinkModel->getAll();
$pageTitle = 'Manage Quick Links';
ob_start();
?>

<div class="card">
    <div class="card-header">
        <h2><?= $editLink ? 'Edit Link' : 'Add New Link' ?></h2>
    </div>
    <form action="/admin/quick-links" method="POST" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
        <input type="hidden" name="action" value="<?= $editLink ? 'update' : 'create' ?>">
        <?php if ($editLink): ?>
            <input type="hidden" name="id" value="<?= $editLink['id'] ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label>Title (Anchor Text)</label>
            <input type="text" name="title" required placeholder="Link Title" value="<?= $editLink ? htmlspecialchars($editLink['title']) : '' ?>" style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div class="form-group" style="margin-top: 15px;">
            <label>URL</label>
            <input type="url" name="url" required placeholder="https://example.com" value="<?= $editLink ? htmlspecialchars($editLink['url']) : '' ?>" style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div class="form-group" style="margin-top: 15px;">
            <label>Sort Order</label>
            <input type="number" name="sort_order" value="<?= $editLink ? $editLink['sort_order'] : '0' ?>" style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div class="form-actions" style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="background: #e50914; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;"><?= $editLink ? 'Update Link' : 'Add Link' ?></button>
            <?php if ($editLink): ?>
                <a href="/admin/quick-links" class="btn btn-secondary" style="background: #6c757d; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none;">Cancel</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card" style="margin-top: 30px;">
    <div class="card-header">
        <h2>Existing Links</h2>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 12px; text-align: left;">Order</th>
                    <th style="padding: 12px; text-align: left;">Title</th>
                    <th style="padding: 12px; text-align: left;">URL</th>
                    <th style="padding: 12px; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quickLinks as $link): ?>
                <tr style="border-bottom: 1px solid #dee2e6;">
                    <td style="padding: 12px;"><?= $link['sort_order'] ?></td>
                    <td style="padding: 12px; font-weight: 500;"><?= htmlspecialchars($link['title']) ?></td>
                    <td style="padding: 12px;"><a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" style="color: #2196F3; text-decoration: none;"><?= htmlspecialchars($link['url']) ?></a></td>
                    <td style="padding: 12px;">
                        <div style="display: flex; gap: 8px;">
                            <a href="/admin/quick-links?edit=<?= $link['id'] ?>" class="btn btn-sm" style="background: #2196F3; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 12px;">Edit</a>
                            <form action="/admin/quick-links" method="POST" onsubmit="return confirm('Delete this link?')" style="display:inline;">
                                <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $link['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm" style="background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 12px;">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($quickLinks)): ?>
                <tr>
                    <td colspan="4" style="padding: 20px; text-align: center; color: #666;">No links found. Add your first link above!</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
