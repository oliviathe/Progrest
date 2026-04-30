// Apply theme to <html>
function applyTheme(theme) {
    const root = document.documentElement;

    root.classList.remove('light', 'dark');

    if (theme === 'light') {
        root.classList.add('light');
    } else if (theme === 'dark') {
        root.classList.add('dark');
    }
    // system = no class (handled by CSS media query)
}

function updateThemeAssets(theme) {
    const logo = document.getElementById('app-logo'); 
    const logoP = document.getElementById('app-logo-p'); 

    const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches; 

    if(!logo) return; 

    if(theme == 'dark'){
        logo.src = 'images/progrest_logo_white.png'; 
        logoP.src = 'images/progrest_p_logo_white.png'; 
    }
    else if(theme == 'light' || (theme == 'system' && !isDark)){
        logo.src = 'images/progrest_logo_green.png'; 
        logoP.src = 'images/progrest_p_logo_green.png'; 
    }
    else {

        logo.src = isDark && theme == 'system' ? 
            'images/progrest_logo_green.png' : 'images/progrest_logo_white.png'; 
    }
}

// Expose globally (so Blade can use it if needed)
window.setTheme = function (theme) {
    applyTheme(theme);
    updateThemeAssets(theme); 
    updateActiveThemeUI(theme); 
    localStorage.setItem('theme', theme);
};

// Initialize AFTER DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    console.log('themes.js loaded');

    // Load saved theme
    const saved = localStorage.getItem('theme') || 'system';
    applyTheme(saved);
    updateActiveThemeUI(saved); 

    // Attach click listeners
    const buttons = document.querySelectorAll('[data-theme]');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const theme = btn.dataset.theme;

            window.setTheme(theme);
        });
    });
});

function updateActiveThemeUI(theme) {
    const buttons = document.querySelectorAll('.theme-btn');

    buttons.forEach(btn => {
        btn.classList.remove('ring-2', 'ring-primary', 'scale-105');

        if (btn.dataset.theme === theme) {
            btn.classList.add('ring-2', 'ring-primary', 'scale-105');
        }
    });
}