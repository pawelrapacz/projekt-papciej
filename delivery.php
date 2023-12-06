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

    <article id="product-list">
        <form action="add.php" method="POST">
            <?php
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