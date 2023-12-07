<?php
    if(!isset($_POST["next"])) {
        header('Location: /');
        exit;
    }
        require_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';
        $db = new mysqli(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);

        $name = $_POST['imie'];
        $lastname = $_POST['nazwisko'];
        $mail = $_POST['email'];
        $address = $_POST['adres'];
        $phone = $_POST['telefon'];
        $country = $_POST['kraj'];
        $spedytor = $_POST['spedytor'];
        $productID = $_POST['produkt'];
        $quantity = $_POST['ilosc'];

        $db->query("INSERT INTO Klienci (Imie, Nazwisko, Email, Adres, Telefon, Kraj) VALUES
        ('$name', '$lastname', '$mail', '$address', '$phone', '$country')");

        $customerID = $db->query('SELECT LAST_INSERT_ID()')->fetch_row()[0];
        
        $db->query("INSERT INTO Zamowienia (KlientID, StanZamowienia, SpedytorID) VALUES
        ($customerID, 'Przyjęte do realizacji', $spedytor)");
        
        $orderID = $db->query('SELECT LAST_INSERT_ID()')->fetch_row()[0];

        $db->query("INSERT INTO SzczegolyZamowienia VALUES
        ($orderID, $productID, $quantity)");

        $db->close();

?>
<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <title>Sklep TechNest</title>
    <link href="/styles/style.css" rel="stylesheet"/>
    <link href="/styles/order_styl.css" rel="stylesheet"/>
</head>

<body>
    <header>
        <a href="/">
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

    <article>
        <section>
            <h2>Dodano zamówienie</h2>
        </section>
    </article>

    <footer>
        <p>&copy; 2023 TechNest. All rights reserved.</p>
    </footer>
</body>

</html>