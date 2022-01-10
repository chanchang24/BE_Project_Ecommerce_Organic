
let pageNewProduct = 1;
let listNewProduct = document.querySelector(".list-new-product");
let btnLoadMore = document.querySelector(".btn-loadmore-newproduct");
let btnAddToCart = document.querySelectorAll(".btn-add-to-cart");
const numProduct = 4;
let productCart = document.querySelector(".product-cart");
let totalItemCart = document.querySelector(".total-item-cart");
if (btnLoadMore !== null) {
    loadMoreNewProduct();
    btnLoadMore.addEventListener("click", () => {
        loadMoreNewProduct();
    });
} else {
    addCart();
}

function loadMoreNewProduct() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        btnLoadMore.innerText = "Đang tải...";
        const xmlDoc = xhttp.responseText;
        let newProducts = JSON.parse(xmlDoc);
        renderNewProdcuts(newProducts);

    }
    xhttp.open("POST", "./app/ajax/LoadMoreNewProduct.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send(`pageNewProduct=${pageNewProduct}&numProduct=${numProduct}`);
    pageNewProduct++;
}

function renderNewProdcuts(newProducts) {
    if (newProducts.length < numProduct) {
        btnLoadMore.remove();
    } else {
        if (newProducts.length > numProduct) {
            newProducts.pop();
        }
    }
    document.querySelectorAll('.animate__animated.animate__fadeInUp').forEach(element => {
        element.classList.remove('animate__animated');
    });
    let html = '';
    newProducts.forEach(product => {
        html += `     <div class="col-lg-3 col-md-4 col-sm-6 mix animate__animated animate__fadeInUp  ">
        <div class="featured__item">
            <div class="featured__item__pic set-bg" style="border: 1px #d2cfcf61 solid;"
                data-setbg="./public/images/products/${product.product_main_image}">
                <ul class="featured__item__pic__hover">
                    <li><a href="shop-details.php?id=${product.id}" title="Xem chi tiết"><i
                                class="fa fa-info-circle"></i></a></li> `
        if (product.product_quantily != '0') {
            html += ` <li> <a data-id="${product.id}" title="Thêm vào giỏ" style="cursor: pointer" class="btn-add-to-cart"><i class="fa fa-shopping-cart"></i></a></li >`
        }
        html += `  </ul>
            </div>
            <div class="featured__item__text">
                <h6><a href="#">${product.product_name}</a></h6>`
        if (product.product_price > product.product_promotional_price) {
            html += `        <h5 class="text-danger"> ${product.product_promotional_price.toLocaleString('vi')}₫</h5><span class="text-muted" style="text-decoration-line: line-through;">${product.price.toLocaleString('vi')}₫</span>`
        } else {
            html += `<h5>${product.product_price.toLocaleString('vi')}₫</h5>`
        }
        html += `  
                    </div>
                </div>
            </div>`
    });
    listNewProduct.innerHTML += html;
    btnLoadMore.innerText = "Xem thêm";
    loadImageProduct();
    btnAddToCart = document.querySelectorAll(".btn-add-to-cart");
    addCart();
}
function loadImageProduct() {
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });
}
function addCart() {
    btnAddToCart.forEach(element => {
        element.addEventListener('click', function () {
            let id = this.dataset.id;
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function () {
                let obj = JSON.parse(xhttp.responseText);
                Toastify({
                    text: "Thêm " + obj.productName + " vào giỏ hàng",
                    duration: 4000,
                    newWindow: true,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right",
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #7fad39, #96c93d)",
                    },
                    onClick: function () {
                    }
                }).showToast();
                productCart.innerText = obj.amount.toLocaleString('vi') + '₫';
                totalItemCart.innerText = obj.total;
            }
            xhttp.open("POST", "./app/ajax/AddToCart.php", true);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send("idadd=" + id);
        })
    });
}
