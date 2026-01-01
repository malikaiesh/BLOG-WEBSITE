document.addEventListener('DOMContentLoaded', function() {
    initSlugGenerator();
    initImagePreview();
    initThemeToggle();
});

function initThemeToggle() {
    const toggle = document.getElementById('theme-toggle');
    if (!toggle) return;

    const currentTheme = localStorage.getItem('admin-theme') || 'light';
    document.documentElement.setAttribute('data-theme', currentTheme);

    toggle.addEventListener('click', () => {
        const newTheme = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('admin-theme', newTheme);
    });
}

function initSlugGenerator() {
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    
    if (!titleInput || !slugInput) return;
    
    titleInput.addEventListener('input', function() {
        if (!slugInput.dataset.manual) {
            slugInput.value = generateSlug(this.value);
        }
    });
    
    slugInput.addEventListener('input', function() {
        this.dataset.manual = 'true';
    });
}

function generateSlug(title) {
    return title
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
}

function initImagePreview() {
    const fileInput = document.getElementById('featured_image');
    if (!fileInput) return;
    
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            let preview = document.querySelector('.current-image');
            if (!preview) {
                preview = document.createElement('div');
                preview.className = 'current-image';
                fileInput.parentNode.insertBefore(preview, fileInput);
            }
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        };
        reader.readAsDataURL(file);
    });
}
