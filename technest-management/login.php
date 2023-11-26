<?php
    session_start();

    if (isset($_SESSION['loginStatus']) && $_SESSION['loginStatus'])
    {
        header('Location: /technest-management/');
        exit; 
    }

    require_once 'error_codes.php';
    $_SESSION['loginStatus'] = false;

    // TODO: db connection and user autorization
    // TODO: SQL injection protection

    $l = 'a';
    $p = 'a';

    if ($_POST['login'] == $l && $_POST['password'])
    {
        $_SESSION['loginStatus'] = true;
        header('Location: /technest-management/');
        exit;
    }


    $_SESSION['error'] = ERR_INV_LOGIN_ATMP;
    header('Location: /technest-management/login/');
    exit;

?>