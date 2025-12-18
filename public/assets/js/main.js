document.addEventListener('DOMContentLoaded', function() {
    initTheme();
    initLoadMore();
    initSearch();
    initReadingProgress();
    initActions();
});

function initTheme() {
    const toggle = document.getElementById('themeToggle');
    const saved = localStorage.getItem('theme');
    
    if (saved) {
        document.documentElement.setAttribute('data-theme', saved);
    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.documentElement.setAttribute('data-theme', 'dark');
    }
    
    if (toggle) {
        toggle.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        });
    }
}

function initLoadMore() {
    const btn = document.getElementById('loadMoreBtn');
    const grid = document.getElementById('blogGrid');
    const skeleton = document.getElementById('skeletonLoader');
    
    if (!btn || !grid) return;
    
    btn.addEventListener('click', async function() {
        const offset = parseInt(this.dataset.offset) || 0;
        const limit = 12;
        
        btn.classList.add('loading');
        btn.disabled = true;
        if (skeleton) skeleton.style.display = 'grid';
        
        try {
            const response = await fetch(`/api/blogs?offset=${offset}&limit=${limit}`);
            const data = await response.json();
            
            if (data.blogs && data.blogs.length > 0) {
                data.blogs.forEach(blog => {
                    grid.insertAdjacentHTML('beforeend', createBlogCard(blog));
                });
                
                this.dataset.offset = offset + limit;
                
                if (!data.hasMore) {
                    btn.style.display = 'none';
                }
            } else {
                btn.style.display = 'none';
            }
        } catch (error) {
            console.error('Error loading posts:', error);
        } finally {
            btn.classList.remove('loading');
            btn.disabled = false;
            if (skeleton) skeleton.style.display = 'none';
        }
    });
}

function createBlogCard(blog) {
    const image = blog.featured_image 
        ? `<img src="${blog.featured_image}" alt="${escapeHtml(blog.title)}" loading="lazy">`
        : `<div class="placeholder-image"><svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" opacity="0.3"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/></svg></div>`;
    
    const category = blog.category_name 
        ? `<span class="category-badge">${escapeHtml(blog.category_name)}</span>` 
        : '';
    
    return `
        <article class="blog-card">
            <a href="/blog/${blog.slug}" class="card-image">
                ${image}
                ${category}
            </a>
            <div class="card-content">
                <a href="/blog/${blog.slug}" class="card-title">
                    ${escapeHtml(blog.title)}
                </a>
                <p class="card-excerpt">${escapeHtml(excerpt(blog.excerpt || blog.content, 100))}</p>
                <div class="card-meta">
                    <span class="author">${escapeHtml(blog.author_name || 'Admin')}</span>
                    <span class="dot">•</span>
                    <span class="date">${timeAgo(blog.created_at)}</span>
                </div>
                <div class="card-stats">
                    <span class="views">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        ${formatNumber(blog.views)}
                    </span>
                </div>
            </div>
        </article>
    `;
}

function initSearch() {
    const input = document.getElementById('searchInput');
    const suggestions = document.getElementById('searchSuggestions');
    
    if (!input || !suggestions) return;
    
    let timeout;
    
    input.addEventListener('input', function() {
        clearTimeout(timeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            suggestions.classList.remove('active');
            return;
        }
        
        timeout = setTimeout(async () => {
            try {
                const response = await fetch(`/api/search?q=${encodeURIComponent(query)}`);
                const data = await response.json();
                
                if (data.blogs && data.blogs.length > 0) {
                    suggestions.innerHTML = data.blogs.slice(0, 5).map(blog => `
                        <a href="/blog/${blog.slug}" class="suggestion-item">
                            ${escapeHtml(blog.title)}
                        </a>
                    `).join('');
                    suggestions.classList.add('active');
                } else {
                    suggestions.innerHTML = '<div class="suggestion-item">No results found</div>';
                    suggestions.classList.add('active');
                }
            } catch (error) {
                console.error('Search error:', error);
            }
        }, 300);
    });
    
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-container')) {
            suggestions.classList.remove('active');
        }
    });
}

function initReadingProgress() {
    const progress = document.getElementById('readingProgress');
    if (!progress) return;
    
    window.addEventListener('scroll', function() {
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrolled = (window.scrollY / docHeight) * 100;
        progress.style.width = scrolled + '%';
    });
}

function initActions() {
    const likeBtn = document.getElementById('likeBtn');
    const saveBtn = document.getElementById('saveBtn');
    const shareBtn = document.getElementById('shareBtn');
    
    if (likeBtn) {
        const blogId = likeBtn.dataset.id;
        if (localStorage.getItem(`liked_${blogId}`)) {
            likeBtn.classList.add('active');
        }
        
        likeBtn.addEventListener('click', function() {
            this.classList.toggle('active');
            if (this.classList.contains('active')) {
                localStorage.setItem(`liked_${blogId}`, '1');
            } else {
                localStorage.removeItem(`liked_${blogId}`);
            }
        });
    }
    
    if (saveBtn) {
        const blogId = saveBtn.dataset.id;
        if (localStorage.getItem(`saved_${blogId}`)) {
            saveBtn.classList.add('active');
        }
        
        saveBtn.addEventListener('click', function() {
            this.classList.toggle('active');
            if (this.classList.contains('active')) {
                localStorage.setItem(`saved_${blogId}`, '1');
            } else {
                localStorage.removeItem(`saved_${blogId}`);
            }
        });
    }
    
    if (shareBtn) {
        shareBtn.addEventListener('click', function() {
            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href);
                alert('Link copied to clipboard!');
            }
        });
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function excerpt(text, length) {
    const stripped = text.replace(/<[^>]*>/g, '');
    if (stripped.length <= length) return stripped;
    return stripped.substring(0, length) + '...';
}

function timeAgo(datetime) {
    const time = new Date(datetime).getTime();
    const diff = Date.now() - time;
    const seconds = Math.floor(diff / 1000);
    
    if (seconds < 60) return 'Just now';
    if (seconds < 3600) return Math.floor(seconds / 60) + ' min ago';
    if (seconds < 86400) return Math.floor(seconds / 3600) + ' hours ago';
    if (seconds < 604800) return Math.floor(seconds / 86400) + ' days ago';
    if (seconds < 2592000) return Math.floor(seconds / 604800) + ' weeks ago';
    return new Date(datetime).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

function formatNumber(num) {
    if (num >= 1000000) return (num / 1000000).toFixed(1) + 'M';
    if (num >= 1000) return (num / 1000).toFixed(1) + 'K';
    return num.toString();
}
