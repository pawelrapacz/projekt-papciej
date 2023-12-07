<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <title>Sklep TechNest</title>
    <link href="styles/style.css" rel="stylesheet"/>
</head>

<?php require_once 'connect.php'; ?>

<body>
<header>
        <a href="/">
            <h1>Sklep TechNest</h1>
        </a>
    </header>

    <nav>
        <a href="/">Produkty</a>
        <a href="reviews.php">Opinie</a>
        <a href="delivery.php">Dostawcy</a>
        <a href="#">O sklepie</a>
        <a href="#">Kontakt</a>
    </nav>

    <article id="product-list">
        <form action="add.php" method="POST">
            <?php
                $base = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
                $query = "SELECT DostawcaID, NazwaDostawcy, Adres, Telefon, Email FROM `Dostawcy`;";
                    
                $result = mysqli_query($base,$query);
        
                while($row=mysqli_fetch_assoc($result)){
                    echo "<section class='delivery'>";
                        echo "<div class='delivery-details'>";
                            echo "<h2>{$row['NazwaDostawcy']}</h2>";
                            echo "<p><strong>Adres:</strong> {$row['Adres']}</p>";
                            echo "<p><strong>Telefon:</strong> {$row['Telefon']}</p>";
                            echo "<p><strong>Email:</strong> {$row['Email']}</p>";
                        echo "</div>";
                    echo "</section>";
                }
        
                mysqli_close($base);
            ?>
        </form>
    </article>


    <footer>
        <p>&copy; 2023 TechNest. All rights reserved.</p>
    </footer>
</body>

</html>