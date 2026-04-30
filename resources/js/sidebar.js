// Wait for DOM
document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("sidebar-toggle");

    // Attach click event (IMPORTANT: no parentheses)
    btn?.addEventListener("click", toggleSidebar);
});

// Remove no-transition after everything loads
requestAnimationFrame(() => {
    requestAnimationFrame(() => {
        document.documentElement.classList.remove("no-transition");
    });
});

// Toggle function (CSS handles everything else)
function toggleSidebar() {
    const root = document.documentElement;

    // Toggle state
    const collapsed = root.classList.toggle("sidebar-collapsed");

    // Save state
    localStorage.setItem("sidebarCollapsed", collapsed);
}