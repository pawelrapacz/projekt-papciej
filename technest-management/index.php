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
        <main class="dashboard">
            <section class="income finance-card">
                <div>Przychód</div>
                <div>20 029.23 <span>PLN</span></div>
            </section>

            <section class="losses finance-card">
                <div>Starty</div>
                <div>3 456.45 <span>PLN</span></div>
            </section>

            <section class="raport">
                <div class="positive">Wyszukiwania <span>104/h</span></div>
                <div class="negative">Sprzedaż <span>13%</span></div>
                <div class="negative">Zwroty <span>20%</span></div>
                <div class="positive">Opinie <span>4</span></div>
                <div class="positive">Klienci <span>5</span></div>
            </section>

            <section class="stats">
                <img src="/technest-management/img/view/stats.png" alt="stats">
            </section>

            <section class="messages-box">
                <a class="message" href="#">
                    <div class="profile-img"><img src="/technest-management/img/ferdek.jpg"></div>
                    <span>Ferdynand Kiepski</span>
                    <span class="message-info">Nowa wiadomość</span>
                </a>
                <a class="message" href="#">
                    <div class="profile-img"><img src="/technest-management/img/pazdzioch.webp"></div>
                    <span>Marian Paździoch</span>
                    <span class="message-info">Nowa wiadomość</span>
                </a>
                <a class="message" href="#">
                    <div class="profile-img"><img src="/technest-management/img/boczek.jpg"></div>
                    <span>Arnold Boczek</span>
                    <span class="message-info">Nowa wiadomość</span>
                </a>
                <a class="message" href="#">
                    <div class="profile-img"><img src="/technest-management/img/waldus.jpeg"></div>
                    <span>Walduś</span>
                    <span class="message-info">Nowa wiadomość</span>
                </a>
            </section>
        </main>
        <?php
            require_once $_SERVER['DOCUMENT_ROOT'].'/technest-management/common/footer.html';
        ?>
    </div>
</body>
</html>