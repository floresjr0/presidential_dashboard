<?php
require_once __DIR__ . '/header.php';
?>

<style>
.hamburger {
    display: none;
    flex-direction: column;
    justify-content: center;
    gap: 5px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px;
    border-radius: 8px;
    flex-shrink: 0;
}
.hamburger span {
    display: block;
    width: 22px;
    height: 2px;
    background: #1e3a5f;
    border-radius: 2px;
    transition: transform .3s ease, opacity .3s ease;
    transform-origin: center;
}
.hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

.sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.45);
    z-index: 99;
    backdrop-filter: blur(2px);
}
.sidebar-overlay.show { display: block; }

@media (max-width: 768px) {
    .hamburger { display: flex; }
    .sidebar {
        transform: translateX(-100%);
        transition: transform .3s cubic-bezier(.4,0,.2,1);
    }
    .sidebar.open { transform: translateX(0); }
}
</style>

<div class="app-layout">
<?php require_once __DIR__ . '/sidebar.php'; ?>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<main class="main-content">
    <header class="page-header">
        <button class="hamburger" id="sidebarToggle" aria-label="Toggle navigation" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
        <h1><?= e($pageTitle ?? 'Dashboard') ?></h1>
        <?php if (!empty($pageActions)): ?>
        <div class="page-actions"><?= $pageActions ?></div>
        <?php endif; ?>
    </header>
    <div class="page-body">

<script>
(function() {
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('show');
        toggle.classList.add('open');
        toggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        toggle.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    toggle.addEventListener('click', () => {
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
    });
    overlay.addEventListener('click', closeSidebar);

    sidebar.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) closeSidebar();
        });
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) closeSidebar();
    });
})();
</script>