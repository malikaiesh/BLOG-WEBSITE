<?php include __DIR__ . '/layout.php'; ?>

<div class="card">
    <div class="card-header">
        <h2>SEO Optimization</h2>
    </div>
    <div class="card-content">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert success" style="background: #e8f5e9; color: #2e7d32; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                Settings updated successfully!
            </div>
        <?php endif; ?>

        <form action="/admin/seo" method="POST">