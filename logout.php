<?php
    session_start();
    session_destroy();
    setcookie('rememberuser', $cookie,time() -60 );
    header("Location: index.php");