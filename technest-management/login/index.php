<?php
    session_start();

    if (isset($_SESSION['loginStatus']) && $_SESSION['loginStatus'])
    {
        header('Location: /technest-management/');
        exit; 
    }
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/technest-management/common/head.html';
    ?>
    <title>Login</title>
</head>
<body>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/common/loader.html';
    ?>
    <div class="login-wrapper">
        <div class="login-box">
            <div class="title">Login</div>
            <form action="/technest-management/login.php" method="post">
                <input class="input login-error" type="text" name="login" placeholder="Login" required>
                <input class="input login-error" type="password" name="password" placeholder="Hasło" required>
                    <?php
                        if (isset($_SESSION['error']))
                        {
                            echo '<div class="login-error">'.$_SESSION['error'].'</div>';
                            unset($_SESSION['error']);
                        }
                    ?>
                <input class="submit-btn" type="submit" value="Zaloguj się">
            </form>
        </div>
    </div>
</body>
</html>