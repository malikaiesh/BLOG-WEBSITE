<?php
$pageTitle = 'Manage Quick Links';
include __DIR__ . '/layout.php';

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
?>

<div class="card" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <div class="card-header">
        <h2 style="margin: 0 0 20px 0;"><?= $editLink ? 'Edit Link' : 'Add New Link' ?></h2>
    </div>
    <form action="/admin/quick-links" method="POST" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
        <input type="hidden" name="action" value="<?= $editLink ? 'update' : 'create' ?>">
        <?php if ($editLink): ?>
            <input type="hidden" name="id" value="<?= $editLink['id'] ?>">
        <?php endif; ?>
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; margin-bottom: 5px;">Title (Anchor Text)</label>
            <input type="text" name="title" required placeholder="Link Title" value="<?= $editLink ? htmlspecialchars($editLink['title']) : '' ?>" style="display: block; width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; margin-bottom: 5px;">URL</label>
            <input type="url" name="url" required placeholder="https://example.com" value="<?= $editLink ? htmlspecialchars($editLink['url']) : '' ?>" style="display: block; width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; margin-bottom: 5px;">Sort Order</label>
            <input type="number" name="sort_order" value="<?= $editLink ? $editLink['sort_order'] : '0' ?>" style="display: block; width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
        </div>
        <div class="form-actions" style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="background: #e50914; color: white; border: none; padding: 12px 24px; border-radius: 4px; cursor: pointer; font-weight: 600;"><?= $editLink ? 'Update Link' : 'Add Link' ?></button>
            <?php if ($editLink): ?>
                <a href="/admin/quick-links" class="btn btn-secondary" style="background: #6c757d; color: white; padding: 12px 24px; border-radius: 4px; text-decoration: none; font-weight: 600; display: inline-block;">Cancel</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card" style="margin-top: 30px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <div class="card-header">
        <h2 style="margin: 0 0 20px 0;">Existing Links</h2>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table" style="width: 100%; border-collapse: collapse;">
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
                    <td style="padding: 12px;"><a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" style="color: #2196F3; text-decoration: none; word-break: break-all;"><?= htmlspecialchars($link['url']) ?></a></td>
                    <td style="padding: 12px;">
                        <div style="display: flex; gap: 8px;">
                            <a href="/admin/quick-links?edit=<?= $link['id'] ?>" class="btn btn-sm" style="background: #2196F3; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px;">Edit</a>
                            <form action="/admin/quick-links" method="POST" onsubmit="return confirm('Delete this link?')" style="display:inline;">
                                <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $link['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm" style="background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px;">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($quickLinks)): ?>
                <tr>
                    <td colspan="4" style="padding: 30px; text-align: center; color: #666; font-style: italic;">No links found. Add your first link above!</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/layout-end.php'; ?>
