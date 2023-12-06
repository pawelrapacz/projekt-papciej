<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <title>Sklep TechNest</title>
    <link href="/styles/technest-style.css" rel="stylesheet"/>
    <link href="/style.css" rel="stylesheet"/>
</head>

<?php require_once 'connect.php'; ?>

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

    <section id="product-list">
            <?php
                $query = "SELECT Produkty.ProduktID, NazwaProduktu, Cena, Opis, NazwaKategorii, Producent, IloscWMagazynie
                    FROM Produkty  
                    INNER JOIN Kategorie ON Kategorie.KategoriaID=Produkty.KategoriaID
                    WHERE IloscWMagazynie > 0";
        
                $result = mysqli_query($base,$query);
        
                while($row=mysqli_fetch_assoc($result)){
                    echo '<form action="/oferta/" method="get">';
                        echo "<input type='text' name='productID' value='{$row['ProduktID']}' readonly class='none'/>";
                        echo '<button class="product">';

                        echo "<img src=\"images/{$row['ProduktID']}.png\" class='product-image' alt='{$row['NazwaProduktu']}'/>";
                        
                        echo "<div class='product-details'>";
                            echo "<h2>{$row['NazwaProduktu']}</h2>";
                            echo "<p><strong>Cena:</strong> {$row['Cena']} zł</p>";
                            echo "<p><strong>Kategoria:</strong> {$row['NazwaKategorii']}</p>";
                            echo "<p><strong>Producent:</strong> {$row['Producent']}</p>";
                            echo "<p><strong>Ilość w magazynie:</strong> {$row['IloscWMagazynie']}</p>";
                        echo "</div>";
                        echo '</button>';
                    echo "</form>";
                }
        
                mysqli_close($base);
            ?>
    </section>

    <footer>
        <p>&copy; 2023 TechNest. All rights reserved.</p>
    </footer>
</body>

</html>