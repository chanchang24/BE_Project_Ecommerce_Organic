<!DOCTYPE html>
<html>

<head>
    <c:set var="title" value="Quản lý danh mục" scope="request" />
    <?php include("head-admin.php"); ?>
</head>

<body>
    <div class="sb-nav-fixed">
        <?php include("nav-admin.php"); ?>
        <jsp:include page="navbar-admin.jsp"></jsp:include>
        <div id="layoutSidenav_content">
            <main style="background: url(../public/images/admin-bg.jpg);height: 100vh;width: 100%;background-clip: border-box;background-position: center;background-size: cover;padding-bottom: 500px;padding-top: 150px;padding-left: 20px;padding-right: 20px;">
                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                    <h2> Chào mừng bạn đến với trang quản lý </h2>
                </div>
            </main>
            <?php include("footer-admin.php"); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../public/js/scripts.js"></script>
</body>