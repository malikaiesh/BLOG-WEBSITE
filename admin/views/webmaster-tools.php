<?php 
$pageTitle = 'Webmaster Tools';
include __DIR__ . '/layout.php'; 

$settingsModel = new Settings();
$settings = $settingsModel->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        die('CSRF token validation failed');
    }
    
    $data = [
        'google_search_console_code' => $_POST['google_search_console_code'],
        'bing_webmaster_code' => $_POST['bing_webmaster_code'],
        'yandex_webmaster_code' => $_POST['yandex_webmaster_code'],
        'pinterest_verification_code' => $_POST['pinterest_verification_code']
    ];
    
    $settingsModel->update($data);
    redirect('/admin/webmaster-tools?success=1');
}
?>

<div class="card">
    <div class="card-header">
        <h2>Webmaster Tools Verification</h2>
    </div>
    <div class="card-content">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert success" style="background: #e8f5e9; color: #2e7d32; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                Verification codes updated successfully!
            </div>
        <?php endif; ?>

        <form action="/admin/webmaster-tools" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            
            <div class="form-group" style="margin-bottom: 24px;">
                <label for="google_search_console_code">Google Search Console Verification Code</label>
                <p class="text-secondary" style="font-size: 12px; margin-bottom: 8px;">Enter the content of the meta tag (e.g., <code>&lt;meta name="google-site-verification" content="<b>CODE_HERE</b>" /&gt;</code>).</p>
                <input type="text" name="google_search_console_code" id="google_search_console_code" value="<?= htmlspecialchars($settings['google_search_console_code'] ?? '') ?>" class="full-width" placeholder="Paste verification code here">
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label for="bing_webmaster_code">Bing Webmaster Tools Verification Code</label>
                <p class="text-secondary" style="font-size: 12px; margin-bottom: 8px;">Enter the content of the <code>msvalidate.01</code> meta tag.</p>
                <input type="text" name="bing_webmaster_code" id="bing_webmaster_code" value="<?= htmlspecialchars($settings['bing_webmaster_code'] ?? '') ?>" class="full-width" placeholder="Paste verification code here">
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label for="yandex_webmaster_code">Yandex Webmaster Verification Code</label>
                <p class="text-secondary" style="font-size: 12px; margin-bottom: 8px;">Enter the content of the <code>yandex-verification</code> meta tag.</p>
                <input type="text" name="yandex_webmaster_code" id="yandex_webmaster_code" value="<?= htmlspecialchars($settings['yandex_webmaster_code'] ?? '') ?>" class="full-width" placeholder="Paste verification code here">
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label for="pinterest_verification_code">Pinterest Verification Code</label>
                <p class="text-secondary" style="font-size: 12px; margin-bottom: 8px;">Enter the content of the <code>p:domain_verify</code> meta tag.</p>
                <input type="text" name="pinterest_verification_code" id="pinterest_verification_code" value="<?= htmlspecialchars($settings['pinterest_verification_code'] ?? '') ?>" class="full-width" placeholder="Paste verification code here">
            </div>
            
            <div style="margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 32px;">Save Verification Codes</button>
            </div>
        </form>
    </div>
</div>

<style>
.full-width {
    width: 100%;
    padding: 10px;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    margin-top: 8px;
    box-sizing: border-box;
}
[data-theme="dark"] .full-width {
    background: #1e1e1e;
    color: #fff;
    border-color: #333;
}
</style>

<?php include __DIR__ . '/layout-end.php'; ?>