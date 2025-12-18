<?php 
$pageTitle = 'Privacy Policy - BlogTube';
$metaDescription = 'Privacy Policy for BlogTube';
include APP_PATH . '/views/layout/header.php'; 
?>

<div class="page-container">
    <article class="page-content">
        <h1>Privacy Policy</h1>
        <p class="updated">Last updated: <?= date('F d, Y') ?></p>
        
        <h2>Introduction</h2>
        <p>At BlogTube, we respect your privacy and are committed to protecting your personal data. This privacy policy explains how we collect, use, and safeguard your information when you visit our website.</p>
        
        <h2>Information We Collect</h2>
        <p>We may collect the following types of information:</p>
        <ul>
            <li><strong>Usage Data:</strong> Information about how you use our website, including pages visited, time spent, and browser type.</li>
            <li><strong>Cookies:</strong> Small files stored on your device to enhance your browsing experience.</li>
            <li><strong>Contact Information:</strong> If you contact us, we may collect your name and email address.</li>
        </ul>
        
        <h2>How We Use Your Information</h2>
        <p>We use collected information to:</p>
        <ul>
            <li>Provide and maintain our service</li>
            <li>Improve user experience</li>
            <li>Analyze website traffic and usage patterns</li>
            <li>Respond to inquiries and support requests</li>
        </ul>
        
        <h2>Cookies</h2>
        <p>We use cookies to improve your experience on our site. You can set your browser to refuse cookies, but some features may not work properly.</p>
        
        <h2>Third-Party Services</h2>
        <p>We may use third-party services such as analytics providers and advertising networks. These services may collect information about your browsing activity.</p>
        
        <h2>Data Security</h2>
        <p>We implement appropriate security measures to protect your personal information. However, no method of transmission over the Internet is 100% secure.</p>
        
        <h2>Your Rights</h2>
        <p>You have the right to:</p>
        <ul>
            <li>Access your personal data</li>
            <li>Request correction of inaccurate data</li>
            <li>Request deletion of your data</li>
            <li>Opt-out of marketing communications</li>
        </ul>
        
        <h2>Contact Us</h2>
        <p>If you have questions about this privacy policy, please <a href="/contact">contact us</a>.</p>
    </article>
</div>

<style>
.page-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px 24px;
}

.page-content h1 {
    font-size: 36px;
    margin-bottom: 8px;
}

.page-content .updated {
    color: var(--text-muted);
    margin-bottom: 32px;
}

.page-content h2 {
    font-size: 22px;
    margin: 32px 0 16px;
}

.page-content p {
    font-size: 16px;
    line-height: 1.8;
    margin-bottom: 16px;
    color: var(--text-secondary);
}

.page-content ul {
    margin: 16px 0;
    padding-left: 24px;
}

.page-content li {
    font-size: 16px;
    line-height: 1.8;
    margin-bottom: 8px;
    color: var(--text-secondary);
}

.page-content a {
    color: var(--primary);
}
</style>

<?php include APP_PATH . '/views/layout/footer.php'; ?>
