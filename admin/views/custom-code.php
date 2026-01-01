<?php include __DIR__ . '/layout.php'; ?>

<div class="card">
    <div class="card-header">
        <h2>Custom Code Manager</h2>
    </div>
    <div class="card-content">
        <form action="/admin/custom-code" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            
            <div class="form-group">
                <label for="custom_head_code">Header Code (Inside &lt;head&gt;)</label>
                <p class="text-secondary" style="font-size: 12px; margin-bottom: 8px;">Useful for Google Analytics, Meta pixels, or custom CSS.</p>
                <textarea name="custom_head_code" id="custom_head_code" rows="8" class="content-editor"><?= htmlspecialchars($settings['custom_head_code'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group" style="margin-top: 24px;">
                <label for="custom_body_code">Body Code (After &lt;body&gt; tag)</label>
                <p class="text-secondary" style="font-size: 12px; margin-bottom: 8px;">Useful for tracking scripts that need to be at the start of the body.</p>
                <textarea name="custom_body_code" id="custom_body_code" rows="8" class="content-editor"><?= htmlspecialchars($settings['custom_body_code'] ?? '') ?></textarea>
            </div>
            
            <div class="form-group" style="margin-top: 24px;">
                <label for="custom_footer_code">Footer Code (Before &lt;/body&gt; tag)</label>
                <p class="text-secondary" style="font-size: 12px; margin-bottom: 8px;">Useful for chat widgets or external JS libraries.</p>
                <textarea name="custom_footer_code" id="custom_footer_code" rows="8" class="content-editor"><?= htmlspecialchars($settings['custom_footer_code'] ?? '') ?></textarea>
            </div>
            
            <div style="margin-top: 32px;">
                <button type="submit" class="btn btn-primary">Save Custom Codes</button>
            </div>
        </form>
    </div>
</div>

<style>
.content-editor {
    font-family: 'Monaco', 'Consolas', 'Courier New', monospace;
    background: #fdfdfd;
    color: #333;
}
[data-theme="dark"] .content-editor {
    background: #1e1e1e;
    color: #d4d4d4;
    border-color: #333;
}
</style>

<?php include __DIR__ . '/layout-end.php'; ?>