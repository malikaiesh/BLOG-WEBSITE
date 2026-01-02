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
                <h4>Quick Links</h4>
                <ul>
                    <?php 
                    $footerQuickLinks = (new QuickLink())->getAll();
                    foreach ($footerQuickLinks as $link): 
                    ?>
                    <li><a href="<?= htmlspecialchars($link['url']) ?>" target="_blank"><?= htmlspecialchars($link['title']) ?></a></li>
                    <?php endforeach; ?>
                    <?php if (empty($footerQuickLinks)): ?>
                    <li><a href="/">Home</a></li>
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/contact">Contact Us</a></li>
                    <li><a href="/privacy">Privacy Policy</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Follow Us</h4>
                <div class="social-links">
                    <a href="#" aria-label="Facebook" title="Facebook">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" aria-label="Twitter" title="Twitter">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" title="Instagram">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-5.838 2.435-5.838 5.838s2.435 5.838 5.838 5.838 5.838-2.435 5.838-5.838-2.435-5.838-5.838-5.838zm0 9.513c-2.03 0-3.675-1.645-3.675-3.675 0-2.03 1.645-3.675 3.675-3.675 2.03 0 3.675 1.645 3.675 3.675 0 2.03-1.645 3.675-3.675 3.675zm4.961-10.405c0 .731-.593 1.324-1.324 1.324-.731 0-1.324-.593-1.324-1.324 0-.731.593-1.324 1.324-1.324.731 0 1.324.593 1.324 1.324z"/></svg>
                    </a>
                    <a href="#" aria-label="LinkedIn" title="LinkedIn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.2225 0z"/></svg>
                    </a>
                </div>
                <div class="app-stores">
                    <h4>Get the App</h4>
                    <div class="store-links">
                        <a href="#" class="store-btn" title="App Store">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.1 2.48-1.34.03-1.79-.79-3.32-.79-1.53 0-2.01.77-3.32.82-1.35.05-2.33-1.32-3.17-2.55-1.7-2.5-2.98-7.07-1.23-10.12 1.46-2.54 4.05-2.61 5.4-2.61 1.37.02 2.66.92 3.53.92s2.32-.89 3.81-.89c.63 0 2.4.05 3.53 1.21-.08.07-2.11 1.24-2.11 3.68 0 2.93 2.36 3.93 2.38 3.94-.02.07-.37 1.29-1.21 3.12zM14.91 4.15c-.61.74-1.62 1.24-2.51 1.24-.12 0-.26-.01-.38-.03.06-1.04.54-2.13 1.27-2.91.67-.71 1.76-1.25 2.54-1.25.14 0 .28.01.38.02-.06 1.06-.51 2.15-1.3 2.93z"/></svg>
                            <span>App Store</span>
                        </a>
                        <a href="#" class="store-btn" title="Play Store">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M3.25 2.5a.75.75 0 00-.75.75v17.5c0 .414.336.75.75.75h.03l10.5-8.75-10.5-8.75h-.03zm11.25 10.25l-2.25 1.875 6.75 5.625c.414.345.75.172.75-.345V4.09c0-.517-.336-.69-.75-.345l-6.75 5.625 2.25 1.875 6.75-5.625v11.25l-6.75-5.625z"/></svg>
                            <span>Play Store</span>
                        </a>
                        <a href="#" class="store-btn" title="Amazon Store">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm0 18c-3.314 0-6-2.686-6-6s2.686-6 6-6 6 2.686 6 6-2.686 6-6 6zm0-10c-2.209 0-4 1.791-4 4s1.791 4 4 4 4-1.791 4-4-1.791-4-4-4z"/></svg>
                            <span>Amazon</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> BlogTube. All rights reserved.</p>
        </div>
    </footer>
    
    <?php 
    $footerSettings = (new Settings())->getAll();
    echo $footerSettings['custom_footer_code'] ?? ''; 
    ?>
    <script src="/assets/js/main.js"></script>
</body>
</html>
