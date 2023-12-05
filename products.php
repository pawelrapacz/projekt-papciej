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

    <article>
        <section id="">
            <form action="add.php" method="POST">
                <?php
                    $query = "SELECT produkty.ProduktID, NazwaProduktu, Cena, Opis, NazwaKategorii, Producent, IloscWMagazynie, AVG(Ocena) FROM `Produkty`  
                    INNER JOIN Opinie ON Opinie.ProduktID=Produkty.ProduktID
                    INNER JOIN Kategorie ON Kategorie.KategoriaID=Produkty.KategoriaID GROUP BY Produkty.ProduktID;";
        
                    $result = mysqli_query($base,$query);
        
                    while($row=mysqli_fetch_row($result)){
                        
                        echo "<section>";

                        echo "<img src=\"images\\$row[0].png\"/>";
                        
                        foreach($row as $cell){
                            echo $cell."<br/>";
                        }                    

                        echo "<input type=\"button\" value=\"Zamów\" name=\"asd\"/>";

                        echo "</section>";
                    }
        
                    mysqli_close($base);
                ?>
            </form>
        </section>
    <article>


    <footer>
        <p>&copy; 2023 TechNest. All rights reserved.</p>
    </footer>
</body>

</html>