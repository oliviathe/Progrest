// Apply theme to <html>
function applyTheme(theme) {
    const root = document.documentElement;

    root.classList.remove('light', 'dark');

    if (theme === 'light') {
        root.classList.add('light');
    } else if (theme === 'dark') {
        root.classList.add('dark');
    }
}

function updateThemeAssets(theme) {
    const logo = document.getElementById('app-logo'); 
    const logoP = document.getElementById('app-logo-p'); 
    const logoLanding = document.getElementById('logo-landing'); 
    const logoFooter = document.getElementById('logo-footer'); 
    const logoAuth = document.getElementById('logo-auth'); 
    const mobileLogo = document.getElementById('mobile-logo'); // <-- FIX: Masukkan ID Mobile Logo

    const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches; 
    const useDark = theme === 'dark' || (theme === 'system' && isDark);

    const mainLogo = useDark 
        ? 'images/progrest_logo_white.png'
        : 'images/progrest_logo_green.png';

    const footerLogo = useDark 
        ? 'images/progrest_logo_green.png'
        : 'images/progrest_logo_white.png'; 

    const pLogo = useDark 
        ? 'images/progrest_p_logo_white.png'
        : 'images/progrest_p_logo_green.png';

    if (logo) logo.src = mainLogo;
    if (logoLanding) logoLanding.src = mainLogo;
    if (logoP) logoP.src = pLogo;
    if (logoFooter) logoFooter.src = footerLogo; 
    if (logoAuth) logoAuth.src = mainLogo; 
    if (mobileLogo) mobileLogo.src = mainLogo;
}

// Expose globally (so Blade can use it if needed)
window.setTheme = function (theme) {
    applyTheme(theme);
    updateThemeAssets(theme); 
    updateActiveThemeUI(theme); 
    if(typeof window.updateMobileThemeUI === 'function') window.updateMobileThemeUI(theme);
    updateSidebarCycleUI(theme); 
    localStorage.setItem('theme', theme);
};

function updateSidebarCycleUI(theme) {
    const sLight = document.getElementById('sidebar-cycle-light');
    const sDark = document.getElementById('sidebar-cycle-dark');
    const sSystem = document.getElementById('sidebar-cycle-system');
    const sText = document.getElementById('sidebar-cycle-text');

    if(sLight) sLight.classList.add('hidden');
    if(sDark) sDark.classList.add('hidden');
    if(sSystem) sSystem.classList.add('hidden');

    if(theme === 'light' && sLight) sLight.classList.remove('hidden');
    if(theme === 'dark' && sDark) sDark.classList.remove('hidden');
    if(theme === 'system' && sSystem) sSystem.classList.remove('hidden');

    if(sText) {
        sText.textContent = theme.charAt(0).toUpperCase() + theme.slice(1);
    }
}

// Initialize AFTER DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Load saved theme
    const saved = localStorage.getItem('theme') || 'light';
    applyTheme(saved);
    updateThemeAssets(saved); 
    updateActiveThemeUI(saved); 
    updateSidebarCycleUI(saved);

    // Attach click listeners for Expand mode
    const buttons = document.querySelectorAll('.theme-btn');
    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const theme = btn.dataset.theme;
            window.setTheme(theme);
        });
    });

    // Event Listener untuk 1 Tombol Siklus (Sidebar Collapse)
    const cycleBtn = document.getElementById('sidebar-theme-cycle');
    cycleBtn?.addEventListener('click', () => {
        const current = localStorage.getItem('theme') || 'light';
        let next = current === 'light' ? 'dark' : (current === 'dark' ? 'system' : 'light');
        window.setTheme(next);
    });
});

function updateActiveThemeUI(theme) {
    const buttons = document.querySelectorAll('.theme-btn');

    buttons.forEach(btn => {
        btn.classList.remove('ring-2', 'ring-primary', 'scale-105', 'bg-surface');
        const icon = btn.querySelector('svg');
        const text = btn.querySelector('span');

        if(icon) { icon.classList.remove('text-primary'); icon.classList.add('text-text-secondary'); }
        if(text) { text.classList.remove('text-primary', 'font-bold'); text.classList.add('text-text-secondary'); }

        if (btn.dataset.theme === theme) {
            btn.classList.add('ring-2', 'ring-primary', 'scale-105', 'bg-surface');
            if(icon) { icon.classList.remove('text-text-secondary'); icon.classList.add('text-primary'); }
            if(text) { text.classList.remove('text-text-secondary'); text.classList.add('text-primary', 'font-bold'); }
        }
    });
}