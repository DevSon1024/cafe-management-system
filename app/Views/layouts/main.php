<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Code Cafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #4a3f35;">
        <div class="container">
            <a class="navbar-brand" href="/">☕ The Code Cafe</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <?php if (session()->get('isLoggedIn')): ?>
                        <?php if (session()->get('role') === 'admin'): ?>
                            <li class="nav-item"><a class="nav-link" href="/admin/dashboard">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="/admin/sales">Sales History</a></li>
                            <li class="nav-item"><a class="nav-link" href="/admin/menu">Menu</a></li>
                            <li class="nav-item"><a class="nav-link" href="/admin/categories">Categories</a></li>
                            <li class="nav-item"><a class="nav-link" href="/admin/orders">Orders</a></li>
                            <li class="nav-item"><a class="nav-link" href="/admin/tables">Tables</a></li>
                            <li class="nav-item"><a class="nav-link" href="/admin/staff">Staff</a></li>
                        <?php elseif (session()->get('role') === 'chef'): ?>
                            <li class="nav-item"><a class="nav-link" href="/chef/dashboard">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="/chef/order_history">Order History</a></li>
                        <?php elseif (session()->get('role') === 'cashier'): ?>
                            <li class="nav-item"><a class="nav-link" href="/cashier/dashboard">Dashboard</a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if (session()->get('isLoggedIn')): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= session()->get('name') ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/admin/profile">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/logout">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login (for Admin)</a>
                        </li>
                        <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="text-center mt-5 py-3 bg-light">
        <p>&copy; <?= date('Y') ?> The Code Cafe. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>