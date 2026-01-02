<?php
$db = Database::getInstance()->getConnection();
$pageId = $params['id'] ?? null;
$page = null;

if ($pageId) {
    $stmt = $db->prepare("SELECT * FROM pages WHERE id = ?");
    $stmt->execute([$pageId]);
    $page = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $content = $_POST['content'] ?? '';

    if ($pageId) {
        $stmt = $db->prepare("UPDATE pages SET title = ?, slug = ?, content = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$title, $slug, $content, $pageId]);
    } else {
        $stmt = $db->prepare("INSERT INTO pages (title, slug, content) VALUES (?, ?, ?)");
        $stmt->execute([$title, $slug, $content]);
    }

    header("Location: /admin/pages?success=saved");
    exit;
}

$pageTitle = $pageId ? 'Edit Page' : 'Create Page';
include __DIR__ . '/layout.php';
?>

<div class="card">
    <div class="card-header" style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb;">
        <h2 style="font-size: 18px; font-weight: 600; color: #111827; margin: 0;"><?= $pageTitle ?></h2>
    </div>
    <div class="card-content" style="padding: 24px;">
        <form method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">Page Title</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($page['title'] ?? '') ?>" required style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">URL Slug</label>
                    <input type="text" name="slug" value="<?= htmlspecialchars($page['slug'] ?? '') ?>" required style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px;">Page Content (HTML support)</label>
                <textarea name="content" rows="15" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; font-family: inherit; resize: vertical;"><?= htmlspecialchars($page['content'] ?? '') ?></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="/admin/pages" style="padding: 10px 20px; background: white; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; font-weight: 500; color: #374151; text-decoration: none;">Cancel</a>
                <button type="submit" style="padding: 10px 20px; background: #2563eb; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer;">Save Page</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/layout-end.php'; ?>