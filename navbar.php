<?php
$account = [];
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="./public/img/logo.png" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                <li><a href="shoping-cart.php"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
            </ul>
            <div class="header__cart__price">item: <span>$150.00</span></div>
        </div>
        <div class="humberger__menu__widget">
            <div class="header__top__right__language">
                <img width="20px" src="./public/img/language.png" alt="">
                <div>Tiếng Việt
                </div>
            </div>
            <?php if (isset($_SESSION['account']) && isset($account) && !is_null($account)) { ?>
                <div class="header__top__right__language">
                    <div><i class="fa fa-user-circle-o" aria-hidden="true"></i> <?php echo $account['account_username'] ?></div>
                    <span class="arrow_carrot-down"></span>
                    <ul>
                        <li><a href="#"><?php echo $account['account_username'] ?></a></li>
                        <li><a href="logout.php">Đăng xuất</a></li>
                    </ul>
                </div>
            <?php  } else { ?>
                <div class="header__top__right__auth">
                    <a href="login.php"><i class="fa fa-user"></i> Login</a>
                </div>
            <?php } ?>
        </div>
        <nav class="humberger__menu__nav mobile-menu ">
            <ul>
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <?php if (isset($_SESSION['account']) && !is_null($account)) { ?>
                    <li><a href="./transaction">Đơn hàng</a></li>
                <?php } ?>
                <?php if (isset($_SESSION['account']) && !is_null($account) && $account['account_role_id'] != 1) { ?>
                    <li><a href="./admin/">Trang Quản lý</a></li>
                <?php } ?>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                <li>Free Shipping cho đơn hàng trên 99k</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header ">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> tientv.63.student@fit.tdc.edu.vn</li>
                                <li>Free Shipping cho đơn hàng trên 99k</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-pinterest-p"></i></a>
                            </div>
                            <div class="header__top__right__language">
                                <img width="20px" src="./public/img/language.png" alt="">
                                <div>Tiếng Việt</div>
                            </div>
                            <?php if (isset($_SESSION['account']) && isset($account) && !is_null($account)) { ?>
                                <div class="header__top__right__language">
                                    <div><i class="fa fa-user-circle-o" aria-hidden="true"></i> <?php echo $account['account_username'] ?></div>
                                    <span class="arrow_carrot-down"></span>
                                    <ul>
                                        <li><a href="#"><?php echo $account['account_username'] ?></a></li>
                                        <li><a href="logout.php">Đăng xuất</a></li>
                                    </ul>
                                </div>
                            <?php  } else { ?>
                                <div class="header__top__right__auth">
                                    <a href="login.php"><i class="fa fa-user"></i> Login</a>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container ">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="./"><img src="./public/img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="index.php">Home</a></li>
                            <li><a href="shop.php">Shop</a></li>
                            <?php if ( isset($_SESSION['account']) ) { ?>
                                <li><a href="./order.php"> Đơn hàng</a></li>
                            <?php } ?>
                            <?php if (isset($_SESSION['account']) && !is_null($account) && $account['account_role_id'] != 1) { ?>
                                <li><a href="./admin/">Trang Quản lý</a></li>
                            <?php } ?>

                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <li><a href="shoping-cart.php"><i class="fa fa-shopping-bag"></i>
                                    <?php if (array_key_exists('cart', $_SESSION)) { ?>
                                        <span class="total-item-cart"><?php echo count($_SESSION['cart']); ?></span>
                                    <?php } else { ?>
                                         <span class="total-item-cart">0</span>
                                        <?php }?>
                                </a></li>
                        </ul>

                        <div class="header__cart__price ">Giỏ hàng: <span class="product-cart">
                                <?php if (array_key_exists('amount', $_SESSION)) {
                                   echo numfmt_format_currency($fmt,$_SESSION['amount'], "VND");
                                } else {echo "0đ";}?>
                            </span></div>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>

</body>

</html>