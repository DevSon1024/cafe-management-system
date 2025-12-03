<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= esc($title ?? 'Cafe Management System') ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* Custom styles for responsive header */
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        /* Mobile view adjustments */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.1rem;
            }
            
            .navbar-brand .cafe-full-name {
                display: none;
            }
            
            .navbar-brand .cafe-short-name {
                display: inline;
            }
            
            .profile-dropdown {
                display: block !important;
            }
            
            .desktop-profile-menu {
                display: none;
            }
        }
        
        /* Desktop view */
        @media (min-width: 769px) {
            .navbar-brand .cafe-full-name {
                display: inline;
            }
            
            .navbar-brand .cafe-short-name {
                display: none;
            }
            
            .mobile-profile-icon {
                display: none;
            }
        }
        
        .profile-dropdown {
            position: relative;
        }
        
        .profile-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .profile-icon:hover {
            transform: scale(1.05);
        }
        
        .dropdown-menu {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        /* Notification badge */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Responsive Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <!-- Cafe Name/Logo -->
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="bi bi-cup-hot-fill me-2"></i>
                <span class="cafe-full-name">Code Cafe</span>
                <span class="cafe-short-name">Code Cafe</span>
            </a>
            
            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Navigation Links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if(session()->get('isLoggedIn')): ?>
                        <?php 
                        $role = session()->get('role');
                        $user_name = session()->get('name');
                        $user_email = session()->get('email');
                        $user_initials = strtoupper(substr($user_name, 0, 1));
                        ?>
                        
                        <!-- Admin Menu -->
                        <?php if($role === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/orders') ?>">
                                    <i class="bi bi-receipt"></i> Orders
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('admin/sales') ?>">
                                    <i class="bi bi-graph-up"></i> Sales
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-gear"></i> Manage
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?= base_url('admin/menu') ?>">Menu Items</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/categories') ?>">Categories</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/staff') ?>">Staff</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/tables') ?>">Tables</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        
                        <!-- Cashier Menu -->
                        <?php if($role === 'cashier'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('cashier/dashboard') ?>">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('cashier/orders/new') ?>">
                                    <i class="bi bi-plus-circle"></i> New Order
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('cashier/sales') ?>">
                                    <i class="bi bi-graph-up"></i> Sales
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <!-- Chef Menu -->
                        <?php if($role === 'chef'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('chef/dashboard') ?>">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('chef/order_history') ?>">
                                    <i class="bi bi-clock-history"></i> Order History
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                
                <!-- Right Side Menu (Profile & Notifications) -->
                <ul class="navbar-nav ms-auto">
                    <?php if(session()->get('isLoggedIn')): ?>
                        <!-- Notifications -->
                        <li class="nav-item dropdown me-3">
                            <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown" id="notificationDropdown">
                                <i class="bi bi-bell fs-5"></i>
                                <span class="notification-badge" id="notificationCount" style="display: none;">0</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="min-width: 300px;">
                                <li class="dropdown-header">Notifications</li>
                                <li><hr class="dropdown-divider"></li>
                                <li id="notificationList">
                                    <div class="px-3 py-2 text-muted text-center">
                                        <small>No new notifications</small>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Profile Dropdown (Desktop & Mobile) -->
                        <li class="nav-item dropdown profile-dropdown">
                            <a class="nav-link d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="profile-icon">
                                    <?= $user_initials ?>
                                </div>
                                <span class="ms-2 d-none d-lg-inline"><?= esc($user_name) ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="dropdown-header">
                                    <div class="d-flex align-items-center">
                                        <div class="profile-icon me-2">
                                            <?= $user_initials ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold"><?= esc($user_name) ?></div>
                                            <small class="text-muted"><?= esc($user_email) ?></small>
                                        </div>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url($role . '/profile') ?>">
                                        <i class="bi bi-person"></i> Profile
                                    </a>
                                </li>
                                <?php if($role === 'admin'): ?>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/settings') ?>">
                                        <i class="bi bi-gear"></i> Settings
                                    </a>
                                </li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('login') ?>">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <?= $this->renderSection('content') ?>
    </div>
    
    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; <?= date('Y') ?> Cafe Management System. All rights reserved.</p>
        </div>
    </footer>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Notification Script -->
    <script>
        // Load notifications
        function loadNotifications() {
            fetch('<?= base_url('notifications/unread') ?>')
                .then(response => response.json())
                .then(data => {
                    if (data.notifications && data.notifications.length > 0) {
                        document.getElementById('notificationCount').style.display = 'flex';
                        document.getElementById('notificationCount').textContent = data.notifications.length;
                        
                        let notificationHTML = '';
                        data.notifications.forEach(notification => {
                            notificationHTML += `
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <small class="text-muted">${notification.created_at}</small>
                                                <p class="mb-0">${notification.message}</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            `;
                        });
                        document.getElementById('notificationList').innerHTML = notificationHTML;
                    }
                })
                .catch(error => console.error('Error loading notifications:', error));
        }
        
        // Load notifications on page load
        <?php if(session()->get('isLoggedIn')): ?>
        document.addEventListener('DOMContentLoaded', function() {
            loadNotifications();
            // Refresh notifications every 30 seconds
            setInterval(loadNotifications, 30000);
        });
        <?php endif; ?>
    </script>
</body>
</html>