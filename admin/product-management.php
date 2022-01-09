<?php
require_once '../config/database.php';
spl_autoload_register(function ($classname) {
    require '../app/models/' . $classname . '.php';
});
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <?php $title = "Quản lý sản phẩm"  ?>
    <?php include("head-admin.php"); ?>
</head>

<body>
    <div class="sb-nav-fixed">
        <?php include("nav-admin.php"); ?>
        <div id="layoutSidenav_content">
                    <main>
                        <div class="container-fluid px-4">
                            <h1 class="mt-4 text-capitalize"><?php echo $title ?></h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table"></i>
                                Danh sách sản phẩm
                               
                            </div>
                            <div>
                            <?php var_dump($_SERVER['REQUEST_URI']);?>
                            </div>
                            <div class="card-body">
                                <c:choose>
                                    <c:when test="${success == true}">
                                        <div class="col-md-12">
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <c:out value="${message}" />
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        </div>
                                    </c:when>
                                    <c:when test="${success ==false}">
                                        <div class="col-md-12">
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <c:out value="${message}" />
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        </div>
                                    </c:when>
                                    <c:otherwise>
                                    </c:otherwise>
                                </c:choose>

                                <div class="row">
                                    <div class="col-8">
                                        <div class="row g-6 align-items-center justify-content-md-center">
                                            <form action="product-management" method="get">
                                                <div class="input-group mb-3 input-group-sm">
                                                    <input type="text" class="form-control "
                                                           value="${q}" name="q" required
                                                           placeholder="Nhập tên sản phẩm cần tìm ">
                                                    <button class="btn btn-outline-primary " type="submit"
                                                            id="button-addon2"><i class="fas fa-search"></i>
                                                        Tìm </button>
                                                        <c:if test="${q!=null&&!q.isEmpty()}">  
                                                            <c:set var = "qsearch" scope = "request" value = "q=${q}&"/>
                                                        </c:if> 
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="d-inline-block float-end"><a class="btn btn-success btn-sm"
                                                                                 href="./add-product">Thêm sản
                                                phẩm</a></div>
                                    </div>
                                </div>
                                <table class="table table-bordered caption-top table-sm">
                                    <caption>
                                        Hiển thị các sản phẩm từ ${(currentPage - 1) * productPerPage +1} -
                                        ${ (currentPage - 1) * productPerPage + products.size()} trong tổng số
                                        ${productCount} sản phẩm
                                    </caption>

                                    <thead>
                                        <tr style="border-top: inherit;border-bottom: outset;">
                                            <th scope="col">#</th>
                                            <th scope="col">Tên</th>
                                            <th scope="col">Ảnh</th>
                                            <th scope="col">Giá</th>
                                            <th scope="col">Số lượng </th>
                                            <th scope="col">Ngày tạo</th>
                                            <th scope="col">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <c:set var="index" value="${(currentPage - 1) * productPerPage +1}" />
                                        <c:forEach items="${products}" var="product">
                                            <tr>
                                                <th scope="row">${index}</th>
                                                    <c:set var="index" value="${index+1}" />
                                                <td class="text-wrap fs-5 " style="max-width: 120px;">
                                                    ${product.name}
                                                </td>
                                                <td>
                                                    <div class="ratio ratio-4x3" style="max-width: 80px;">
                                                        <div><img src="../public/images/product/${product.image}"
                                                                  class="img-thumbnail" alt="" sizes=""></div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <fmt:formatNumber value="${product.price}"
                                                                      type="currency" />
                                                </td>
                                                <td class="text-end">
                                                    <fmt:formatNumber type="number" maxIntegerDigits="3"
                                                                      value="${product.total}" />
                                                </td>
                                                <td style="max-width: 80px;">
                                                    <fmt:formatDate pattern="yyyy-MM-dd HH:mm"
                                                                    value="${product.createdAt}" />
                                                </td>
                                                <td style="max-width: 80px; ">
                                                    <a href="${pageContext.request.contextPath}/admin/product-details?id=${product.id}" class="btn btn-info btn-sm"
                                                       title="Xem chi tiết"><i
                                                            class="fas fa-info-circle"></i></a>
                                                    <a href="${pageContext.request.contextPath}/admin/update-product?id=${product.id}" class="btn btn-warning  btn-sm" title="Sửa"><i
                                                            class="fas fa-edit"></i></a>

                                                    <button class="btn btn-danger  btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete-product-${product.id}"
                                                            title="Xoá">
                                                        <i class="fas fa-trash-alt"></i></button>
                                                    <div class="modal fade" id="delete-product-${product.id}"
                                                         tabindex="-1"
                                                         aria-labelledby="delete-product-${product.id}"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="exampleModalLabel">Thông báo</h5>
                                                                    <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="alert alert-warning d-flex align-items-center"
                                                                         role="alert">
                                                                        <div>
                                                                            <p class="fs-5">
                                                                                <i
                                                                                    class="fas fa-exclamation-triangle"></i>
                                                                                Bạn có muốn xoá sản phẩm <span
                                                                                    class="fw-bold">${product.name}</span>?
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                    <form action="delete-product" method="post">
                                                                        <input type="hidden" name="nameImage" value="${product.image}">
                                                                        <input type="hidden"
                                                                               value="${product.id}" name="id" />
                                                                        <button type="submit"
                                                                                class="btn btn-danger">OK</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </c:forEach>
                                    </tbody>
                                </table>
                                <!--PHÂN TRANG-->
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination pagination-sm justify-content-center">
                                        <c:choose>
                                            <c:when test="${currentPage > 1}">
                                                <li class="page-item ">
                                                    <a class="fw-bold page-link"
                                                       href="./product-management?${qsearch}page=${currentPage-1}"
                                                       tabindex="-1" aria-disabled="true"><i
                                                            class="fas fa-arrow-left"></i></a>
                                                </li>
                                            </c:when>
                                            <c:otherwise>
                                                <li class="page-item disabled ">
                                                    <a class="fw-bold page-link"
                                                       href="./product-management?${qsearch}page=${currentPage-1}"
                                                       tabindex="-1" aria-disabled="true"><i
                                                            class="fas fa-arrow-left"></i></a>
                                                </li>
                                            </c:otherwise>
                                        </c:choose>
                                        <c:forEach var="i" begin="1" end="${maxPage}">
                                            <c:choose>
                                                <c:when test="${i == currentPage}">
                                                    <li class="page-item active "><button
                                                            class="fw-bold page-link">${i}</button>
                                                    </li>
                                                </c:when>
                                                <c:otherwise>
                                                    <li class="page-item"><a class="fw-bold page-link"
                                                                             href="./product-management?${qsearch}page=${i}">${i}</a>
                                                    </li>
                                                </c:otherwise>
                                            </c:choose>
                                        </c:forEach>
                                        <c:choose>
                                            <c:when test="${currentPage < maxPage}">
                                                <li class="page-item ">
                                                    <a class="fw-bold page-link "
                                                       href="./product-management?${qsearch}page=${currentPage+1}"><i
                                                            class="fas fa-arrow-right"></i></a>
                                                </li>
                                            </c:when>
                                            <c:otherwise>
                                                <li class="page-item disabled ">
                                                    <a class="fw-bold page-link "
                                                       href="./product-management?${qsearch}page=${currentPage+1}"><i
                                                            class="fas fa-arrow-right"></i></a>
                                                </li>
                                            </c:otherwise>
                                        </c:choose>
                                        <c:remove var = "qsearch"/>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>
                </main>
            <?php include("footer-admin.php"); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
        <script src="../public/js/scripts.js"></script
</body>