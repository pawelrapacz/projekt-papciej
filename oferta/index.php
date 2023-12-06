<?php
    if (!isset($_GET['productID']))
    {
        header('Location: /');
        exit;
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';

    $db = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

    $product = $db->query('SELECT Produkty.*, Kategorie.NazwaKategorii, CAST( AVG(Opinie.Ocena) AS DECIMAL(2, 1) ) AS "SredniaOcena"
    FROM Produkty
    JOIN Kategorie ON Produkty.KategoriaID = Kategorie.KategoriaID
    JOIN Opinie ON Opinie.ProduktID = Produkty.ProduktID
    WHERE Produkty.ProduktID = '.$_GET['productID'])->fetch_object();

    $productID = $product->ProduktID;
    $productName = $product->NazwaProduktu;
    $productPrice = $product->Cena;
    $productDescription = $product->Opis;
    $productProducer = $product->Producent;
    $productInStock = $product->IloscWMagazynie;
    $productCategory = $product->NazwaKategorii;
    $productAvgRating = $product->SredniaOcena;

    // print_r($product);

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/styles/technest-style.css" rel="stylesheet"/>
    <link href="/style.css" rel="stylesheet"/>
    <?php
        echo '<title>'.$productName.'</title>'
    ?>
</head>
<body>
    <header>
        <a href="index.php">
            <h1>Sklep TechNest</h1>
        </a>
    </header>

    <nav>
        <a href="/products.php">Produkty</a>
        <a href="/reviews.php">Opinie</a>
        <a href="/delivery.php">Dostawcy</a>
        <a href="#">O sklepie</a>
        <a href="#">Kontakt</a>
    </nav>
    <main class="product-page"> 
        <section class="offer">
            <?php echo '<img src="/images/'.$productID.'.png" alt="Zdjęcie pogladowe">'; ?>
            <div class="product-info">
                <?php
                    echo '<h2 class="name">'.$productName.'</h2>';

                    echo '<div>';
                    echo '<div class="price">'.$productPrice.' zł</div>';
                    
                    echo '
                        <div class="description">
                            <div class="avg-rating">Ocena: '.$productAvgRating.'</div>
                            <div><span>Kategoria:</span>'.$productCategory.'</div>
                            <div><span>Producent:</span>'.$productProducer.'</div>
                            <div><span>Opis:</span>'.$productDescription.'</div>
                            <div><span>Ilość w magazynie:</span>'.$productInStock.'</div>
                        </div>
                    ';

                    echo '<div class="options"><select class="quantity">';
                    for ($i = 1; $i <= $productInStock && $i <=10; $i++)
                    {
                        if ($i === 1) echo '<option selected>'.$i.'</option>';
                        else echo '<option>'.$i.'</option>';
                    }
                    echo '</select>';

                    echo '<button class="add-to-cart">Dodaj do koszyka</button></div>';

                    echo '</div>';
                ?>
            </div>
        </section>
        <section class="opinions">
            <h2>Opinie</h2>
            <?php

                    $opinions = $db->query('SELECT Opinie.*, Klienci.Imie, Klienci.Nazwisko FROM Opinie
                    JOIN Klienci ON Opinie.KlientID = Klienci.KlientID
                    WHERE ProduktID = '.$productID);

                    while ($opinion = $opinions->fetch_object())
                    {
                        echo '<section class="opinion">';

                        echo '<div class="info">'.$opinion->Imie.' '.$opinion->Nazwisko.'<span>'.$opinion->DataOpinii.'</span></div>';
                        
                        echo '<div class="rating">Ocena: '.$opinion->Ocena.'</div>';
                        
                        echo '<div class="comment">'.$opinion->Komentarz.'</div>';
                        
                        echo '</section>';
                    }

            ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 TechNest. All rights reserved.</p>
    </footer>
</body>
</html>