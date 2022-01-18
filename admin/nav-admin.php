<?php 
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION['account'])&&$_SESSION['account']['account_role_id']<2) {
    header("Location: ../error404.php");
    exit;
}
?>

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="../index.php">Ogani Shop</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>
    <ul class="navbar-nav ms-auto me-0 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
               data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="../account.php">Tài khoản</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="../logout">Đăng xuất</a></li>
            </ul>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link " href="ProductManagement.php">
                        <i class="fas fa-table"></i>&nbsp;Quản lý sản phẩm 
                    </a>
                    <a class="nav-link " href="CategoryManagement.php">
                       <i class="fas fa-tasks"></i>&nbsp;Quản lý danh mục
                    </a>
                    <a class="nav-link " href="OrderManagement.php">
                        <i class="fa fa-truck" aria-hidden="true"></i>&nbsp;Quản lý đơn hàng
                    </a>
                    <a class="nav-link " href="AccountManagement.php">
                        <i class="fa fa-users" aria-hidden="true"></i>&nbsp;Quản lý người dùng
                    </a>
                </div>
            </div>
        </nav>
    </div>
