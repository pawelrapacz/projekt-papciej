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
    <title>TechNest | Panel zarządzania</title>
</head>
<body>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/common/loader.html';
        require_once $_SERVER['DOCUMENT_ROOT'].'/technest-management/common/sidebar.php';
    ?>

    <div class="wrapper">
        <main>
        </main>
        <?php
            require_once $_SERVER['DOCUMENT_ROOT'].'/technest-management/common/footer.html';
        ?>
    </div>
</body>
</html>