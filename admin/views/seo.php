<?php include __DIR__ . '/layout.php'; ?>

<div class="card">
    <div class="card-header">
        <h2>SEO Optimization</h2>
    </div>
    <div class="card-content">
        <form action="/admin/seo" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            
            <div class="sidebar-card" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin-bottom: 4px;">XML Sitemap</h3>
                    <p class="text-secondary" style="font-size: 12px;">Your sitemap is automatically generated and updated.</p>
                </div>
                <a href="/sitemap.xml" target="_blank" class="btn btn-secondary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                    View Sitemap
                </a>
            </div>

            <div class="form-group">
                <label>Sitemap Status</label>
                <select name="seo_sitemap_status">
                    <option value="enabled" <?= ($settings['seo_sitemap_status'] ?? 'enabled') === 'enabled' ? 'selected' : '' ?>>Enabled</option>
                    <option value="disabled" <?= ($settings['seo_sitemap_status'] ?? '') === 'disabled' ? 'selected' : '' ?>>Disabled</option>
                </select>
            </div>

            <div class="form-group" style="margin-top: 24px;">
                <label>Auto Schema Generator (JSON-LD)</label>
                <select name="seo_auto_schema">
                    <option value="enabled" <?= ($settings['seo_auto_schema'] ?? 'enabled') === 'enabled' ? 'selected' : '' ?>>Enabled</option>
                    <option value="disabled" <?= ($settings['seo_auto_schema'] ?? '') === 'disabled' ? 'selected' : '' ?>>Disabled</option>
                </select>
                <p class="text-secondary" style="font-size: 12px; margin-top: 4px;">Automatically generates WebSite and BlogPosting schema markups.</p>
            </div>

            <div class="form-group" style="margin-top: 24px;">
                <label>Organization Type</label>
                <select name="seo_schema_type">
                    <option value="Organization" <?= ($settings['seo_schema_type'] ?? 'Organization') === 'Organization' ? 'selected' : '' ?>>Organization</option>
                    <option value="Person" <?= ($settings['seo_schema_type'] ?? '') === 'Person' ? 'selected' : '' ?>>Person</option>
                </select>
            </div>

            <div style="margin-top: 32px;">
                <button type="submit" class="btn btn-primary">Save SEO Settings</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/layout-end.php'; ?>