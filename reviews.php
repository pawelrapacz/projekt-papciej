<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <title>Sklep TechNest</title>   
    <link href="styles/style.css" rel="stylesheet"/>
    <?php require_once 'connect.php'; ?>
    <style>
        article {
            display: flex;
            flex-wrap: wrap;
        }
    </style>
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
        <a href="#">O sklepie</a>
        <a href="#">Kontakt</a>
    </nav>

    <article>
        <?php
            $base = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);
            $query = "SELECT Produkty.ProduktID, NazwaProduktu, Imie, Nazwisko, Ocena, Komentarz, DataOpinii FROM Opinie 
            INNER JOIN Produkty ON Opinie.ProduktID=Produkty.ProduktID
            INNER JOIN Klienci ON Klienci.KlientID=Opinie.KlientID;";

            $result = mysqli_query($base, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                
                echo "<section class='opinion'>";
                    echo "<img src=\"images/{$row['ProduktID']}.png\" class='product-image' alt='{$row['NazwaProduktu']}'/>";
                    echo "<div class='opinion-details'>";
                        echo "<h2>{$row['NazwaProduktu']}</h2>";
                        echo "<p><strong>Imię i Nazwisko:</strong> {$row['Imie']} {$row['Nazwisko']}</p>";
                        echo "<p><strong>Ocena:</strong> {$row['Ocena']}</p>";
                        echo "<p><strong>Komentarz:</strong> {$row['Komentarz']}</p>";
                        echo "<p><strong>Data Opinii:</strong> " . date('d-m-Y', strtotime($row['DataOpinii'])) . "</p>";
                    echo "</div>";
                echo "</section>";
            }

            mysqli_close($base);
        ?>
    </article>

    <footer>
        <p>&copy; 2023 TechNest. All rights reserved.</p>
    </footer>
</body>

</html>