<?php 
$pageTitle = 'About Us - BlogTube';
$metaDescription = 'Learn more about BlogTube and our mission';
include APP_PATH . '/views/layout/header.php'; 
?>

<div class="page-container">
    <article class="page-content">
        <h1>About Us</h1>
        
        <p>Welcome to BlogTube, your modern destination for discovering amazing content, tutorials, and insights across various topics.</p>
        
        <h2>Our Mission</h2>
        <p>We believe in making knowledge accessible to everyone. Our platform brings together passionate writers and curious readers in a beautiful, user-friendly environment.</p>
        
        <h2>What We Offer</h2>
        <ul>
            <li>High-quality, well-researched articles</li>
            <li>Easy-to-navigate categories</li>
            <li>Regular updates with fresh content</li>
            <li>Community-driven discussions</li>
        </ul>
        
        <h2>Our Team</h2>
        <p>We're a team of passionate writers, developers, and designers working together to create the best possible reading experience for our community.</p>
        
        <h2>Get in Touch</h2>
        <p>Have questions or suggestions? We'd love to hear from you! <a href="/contact">Contact us</a> and let's start a conversation.</p>
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
    margin-bottom: 24px;
}

.page-content h2 {
    font-size: 24px;
    margin: 32px 0 16px;
}

.page-content p {
    font-size: 18px;
    line-height: 1.8;
    margin-bottom: 16px;
    color: var(--text-secondary);
}

.page-content ul {
    margin: 16px 0;
    padding-left: 24px;
}

.page-content li {
    font-size: 18px;
    line-height: 1.8;
    margin-bottom: 8px;
    color: var(--text-secondary);
}

.page-content a {
    color: var(--primary);
}
</style>

<?php include APP_PATH . '/views/layout/footer.php'; ?>
