<?php
$pageTitle = 'Manage Quick Links';
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
include __DIR__ . '/layout.php';
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
            <input type="text" name="title" required placeholder="Link Title" value="<?= $editLink ? htmlspecialchars($editLink['title']) : '' ?>">
        </div>
        <div class="form-group">
            <label>URL</label>
            <input type="url" name="url" required placeholder="https://example.com" value="<?= $editLink ? htmlspecialchars($editLink['url']) : '' ?>">
        </div>
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" name="sort_order" value="<?= $editLink ? $editLink['sort_order'] : '0' ?>">
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $editLink ? 'Update Link' : 'Add Link' ?></button>
            <?php if ($editLink): ?>
                <a href="/admin/quick-links" class="btn btn-secondary">Cancel</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card mt-20">
    <div class="card-header">
        <h2>Existing Links</h2>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Order</th>
                <th>Title</th>
                <th>URL</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($quickLinks as $link): ?>
            <tr>
                <td><?= $link['sort_order'] ?></td>
                <td><?= htmlspecialchars($link['title']) ?></td>
                <td><a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" class="text-link"><?= htmlspecialchars($link['url']) ?></a></td>
                <td class="table-actions">
                    <a href="/admin/quick-links?edit=<?= $link['id'] ?>" class="btn btn-sm btn-primary" style="background: #2196F3; border-color: #2196F3;">Edit</a>
                    <form action="/admin/quick-links" method="POST" onsubmit="return confirm('Delete this link?')" style="display:inline;">
                        <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $link['id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
.text-link { color: #2196F3; text-decoration: none; }
.text-link:hover { text-decoration: underline; }
.mt-20 { margin-top: 20px; }
.table-actions { display: flex; gap: 5px; }
.btn-secondary { background: #6c757d; color: white; border: none; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block; font-size: 14px; }
.form-actions { display: flex; gap: 10px; align-items: center; }
</style>
