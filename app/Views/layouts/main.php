<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-t">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Code Cafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Sliding Sidebar -->
    <div id="sidebar" class="sidebar-container">
        <div class="sidebar-header">
            <h5 class="mb-0 text-white">Menu</h5>
            <button class="btn btn-dark" id="close-sidebar">&times;</button>
        </div>
        <ul class="sidebar-nav">
            <li><a class="sidebar-link" href="/"><i class="bi bi-house-fill me-2"></i>Home</a></li>
            <?php if (session()->get('isLoggedIn')): ?>
                <?php if (session()->get('role') === 'admin'): ?>
                    <li><a class="sidebar-link" href="/admin/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                    <li><a class="sidebar-link" href="/admin/sales"><i class="bi bi-bar-chart-line-fill me-2"></i>Sales History</a></li>
                    <li><a class="sidebar-link" href="/admin/menu"><i class="bi bi-journal-album me-2"></i>Menu</a></li>
                    <li><a class="sidebar-link" href="/admin/categories"><i class="bi bi-tags-fill me-2"></i>Categories</a></li>
                    <li><a class="sidebar-link" href="/admin/orders"><i class="bi bi-card-checklist me-2"></i>Orders</a></li>
                    <li><a class="sidebar-link" href="/admin/tables"><i class="bi bi-grid-3x3-gap-fill me-2"></i>Tables</a></li>
                    <li><a class="sidebar-link" href="/admin/staff"><i class="bi bi-people-fill me-2"></i>Staff</a></li>
                <?php elseif (session()->get('role') === 'chef'): ?>
                    <li><a class="sidebar-link" href="/chef/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                    <li><a class="sidebar-link" href="/chef/order_history"><i class="bi bi-clock-history me-2"></i>Order History</a></li>
                <?php elseif (session()->get('role') === 'cashier'): ?>
                    <li><a class="sidebar-link" href="/cashier/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
    </div>
    <div id="sidebar-overlay"></div>

    <!-- Main Header -->
    <header class="main-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <button class="btn text-white" id="hamburger-menu">
                <i class="bi bi-list fs-4"></i>
            </button>
            <a class="navbar-brand" href="/">☕ The Code Cafe</a>
            
            <div class="d-flex align-items-center">
                <?php if (session()->get('isLoggedIn')): ?>
                    <!-- Notification Bell -->
                    <div class="dropdown me-2" id="notification-bell">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell-fill fs-5"></i>
                            <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle" id="notification-count" style="display: none; font-size: 0.6em; padding: .25em .5em;"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" id="notification-list" style="width: 300px;">
                            <!-- Notifications will be loaded here by JavaScript -->
                        </ul>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-4 me-1"></i>
                            <?= session()->get('name') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/admin/profile"><i class="bi bi-person-fill me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a class="nav-link text-white" href="/login">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="container mt-4 main-content">
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="text-center mt-5 py-3 bg-light">
        <p>&copy; <?= date('Y') ?> The Code Cafe. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburger = document.getElementById('hamburger-menu');
        const closeBtn = document.getElementById('close-sidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function openSidebar() {
            if (sidebar) sidebar.classList.add('active');
            if (overlay) overlay.classList.add('active');
        }

        function closeSidebar() {
            if (sidebar) sidebar.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
        }

        if (hamburger) hamburger.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);
    });

    // --- Notification Script ---
    <?php if (session()->get('isLoggedIn')): ?>
    function fetchNotifications() {
        fetch('/notifications/unread')
            .then(response => response.json())
            .then(data => {
                const count = data.length;
                const notificationCount = document.getElementById('notification-count');
                const notificationList = document.getElementById('notification-list');

                if (count > 0) {
                    notificationCount.textContent = count;
                    notificationCount.style.display = 'inline-block';
                } else {
                    notificationCount.style.display = 'none';
                }

                let notificationsHtml = '';
                if (data.length > 0) {
                    data.forEach(notification => {
                        const messageWithoutHtml = notification.message.replace(/<[^>]*>?/gm, ' ');
                        notificationsHtml += `<li><a class="dropdown-item" href="/admin/orders/receipt/${notification.order_id}">${messageWithoutHtml}</a></li>`;
                    });
                     notificationsHtml += '<li><hr class="dropdown-divider"></li>';
                     notificationsHtml += '<li><p class="dropdown-item-text text-center text-muted small">Notifications marked as read on open.</p></li>';
                } else {
                    notificationsHtml = '<li><span class="dropdown-item-text text-center text-muted p-3">No new notifications</span></li>';
                }
                notificationList.innerHTML = notificationsHtml;
            });
    }

    document.getElementById('notification-bell').addEventListener('show.bs.dropdown', function() {
        fetch('/notifications/mark-as-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
            }
        }).then(() => {
            setTimeout(() => {
                document.getElementById('notification-count').style.display = 'none';
            }, 500);
        });
    });
    
    // Fetch notifications every 30 seconds
    setInterval(fetchNotifications, 30000);

    // Fetch notifications on page load
    fetchNotifications();
    <?php endif; ?>
    </script>
</body>
</html>
