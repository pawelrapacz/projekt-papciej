<?php
    session_start();

    if (!isset($_SESSION['loginStatus']) || !$_SESSION['loginStatus'])
    {
        header('Location: /technest-management/login/');
        exit;        
    }
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/technest-management/common/head.html';
    ?>
    <script src="/technest-management/js/settings.js" async defer></script>
    <title>TechNest | Ustawienia</title>
</head>
<body>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/technest-management/common/loader.html';
        require_once $_SERVER['DOCUMENT_ROOT'].'/technest-management/common/sidebar.php';
    ?>

    <div class="wrapper">
        <main class="content-box">
            <label for="_color_scheme_selector">Motyw: </label>
            <select name="" id="_color_scheme_selector">
                <option value="0">Jasny</option>
                <option value="1">Ciemny</option>
                <option value="2">Automatyczny</option>
            </select>
        </main>
        <?php
            require_once $_SERVER['DOCUMENT_ROOT'].'/technest-management/common/footer.html';
        ?>
    </div>
</body>
</html>