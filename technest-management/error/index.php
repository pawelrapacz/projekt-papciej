<?php
    session_start();

    if (!isset($_SESSION['loginStatus']) || !$_SESSION['loginStatus'] || !isset($_SESSION['error']))
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
        require_once $_SERVER['DOCUMENT_ROOT'].'/technest-management/common/loader.html';
    ?>

    <div class="error-wrapper">
        <main class="error content-box">
            <svg class="exclamation" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M11.953 2C6.465 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.493 2 11.953 2zM12 20c-4.411 0-8-3.589-8-8s3.567-8 7.953-8C16.391 4 20 7.589 20 12s-3.589 8-8 8z"></path><path d="M11 7h2v7h-2zm0 8h2v2h-2z"></path></svg>
            <?php
                if (isset($_SESSION['errorCode']))
                {
                    echo '<div class="error-code">'.$_SESSION['errorCode'].'</div>';
                    unset($_SESSION['errorCode']);
                }

                echo '<div class="error-description">'.$_SESSION['error'].'</div>';
                unset($_SESSION['error']);
                
                if (isset($_SESSION['errorMessage']))
                {
                    echo '<div class="error-message">'.$_SESSION['errorMessage'].'</div>';
                    unset($_SESSION['errorMessage']);
                }
            ?>
        </main>
    </div>
</body>
</html>