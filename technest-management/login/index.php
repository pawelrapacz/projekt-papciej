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
        require_once $_SERVER['DOCUMENT_ROOT'].'/technest-management/common/loader.html';
    ?>
    <div class="login-wrapper">
        <div class="login-box">
            <div class="title">Login</div>
            <form action="/technest-management/login.php" method="post">
                <div class="input-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"></path></svg>
                    <input type="text" name="login" placeholder="Login" required>
                </div>
                <div class="input-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2C9.243 2 7 4.243 7 7v3H6c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-8c0-1.103-.897-2-2-2h-1V7c0-2.757-2.243-5-5-5zm6 10 .002 8H6v-8h12zm-9-2V7c0-1.654 1.346-3 3-3s3 1.346 3 3v3H9z"></path></svg>
                    <input type="password" name="password" placeholder="Hasło" required>
                </div>
                    <?php
                        if (isset($_SESSION['error']))
                        {
                            echo '<div class="login-error">'.$_SESSION['error'].'</div>';
                            unset($_SESSION['error']);
                        }
                    ?>
                <input class="login-btn" type="submit" value="Zaloguj się">
            </form>
        </div>
    </div>
</body>
</html>