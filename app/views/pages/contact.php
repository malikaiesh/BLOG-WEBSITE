<?php 
$pageTitle = 'Contact Us - BlogTube';
$metaDescription = 'Get in touch with the BlogTube team';
include APP_PATH . '/views/layout/header.php'; 
?>

<div class="page-container">
    <article class="page-content">
        <h1>Contact Us</h1>
        
        <p>We'd love to hear from you! Whether you have a question, feedback, or just want to say hello, feel free to reach out.</p>
        
        <div class="contact-grid">
            <div class="contact-form-section">
                <h2>Send us a Message</h2>
                <form class="contact-form" id="contactForm">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="6" required></textarea>
                    </div>
                    <button type="submit" class="btn">Send Message</button>
                </form>
            </div>
            
            <div class="contact-info-section">
                <h2>Other Ways to Reach Us</h2>
                <div class="contact-card">
                    <h3>Email</h3>
                    <p>contact@blogtube.com</p>
                </div>
                <div class="contact-card">
                    <h3>Follow Us</h3>
                    <div class="social-links">
                        <a href="#">Twitter</a>
                        <a href="#">Facebook</a>
                        <a href="#">Instagram</a>
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>

<style>
.page-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 40px 24px;
}

.page-content h1 {
    font-size: 36px;
    margin-bottom: 16px;
}

.page-content > p {
    font-size: 18px;
    color: var(--text-secondary);
    margin-bottom: 32px;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 40px;
}

.contact-form-section h2,
.contact-info-section h2 {
    font-size: 20px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 16px;
    background: var(--bg-secondary);
    color: var(--text-primary);
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary);
}

.contact-card {
    background: var(--bg-secondary);
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 16px;
}

.contact-card h3 {
    font-size: 14px;
    color: var(--text-muted);
    margin-bottom: 8px;
}

.contact-card p {
    font-size: 16px;
}

.contact-card .social-links {
    display: flex;
    gap: 16px;
}

.contact-card .social-links a {
    color: var(--primary);
}

@media (max-width: 768px) {
    .contact-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php include APP_PATH . '/views/layout/footer.php'; ?>
