<?php
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
            'url' => $_POST['url'], // Use raw URL to allow custom links
            'sort_order' => (int)$_POST['sort_order']
        ]);
        redirect('/admin/quick-links?success=1');
    } elseif ($action === 'update' && isset($_POST['id'])) {
        $quickLinkModel->update($_POST['id'], [
            'title' => sanitize($_POST['title']),
            'url' => $_POST['url'],
            'sort_order' => (int)$_POST['sort_order']
        ]);
        redirect('/admin/quick-links?updated=1');
    } elseif ($action === 'delete' && isset($_POST['id'])) {
        $quickLinkModel->delete($_POST['id']);
        redirect('/admin/quick-links?deleted=1');
    }
}

$quickLinks = $quickLinkModel->getAll();
$pageTitle = 'Manage Quick Links';
include __DIR__ . '/layout.php';
?>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h2><?= $editLink ? 'Update Quick Link' : 'Add New Quick Link' ?></h2>
        <?php if ($editLink): ?>
            <a href="/admin/quick-links" class="btn btn-secondary">Back to List</a>
        <?php endif; ?>
    </div>
    <div class="card-content">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert success" style="background: #e8f5e9; color: #2e7d32; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                Link added successfully!
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['updated'])): ?>
            <div class="alert success" style="background: #e8f5e9; color: #2e7d32; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                Link updated successfully!
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert info" style="background: #e3f2fd; color: #1976d2; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                Link deleted successfully!
            </div>
        <?php endif; ?>

        <form action="/admin/quick-links" method="POST" class="admin-form" style="display: grid; grid-template-columns: 1fr 1fr 100px auto; gap: 15px; align-items: end;">
            <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
            <input type="hidden" name="action" value="<?= $editLink ? 'update' : 'create' ?>">
            <?php if ($editLink): ?>
                <input type="hidden" name="id" value="<?= $editLink['id'] ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label style="font-weight: 600;">Link Text</label>
                <input type="text" name="title" required placeholder="e.g. My Website" value="<?= $editLink ? htmlspecialchars($editLink['title']) : '' ?>" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            </div>
            <div class="form-group">
                <label style="font-weight: 600;">URL</label>
                <input type="text" name="url" required placeholder="https://..." value="<?= $editLink ? htmlspecialchars($editLink['url']) : '' ?>" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            </div>
            <div class="form-group">
                <label style="font-weight: 600;">Order</label>
                <input type="number" name="sort_order" value="<?= $editLink ? $editLink['sort_order'] : '0' ?>" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 10px 24px; height: 42px;">
                <?= $editLink ? 'Update Link' : 'Add Link' ?>
            </button>
        </form>
    </div>
</div>

<div class="card" style="margin-top: 30px;">
    <div class="card-header">
        <h2>Existing Quick Links</h2>
    </div>
    <div class="card-content" style="padding: 0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th width="80">Order</th>
                    <th>Link Text</th>
                    <th>URL</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quickLinks as $link): ?>
                <tr>
                    <td><?= $link['sort_order'] ?></td>
                    <td style="font-weight: 600;"><?= htmlspecialchars($link['title']) ?></td>
                    <td><a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" class="text-secondary"><?= htmlspecialchars($link['url']) ?></a></td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="/admin/quick-links?edit=<?= $link['id'] ?>" class="btn btn-sm btn-primary" style="background: var(--primary-color);">Edit</a>
                            <form action="/admin/quick-links" method="POST" onsubmit="return confirm('Are you sure?')">
                                <input type="hidden" name="csrf_token" value="<?= generate_csrf() ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $link['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger" style="background: #dc3545; border: none; color: white; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($quickLinks)): ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #666;">No quick links added yet.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/layout-end.php'; ?>
