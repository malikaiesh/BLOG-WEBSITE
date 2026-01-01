<?php include __DIR__ . '/layout.php'; ?>

<div class="card">
    <div class="card-header">
        <h2>Site Settings</h2>
    </div>
    <div class="card-content">
        <form action="/admin/settings" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            
            <div class="form-group">
                <label for="site_name">Website Name</label>
                <input type="text" name="site_name" id="site_name" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="site_description">Website Description</label>
                <textarea name="site_description" id="site_description" rows="3"><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="site_keywords">Keywords (comma separated)</label>
                <input type="text" name="site_keywords" id="site_keywords" value="<?= htmlspecialchars($settings['site_keywords'] ?? '') ?>">
            </div>
            
            <h3 style="margin: 24px 0 16px; font-size: 16px;">Social Media Links</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label>Facebook</label>
                    <input type="text" name="social[facebook]" value="<?= htmlspecialchars($settings['footer_social_links']['facebook'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Twitter</label>
                    <input type="text" name="social[twitter]" value="<?= htmlspecialchars($settings['footer_social_links']['twitter'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Instagram</label>
                    <input type="text" name="social[instagram]" value="<?= htmlspecialchars($settings['footer_social_links']['instagram'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>YouTube</label>
                    <input type="text" name="social[youtube]" value="<?= htmlspecialchars($settings['footer_social_links']['youtube'] ?? '') ?>">
                </div>
            </div>
            
            <div style="margin-top: 24px;">
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/layout-end.php'; ?>