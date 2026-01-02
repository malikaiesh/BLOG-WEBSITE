<?php 
$pageTitle = 'Site Settings';
include __DIR__ . '/layout.php'; 
?>

<div class="card">
    <div class="card-header">
        <h2>Site Settings</h2>
    </div>
    <div class="card-content">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert success" style="background: #e8f5e9; color: #2e7d32; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                Settings updated successfully!
            </div>
        <?php endif; ?>
        <form action="/admin/settings" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                <div class="form-group">
                    <label for="logo">Site Logo</label>
                    <input type="file" name="logo" id="logo" accept="image/*" style="margin-bottom: 10px;">
                    <?php if (!empty($settings['logo_url'])): ?>
                        <div style="background: #f5f5f5; padding: 10px; border-radius: 4px; display: inline-block;">
                            <img src="<?= $settings['logo_url'] ?>" alt="Logo" style="max-height: 40px;">
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="favicon">Favicon (32x32)</label>
                    <input type="file" name="favicon" id="favicon" accept="image/x-icon,image/png" style="margin-bottom: 10px;">
                    <?php if (!empty($settings['favicon_url'])): ?>
                        <div style="background: #f5f5f5; padding: 10px; border-radius: 4px; display: inline-block;">
                            <img src="<?= $settings['favicon_url'] ?>" alt="Favicon" style="max-height: 32px;">
                        </div>
                    <?php endif; ?>
                </div>
            </div>

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
                    <input type="text" name="social[facebook]" value="<?= htmlspecialchars($settings['footer_social_links']['facebook'] ?? '') ?>" placeholder="https://facebook.com/yourpage">
                </div>
                <div class="form-group">
                    <label>Twitter / X</label>
                    <input type="text" name="social[twitter]" value="<?= htmlspecialchars($settings['footer_social_links']['twitter'] ?? '') ?>" placeholder="https://twitter.com/yourhandle">
                </div>
                <div class="form-group">
                    <label>Instagram</label>
                    <input type="text" name="social[instagram]" value="<?= htmlspecialchars($settings['footer_social_links']['instagram'] ?? '') ?>" placeholder="https://instagram.com/yourprofile">
                </div>
                <div class="form-group">
                    <label>YouTube</label>
                    <input type="text" name="social[youtube]" value="<?= htmlspecialchars($settings['footer_social_links']['youtube'] ?? '') ?>" placeholder="https://youtube.com/@yourchannel">
                </div>
                <div class="form-group">
                    <label>LinkedIn</label>
                    <input type="text" name="social[linkedin]" value="<?= htmlspecialchars($settings['footer_social_links']['linkedin'] ?? '') ?>" placeholder="https://linkedin.com/company/yourpage">
                </div>
                <div class="form-group">
                    <label>Pinterest</label>
                    <input type="text" name="social[pinterest]" value="<?= htmlspecialchars($settings['footer_social_links']['pinterest'] ?? '') ?>" placeholder="https://pinterest.com/yourprofile">
                </div>
                <div class="form-group">
                    <label>TikTok</label>
                    <input type="text" name="social[tiktok]" value="<?= htmlspecialchars($settings['footer_social_links']['tiktok'] ?? '') ?>" placeholder="https://tiktok.com/@yourhandle">
                </div>
                <div class="form-group">
                    <label>WhatsApp</label>
                    <input type="text" name="social[whatsapp]" value="<?= htmlspecialchars($settings['footer_social_links']['whatsapp'] ?? '') ?>" placeholder="https://wa.me/yournumber">
                </div>
                <div class="form-group">
                    <label>Telegram</label>
                    <input type="text" name="social[telegram]" value="<?= htmlspecialchars($settings['footer_social_links']['telegram'] ?? '') ?>" placeholder="https://t.me/yourusername">
                </div>
                <div class="form-group">
                    <label>Threads</label>
                    <input type="text" name="social[threads]" value="<?= htmlspecialchars($settings['footer_social_links']['threads'] ?? '') ?>" placeholder="https://threads.net/@yourhandle">
                </div>
            </div>
            
            <div style="margin-top: 24px;">
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/layout-end.php'; ?>