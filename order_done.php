<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <title>Sklep TechNest</title>
    <link href="styles/style.css" rel="stylesheet"/>
    <link href="styles/order_styl.css" rel="stylesheet"/>
    
    <?php require_once 'connect.php'; ?>

</head>

<body>
    <header>
        <a href="index.php">
            <h1>Sklep TechNest</h1>
        </a>
    </header>

    <nav>
        <a href="products.php">Produkty</a>
        <a href="reviews.php">Opinie</a>
        <a href="delivery.php">Dostawcy</a>
        <a href="about.php">O sklepie</a>
        <a href="contact.php">Kontakt</a>
    </nav>

    <article>
        <section>
            <?php
                if(isset($_POST["next"])){
                    $base = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
                    $query = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = "TechNest" AND TABLE_NAME = "Klienci";';
                    $result = mysqli_query($base,$query);
                    $klientId = mysqli_fetch_assoc($result)["AUTO_INCREMENT"];

                    $query = "INSERT INTO Klienci VALUES (
                        $klientId,
                        \"".$_POST["imie"]."\",
                        \"".$_POST["nazwisko"]."\",
                        \"".$_POST["email"]."\",
                        \"".$_POST["adres"]."\",
                        \"".$_POST["telefon"]."\",
                        \"".$_POST["kraj"]."\"
                    );";
                    mysqli_query($base,$query);

                    $query = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = "TechNest" AND TABLE_NAME = "Zamowienia";';
                    $result = mysqli_query($base,$query);
                    $zamowienieId = mysqli_fetch_assoc($result)["AUTO_INCREMENT"];

                    $query = "INSERT INTO Zamowienia VALUES (
                        $zamowienieId,
                        $klientId,
                        \"".date('Y-m-d H:i:s')."\",
                        \"W trakcie realizacji\",
                        ".$_POST["spedytor"].",
                        NULL,
                        NULL,
                        ".rand(1000000000,9999999999).",
                        0,
                        NULL
                    );";
                    mysqli_query($base,$query);

                }
                mysqli_close($base);
            ?>
            <h2>Dodano zamówienie</h2>
        </section>
    </article>

    <footer>
        <p>&copy; 2023 TechNest. All rights reserved.</p>
    </footer>
</body>

</html>