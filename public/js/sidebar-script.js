// Toggle sidebar on mobile
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const openSidebar = document.getElementById('openSidebar');
const closeSidebar = document.getElementById('closeSidebar');

if (openSidebar && closeSidebar && sidebar && overlay) {
    openSidebar.addEventListener('click', () => {
        sidebar.classList.add('active');
        overlay.classList.add('active');
    });

    closeSidebar.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });
}

// Sidebar item active state
document.querySelectorAll('.sidebar-item').forEach(item => {
    item.addEventListener('click', function() {
        // Close sidebar on mobile after clicking menu item
        if (window.innerWidth < 768) {
            if (sidebar) sidebar.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
        }
    });
});