    </main>
    
    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>BlogTube</h3>
                <p>Your modern destination for amazing content. Discover articles, tutorials, and insights.</p>
            </div>
            <div class="footer-section">
                <h4>Categories</h4>
                <ul>
                    <?php 
                    $footerCategories = (new Category())->getAll();
                    foreach (array_slice($footerCategories, 0, 5) as $cat): 
                    ?>
                    <li><a href="/category/<?= $cat['slug'] ?>"><?= htmlspecialchars($cat['name']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Pages</h4>
                <ul>
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="/privacy">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Follow Us</h4>
                <div class="social-links">
                    <a href="#" aria-label="Facebook">FB</a>
                    <a href="#" aria-label="Twitter">TW</a>
                    <a href="#" aria-label="Instagram">IG</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> BlogTube. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="/assets/js/main.js"></script>
</body>
</html>
