<?php
$db = Database::getInstance()->getConnection();

// Handle Delete
if (isset($_GET['delete'])) {
    $stmt = $db->prepare("DELETE FROM pages WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: /admin/pages?success=deleted");
    exit;
}

$pages = $db->query("SELECT * FROM pages ORDER BY id ASC")->fetchAll();
$pageTitle = 'Pages Management';
include __DIR__ . '/layout.php';
?>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid #e5e7eb;">
        <h2 style="font-size: 18px; font-weight: 600; color: #111827; margin: 0;">Legal & Custom Pages</h2>
        <a href="/admin/pages/create" style="padding: 8px 16px; background: #2563eb; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 500; text-decoration: none;">Add New Page</a>
    </div>
    <div class="card-content">
        <?php if (isset($_GET['success'])): ?>
            <div style="padding: 12px 16px; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                Action completed successfully!
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="data-table" style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #4b5563; text-transform: uppercase;">Title</th>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #4b5563; text-transform: uppercase;">Slug</th>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #4b5563; text-transform: uppercase;">Last Updated</th>
                        <th style="padding: 12px 24px; text-align: right; font-size: 12px; font-weight: 600; color: #4b5563; text-transform: uppercase;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $page): ?>
                        <tr style="border-top: 1px solid #e5e7eb;">
                            <td style="padding: 16px 24px; font-size: 14px; color: #111827; font-weight: 500;"><?= htmlspecialchars($page['title']) ?></td>
                            <td style="padding: 16px 24px; font-size: 14px; color: #6b7280; font-family: monospace;">/p/<?= htmlspecialchars($page['slug']) ?></td>
                            <td style="padding: 16px 24px; font-size: 14px; color: #6b7280;"><?= date('M j, Y', strtotime($page['updated_at'])) ?></td>
                            <td style="padding: 16px 24px; text-align: right;">
                                <div style="display: flex; gap: 12px; justify-content: flex-end;">
                                    <a href="/admin/pages/edit/<?= $page['id'] ?>" style="color: #2563eb; text-decoration: none; font-size: 14px; font-weight: 500;">Edit</a>
                                    <a href="/admin/pages?delete=<?= $page['id'] ?>" onclick="return confirm('Are you sure?')" style="color: #dc2626; text-decoration: none; font-size: 14px; font-weight: 500;">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layout-end.php'; ?>