<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <title>Sklep TechNest</title>
    <link href="styles/style.css" rel="stylesheet"/>
    <link href="styles/order_styl.css" rel="stylesheet"/>
    
    <?php require_once 'connect.php'; ?>

</head>

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
        <a href="about.php">O sklepie</a>
        <a href="contact.php">Kontakt</a>
    </nav>

    <article>
        <section>
            <form action="order_done.php" method="POST">
                <h2>Zamówienie:
                    <?php echo str_replace('_',' ',array_keys($_POST)[0]); ?>
                </h2>
                <h3>Podaj dane do zamówienia</h3>
                <input type="text" name="imie" placeholder="Imie"/>
                <input type="text" name="nazwisko" placeholder="Nazwisko"/>
                <input type="email" name="email" placeholder="E-mail"/>
                <input type="text" name="adres" placeholder="Adres"/>
                <input type="text" name="telefon" placeholder="Numer Telefonu"/>
                <input type="text" name="kraj" placeholder="Kraj"/>

                <input type="number" name="ilosc" placeholder="Ilość produktu"/>
                <select name="spedytor">
                    <option selected="true" disabled value="0">Dostawca</option>
                    <option value="1">DPD Polska</option>
                    <option value="2">DHL Express Poland</option>
                    <option value="3">InPost</option>
                    <option value="4">Poczta Polska</option>
                </select>


                <input type="submit" name="next" value="Zamów"/>
            </form>
        </section>
    </article>


    <footer>
        <p>&copy; 2023 TechNest. All rights reserved.</p>
    </footer>
</body>

</html>