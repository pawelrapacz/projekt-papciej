<?php
    session_start();
    
    if (session_status() == PHP_SESSION_NONE || !isset($_SESSION['loginStatus']) || !$_SESSION['loginStatus'])
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
            if (isset($_GET['tableName']))
                echo $_GET['tableName'];
            require_once $_SERVER['DOCUMENT_ROOT'].'/technest-management/common/footer.html';
        ?>
    </div>
</body>
</html>