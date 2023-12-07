<?php
    if (!isset($_GET['productID']))
    {
        header('Location: /');
        exit;
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';

    $db = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

    $product = $db->query('SELECT Produkty.*, Kategorie.NazwaKategorii
    FROM Produkty
    JOIN Kategorie ON Produkty.KategoriaID = Kategorie.KategoriaID
    WHERE Produkty.ProduktID = '.$_GET['productID'])->fetch_object();

    $productID = $product->ProduktID;
    $productName = $product->NazwaProduktu;
    $productPrice = $product->Cena;
    $productDescription = $product->Opis;
    $productProducer = $product->Producent;
    $productInStock = $product->IloscWMagazynie;
    $productCategory = $product->NazwaKategorii;

    $productAvgRating = $db->query('SELECT CAST( AVG(Ocena) AS DECIMAL(3, 1) ) FROM Opinie WHERE ProduktID = '.$productID)->fetch_row()[0];
    if (!$productAvgRating) 
        $productAvgRating = 'Brak';
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/styles/technest-style.css" rel="stylesheet"/>
    <link href="/styles/style.css" rel="stylesheet"/>
    <?php
        echo '<title>'.$productName.'</title>'
    ?>
</head>
<body>
<header>
        <a href="../">
            <h1>Sklep TechNest</h1>
        </a>
    </header>

    <nav>
        <a href="/">Produkty</a>
        <a href="/opinie/">Opinie</a>
        <a href="/dostawcy/">Dostawcy</a>
        <a href="#">O sklepie</a>
        <a href="#">Kontakt</a>
    </nav>

    <main class="product-page"> 
        <section class="offer">
            <?php echo '<img src="/img/products/'.$productID.'.png" alt="Zdjęcie pogladowe">'; ?>
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

                    echo '<form method="post" action="/zamowienie/" class="options"><select class="quantity">';
                    for ($i = 1; $i <= $productInStock && $i <=10; $i++)
                    {
                        if ($i === 1) echo '<option selected>'.$i.'</option>';
                        else echo '<option>'.$i.'</option>';
                    }
                    echo '</select>';

                    echo '<button type="submit" name='.$productName.' class="add-to-cart">Dodaj do koszyka</button></div>';

                    echo '</form>';
                ?>
            </div>
        </section>
        <section class="opinions">
            <h2>Opinie</h2>
            <?php

                    $opinions = $db->query('SELECT Opinie.*, Klienci.Imie, Klienci.Nazwisko FROM Opinie
                    JOIN Klienci ON Opinie.KlientID = Klienci.KlientID
                    WHERE ProduktID = '.$productID);

                    if ($opinions->num_rows)
                    {
                        while ($opinion = $opinions->fetch_object())
                        {
                            echo '<section class="opinion-p">';

                            echo '<div class="info">'.$opinion->Imie.' '.$opinion->Nazwisko.'<span>'.$opinion->DataOpinii.'</span></div>';
                            
                            echo '<div class="rating">Ocena: '.$opinion->Ocena.'</div>';
                            
                            echo '<div class="comment">'.$opinion->Komentarz.'</div>';
                            
                            echo '</section>';
                        }
                    }
                    else echo 'Brak opinii'

            ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 TechNest. All rights reserved.</p>
    </footer>
</body>
</html>