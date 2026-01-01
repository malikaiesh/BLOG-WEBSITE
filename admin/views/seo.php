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
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            
            <!-- Sitemap Section -->
            <div class="sidebar-card" style="margin-bottom: 32px; border: 1px solid var(--border-color); padding: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                    <div>
                        <h3 style="margin-bottom: 4px; font-size: 16px;">XML Sitemap</h3>
                        <p class="text-secondary" style="font-size: 13px;">Your sitemap helps search engines find your content efficiently.</p>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <a href="/sitemap.xml" target="_blank" class="btn btn-secondary" style="padding: 8px 16px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                            View Sitemap
                        </a>
                    </div>
                </div>

                <div class="form-group">
                    <label>Sitemap Status</label>
                    <select name="seo_sitemap_status" class="full-width">
                        <option value="enabled" <?= ($settings['seo_sitemap_status'] ?? 'enabled') === 'enabled' ? 'selected' : '' ?>>Enabled (Recommended)</option>
                        <option value="disabled" <?= ($settings['seo_sitemap_status'] ?? '') === 'disabled' ? 'selected' : '' ?>>Disabled</option>
                    </select>
                </div>
            </div>

            <!-- Schema Section -->
            <div class="sidebar-card" style="margin-bottom: 32px; border: 1px solid var(--border-color); padding: 20px;">
                <h3 style="margin-bottom: 16px; font-size: 16px;">Schema Markup (JSON-LD)</h3>
                
                <div class="form-group">
                    <label>Auto Schema Generator</label>
                    <select name="seo_auto_schema" class="full-width">
                        <option value="enabled" <?= ($settings['seo_auto_schema'] ?? 'enabled') === 'enabled' ? 'selected' : '' ?>>Enabled</option>
                        <option value="disabled" <?= ($settings['seo_auto_schema'] ?? '') === 'disabled' ? 'selected' : '' ?>>Disabled</option>
                    </select>
                    <p class="text-secondary" style="font-size: 12px; margin-top: 6px;">Automatically generates WebSite and BlogPosting schema markups for better Google rich snippets.</p>
                </div>

                <div class="form-group" style="margin-top: 20px;">
                    <label>Site Identity Type</label>
                    <select name="seo_schema_type" class="full-width">
                        <option value="Organization" <?= ($settings['seo_schema_type'] ?? 'Organization') === 'Organization' ? 'selected' : '' ?>>Organization (Business/Brand)</option>
                        <option value="Person" <?= ($settings['seo_schema_type'] ?? '') === 'Person' ? 'selected' : '' ?>>Person (Personal Blog)</option>
                    </select>
                </div>
            </div>

            <div style="padding-top: 10px; border-top: 1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary" style="padding: 12px 32px; font-size: 15px;">
                    Save SEO Settings
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.sidebar-card {
    background: var(--bg-secondary);
    border-radius: var(--radius);
}
[data-theme="dark"] .sidebar-card {
    background: #1a1a1a;
}
.full-width {
    width: 100%;
    margin-top: 8px;
}
</style>

<?php include __DIR__ . '/layout-end.php'; ?>