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
        <?php
            $query = "SELECT NazwaProduktu, Imie, Nazwisko, Ocena, Komentarz, DataOpinii FROM Opinie 
            INNER JOIN Produkty ON Opinie.ProduktID=Produkty.ProduktID
            INNER JOIN Klienci ON Klienci.KlientID=Opinie.KlientID;";

            $result = mysqli_query($base,$query);

            while($row=mysqli_fetch_row($result)){
                
                echo "<section>";
                
                foreach($row as $cell){
                    echo $cell." ";
                }

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