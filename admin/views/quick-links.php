<?php
$pageTitle = 'Manage Quick Links';
require_once __DIR__ . '/../../config/init.php';
$quickLinkModel = new QuickLink();

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
        <h2>Add New Link</h2>
    </div>
    <form action="/admin/quick-links" method="POST" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
        <input type="hidden" name="action" value="create">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" required placeholder="Link Title">
        </div>
        <div class="form-group">
            <label>URL</label>
            <input type="url" name="url" required placeholder="https://example.com">
        </div>
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" name="sort_order" value="0">
        </div>
        <button type="submit" class="btn btn-primary">Add Link</button>
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
                <td><a href="<?= htmlspecialchars($link['url']) ?>" target="_blank"><?= htmlspecialchars($link['url']) ?></a></td>
                <td>
                    <form action="/admin/quick-links" method="POST" onsubmit="return confirm('Delete this link?')">
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
