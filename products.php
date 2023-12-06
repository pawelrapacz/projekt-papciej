<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <title>Sklep TechNest</title>
    <link href="style.css" rel="stylesheet"/>
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
        <a href="about.php">O sklepie</a>
        <a href="contact.php">Kontakt</a>
    </nav>

    <section id="product-list">
        <form action="add.php" method="POST">
            <?php
                $query = "SELECT Produkty.ProduktID, NazwaProduktu, Cena, Opis, NazwaKategorii, Producent, IloscWMagazynie, AVG(Ocena) 
                    FROM `Produkty`  
                    INNER JOIN Opinie ON Opinie.ProduktID=Produkty.ProduktID
                    INNER JOIN Kategorie ON Kategorie.KategoriaID=Produkty.KategoriaID 
                    GROUP BY Produkty.ProduktID;";
        
                $result = mysqli_query($base,$query);
        
                while($row=mysqli_fetch_assoc($result)){
                    echo "<section class='product'>";
                        echo "<img src=\"images/{$row['ProduktID']}.png\" class='product-image' alt='{$row['NazwaProduktu']}'/>";
                        
                        echo "<div class='product-details'>";
                            echo "<h2>{$row['NazwaProduktu']}</h2>";
                            echo "<p><strong>Cena:</strong> {$row['Cena']} zł</p>";
                            echo "<p><strong>Kategoria:</strong> {$row['NazwaKategorii']}</p>";
                            echo "<p><strong>Producent:</strong> {$row['Producent']}</p>";
                            echo "<p><strong>Ilość w magazynie:</strong> {$row['IloscWMagazynie']}</p>";
                            echo "<p><strong>Średnia ocena:</strong> " . number_format($row['AVG(Ocena)'], 1) . "</p>";
                            echo "<input type='submit' value='Zamów' name='{$row['NazwaProduktu']}'/>";
                        echo "</div>";
                    echo "</section>";
                }
        
                mysqli_close($base);
            ?>
        </form>
    </section>

    <footer>
        <p>&copy; 2023 TechNest. All rights reserved.</p>
    </footer>
</body>

</html>