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
        require_once '/technest-management/common/head.html';
    ?>
</head>
<body>
    <?php
        require_once '/common/loader.html';
        require_once '/technest-management/common/sidebar.php';
    ?>

    <div class="wrapper">
        <main>
        </main>
        <?php
            require_once '/technest-management/common/footer.html';
        ?>
    </div>
</body>
</html>