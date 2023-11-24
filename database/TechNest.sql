CREATE DATABASE TechNest;
USE TechNest;

START TRANSACTION;

-- TWORZENIE TABEL
CREATE TABLE Kategorie (
    KategoriaID INT PRIMARY KEY AUTO_INCREMENT,
    NazwaKategorii VARCHAR(255) NOT NULL UNIQUE
);


CREATE TABLE Dostawcy (
    DostawcaID INT PRIMARY KEY AUTO_INCREMENT,
    NazwaDostawcy VARCHAR(255) NOT NULL UNIQUE,
    Adres TEXT NOT NULL,
    Telefon VARCHAR(20) NOT NULL,
    Email VARCHAR(255) NOT NULL
);


CREATE TABLE Produkty (
    ProduktID INT PRIMARY KEY AUTO_INCREMENT,
    NazwaProduktu VARCHAR(255) NOT NULL,
    Cena DECIMAL(10, 2) NOT NULL,
    Opis TEXT DEFAULT NULL,
    KategoriaID INT NOT NULL,
    Producent VARCHAR(255) NOT NULL,
    DostawcaID INT NOT NULL,
    IloscWMagazynie INT NOT NULL,
    FOREIGN KEY (KategoriaID) REFERENCES Kategorie(KategoriaID),
    FOREIGN KEY (DostawcaID) REFERENCES Dostawcy(DostawcaID)
);


CREATE TABLE Klienci (
    KlientID INT PRIMARY KEY AUTO_INCREMENT,
    Imie VARCHAR(255) NOT NULL,
    Nazwisko VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    Adres TEXT NOT NULL,
    Telefon VARCHAR(20) NOT NULL,
    Kraj VARCHAR(50) NOT NULL
);


CREATE TABLE Spedytorzy (
    SpedytorID INT PRIMARY KEY AUTO_INCREMENT,
    NazwaSpedytora VARCHAR(255) NOT NULL UNIQUE,
    Adres TEXT NOT NULL,
    Telefon VARCHAR(20) NOT NULL
);


CREATE TABLE Zamowienia (
    ZamowienieID INT PRIMARY KEY AUTO_INCREMENT,
    KlientID INT NOT NULL,
    DataZamowienia DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    StanZamowienia ENUM(
        'Przyjęte do realizacji',
        'W trakcie realizacji',
        'Zrealizowano',
        'Anulowano') NOT NULL,
    SpedytorID INT NOT NULL,
    DataWysylki DATETIME DEFAULT NULL,
    StatusWysylki ENUM('Wysłano', 'Dostarczono') DEFAULT NULL,
    NumerPrzesylki VARCHAR(50) DEFAULT NULL,
    InnyAdresZamowienia BOOLEAN NOT NULL DEFAULT false,
    AdresWysylki TEXT DEFAULT NULL,
    FOREIGN KEY (KlientID) REFERENCES Klienci(KlientID),
    FOREIGN KEY (SpedytorID) REFERENCES Spedytorzy(SpedytorID)
);


CREATE TABLE SzczegolyZamowienia (
    ZamowienieID INT NOT NULL,
    ProduktID INT NOT NULL,
    Ilosc INT NOT NULL,
    FOREIGN KEY (ZamowienieID) REFERENCES Zamowienia(ZamowienieID),
    FOREIGN KEY (ProduktID) REFERENCES Produkty(ProduktID)
);


CREATE TABLE Opinie (
    OpiniaID INT PRIMARY KEY AUTO_INCREMENT,
    ProduktID INT NOT NULL,
    KlientID INT NOT NULL,
    Ocena INT NOT NULL CHECK(Ocena >= 1 AND Ocena <= 5),
    Komentarz TEXT DEFAULT NULL,
    DataOpinii DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    FOREIGN KEY (ProduktID) REFERENCES Produkty(ProduktID),
    FOREIGN KEY (KlientID) REFERENCES Klienci(KlientID)
);

COMMIT;



-- WSTAWIANIE REKORDÓW
START TRANSACTION;

INSERT INTO Kategorie (KategoriaID, NazwaKategorii)
VALUES
    (1, 'Smartfony i Tablety'),
    (2, 'Laptopy i Komputery'),
    (3, 'Konsole i Gry'),
    (4, 'Słuchawki i Audio'),
    (5, 'Akcesoria Wearable'),
    (6, 'Klawiatury i Myszy'),
    (7, 'Monitory i Wyświetlacze'),
    (8, 'Aparaty i Kamery'),
    (9, 'Routery i Sieci'),
    (10, 'Drukarki i Skanery'),
    (11, 'Elektronika Rozrywkowa'),
    (12, 'Narzędzia Elektroniczne'),
    (13, 'Urządzenia Domowe'),
    (14, 'Projektory i Telewizory'),
    (15, 'Akcesoria Mobilne'),
    (16, 'Oczyszczacze Powietrza');


INSERT INTO Dostawcy (DostawcaID, NazwaDostawcy, Adres, Telefon, Email)
VALUES
    (1, 'TechWholesalers', 'Hauptstraße 123, Berlin, Germany, 10115', '765 123 4567', 'info@techwholesalers.com'),
    (2, 'GameTech', 'ul. Targowa 33, 03-728 Warszawa, Polska', '435 234 5678', 'sales@gametech.com'),
    (3, 'AudioPro', 'Rue de la Liberté 456, Paris, France, 75001', '125 345 6789', 'support@audiopro.net'),
    (4, 'TechMaster', 'ul. Wiejska 53, 55-728 Kraków, Polska', '543 456 7890', 'info@techmaster.com'),
    (5, 'TechWear', 'Calle Mayor 101, Madrid, Spain, 28001', '900 567 8901', 'sales@techwearables.com'),
    (6, 'GamerGear', '123 Maple Road, Boston, USA, 02101', '685 678 9012', 'info@gamergear.com'),
    (7, 'ViewTech', 'Hlavní třída 123, Prague, Czech Republic, 12000', '555 789 0123', 'support@viewtech.co'),
    (8, 'PhotoTech', 'ul. Nowogrodzka 12, 03-444 Warszawa, Polska', '455 890 1234', 'sales@phototech.com'),
    (9, 'TechPower', '456 Oak Avenue, Los Angeles, USA, 90001', '655 901 2345', 'info@techpower.net'),
    (10, 'TechRouters', 'Via Roma 789, Rome, Italy, 00100', '545 012 3456', 'support@techrouters.com');


INSERT INTO Produkty (ProduktID, NazwaProduktu, Cena, Opis, KategoriaID, Producent, DostawcaID, IloscWMagazynie)
VALUES
    (1, 'iPhone 13', 999.99, 'Nowy model iPhone z zaawansowaną kamerą.', 1, 'Apple', 2, 50),
    (2, 'Galaxy Tab S7', 799.99, 'Tablet Samsung z ekranem Super AMOLED.', 1, 'Samsung', 2, 30),
    (3, 'Dell XPS 15', 1499.99, 'Laptop Dell z procesorem Intel Core i7.', 2, 'Dell', 4, 20),
    (4, 'PlayStation 5', 499.99, 'Konsola do gier Sony z obsługą 4K.', 3, 'Sony', 6, 10),
    (5, 'Bose QuietComfort 45', 349.99, 'Słuchawki douszne z redukcją hałasu.', 4, 'Bose', 3, 40),
    (6, 'Harman Kardon SoundSticks III', 199.99, 'System głośników multimedialnych.', 4, 'Harman Kardon', 3, 15),
    (7, 'Sonos Beam', 399.99, 'Soundbar do kina domowego.', 4, 'Sonos', 3, 25),
    (8, 'Fitbit Versa 3', 199.99, 'Smartwatch do monitorowania aktywności.', 5, 'Fitbit', 5, 30),
    (9, 'Logitech G Pro X', 129.99, 'Mechaniczna klawiatura gamingowa.', 6, 'Logitech', 4, 50),
    (10, 'LG 27UK850-W', 499.99, 'Monitor 4K z obsługą HDR.', 7, 'LG', 2, 12),
    (11, 'Alienware AW3418DW', 999.99, 'Krzywy monitor gamingowy.', 7, 'Alienware', 4, 18),
    (12, 'Canon EOS 5D Mark IV', 2499.99, 'Profesjonalny aparat cyfrowy.', 8, 'Canon', 8, 8),
    (13, 'Linksys Velop', 299.99, 'System Wi-Fi mesh.', 9, 'Linksys', 10, 15),
    (14, 'TP-Link Deco M9 Plus', 199.99, 'Router mesh z funkcją antywirusową.', 9, 'TP-Link', 10, 20),
    (15, 'Asus RT-AX88U', 299.99, 'Router Wi-Fi 6.', 9, 'Asus', 10, 25),
    (16, 'NETGEAR Orbi RBK50', 349.99, 'System Wi-Fi mesh z satelitami.', 9, 'NETGEAR', 10, 14),
    (17, 'Epson EcoTank ET-4760', 499.99, 'Drukarka z zbiornikami na atrament.', 10, 'Epson', 4, 10),
    (18, 'HP LaserJet Pro M404n', 199.99, 'Laserowa drukarka monochromatyczna.', 10, 'HP', 4, 8),
    (19, 'Oculus Quest 2', 399.99, 'Gogle VR do gier i rozrywki.', 11, 'Oculus', 6, 22),
    (20, 'iFixit Essential Electronics Toolkit', 29.99, 'Narzędzia do naprawy elektroniki.', 12, 'iFixit', 9, 30),
    (21, 'iRobot Roomba 675', 299.99, 'Robot odkurzający.', 13, 'iRobot', 1, 15),
    (22, 'BenQ HT2050A', 699.99, 'Projektor do kina domowego.', 14, 'BenQ', 8, 7),
    (23, 'Anker PowerCore 26800', 59.99, 'Ładowarka przenośna z dużą pojemnością.', 15, 'Anker', 5, 40),
    (24, 'Coway AP-1512HH Mighty', 249.99, 'Oczyszczacz powietrza z filtrem HEPA.', 16, 'Coway', 7, 12),
    (25, 'GoPro HERO9 Black', 449.99, 'Kamera sportowa 5K.', 8, 'GoPro', 8, 9),
    (26, 'Braun Series 9 9390cc', 299.99, 'Elektryczna maszynka do golenia.', 13, 'Braun', 9, 18),
    (27, 'Logitech G Pro Wireless', 149.99, 'Bezprzewodowa myszka gamingowa.', 6, 'Logitech', 4, 35),
    (28, 'Xiaomi Mi Smart Band 6', 39.99, 'Smartband z monitorem tętna.', 5, 'Xiaomi', 2, 60),
    (29, 'Microsoft Surface Laptop 4', 1199.99, 'Laptop z procesorem AMD Ryzen.', 2, 'Microsoft', 4, 14),
    (30, 'Bosch IXO V Cordless Screwdriver', 39.99, 'Cordless screwdriver for home projects.', 12, 'Bosch', 10, 22);


INSERT INTO Klienci (KlientID, Imie, Nazwisko, Email, Adres, Telefon, Kraj)
VALUES
    (1, 'John', 'Doe', 'john.doe@example.com', '123 Main St, New York, USA, 10001', '+1 123-456-7890', 'USA'),
    (2, 'Alicja', 'Nowak', 'alicja.nowak@example.com', 'ul. Główna 2, 33-333 Kraków, Polska', '+48 234 567 890', 'Poland'),
    (3, 'Marek', 'Wójcik', 'marek.wojcik@example.com', 'ul. Stara 3, 44-444 Wrocław, Polska', '+48 345 678 901', 'Poland'),
    (4, 'Jean', 'Dupont', 'jean.dupont@example.com', '789 Rue de la Paix, Paris, France, 75001', '+33 1 2345 6789', 'France'),
    (5, 'Piotr', 'Dąbrowski', 'piotr.dabrowski@example.com', 'ul. Wiejska 5, 66-666 Łódź, Polska', '+48 567 890 123', 'Poland'),
    (6, 'Karolina', 'Lis', 'karolina.lis@example.com', 'ul. Górna 6, 77-777 Gdańsk, Polska', '+48 678 901 234', 'Poland'),
    (7, 'Hans', 'Schmidt', 'hans.schmidt@example.com', '123 Hauptstraße, Berlin, Germany, 10115', '+49 30 1234 5678', 'Germany'),
    (8, 'Magdalena', 'Pawlak', 'magdalena.pawlak@example.com', 'ul. Podgórna 8, 99-999 Szczecin, Polska', '+48 890 123 456', 'Poland'),
    (9, 'Robert', 'Kaczmarek', 'robert.kaczmarek@example.com', 'ul. Centralna 9, 11-111 Lublin, Polska', '+48 901 234 567', 'Poland'),
    (10, 'Alice', 'Johnson', 'alice.johnson@example.com', '456 Elm Ave, Los Angeles, USA, 90001', '+1 234-567-8901', 'USA');


INSERT INTO Spedytorzy (SpedytorID, NazwaSpedytora, Adres, Telefon)
VALUES
    (1, 'DPD Polska', 'ul. Targowa 33, 03-728 Warszawa, Polska', '+48 22 577 40 00'),
    (2, 'DHL Express Poland', 'ul. Komitetu Obrony Robotników 53, 02-146 Warszawa, Polska', '+48 22 534 00 00'),
    (3, 'InPost', 'ul. Gwiaździsta 62, 03-906 Warszawa, Polska', '+48 801 44 66 88'),
    (4, 'Poczta Polska', 'ul. Klonowa 1, 02-947 Warszawa, Polska', '+48 801 333 444');


INSERT INTO Zamowienia (ZamowienieID, KlientID, DataZamowienia, StanZamowienia, SpedytorID, DataWysylki, StatusWysylki, NumerPrzesylki, InnyAdresZamowienia, AdresWysylki)
VALUES
    (1, 1, '2023-10-20 08:00:00', 'Przyjęte do realizacji', 1, NULL, NULL, NULL, 1, 'ul. Inna 11, Kraków'),
    (2, 2, '2023-10-21 09:15:00', 'W trakcie realizacji', 2, '2023-10-22 15:45:00', 'Wysłano', '2345678901', 0, NULL),
    (3, 3, '2023-10-22 10:30:00', 'Zrealizowano', 1, '2023-10-23 16:00:00', 'Dostarczono', '3456789012', 0, NULL),
    (4, 4, '2023-10-23 11:45:00', 'Przyjęte do realizacji', 2, NULL, NULL, NULL, 1, 'ul. Główna 4, Poznań'),
    (5, 5, '2023-10-24 13:00:00', 'W trakcie realizacji', 1, '2023-10-25 18:30:00', 'Wysłano', '5678901234', 0, NULL),
    (6, 6, '2023-10-25 14:15:00', 'Zrealizowano', 3, '2023-10-26 19:45:00', 'Dostarczono', '6789012345', 0, NULL),
    (7, 7, '2023-10-26 15:30:00', 'Przyjęte do realizacji', 3, NULL, NULL, NULL, 1, 'ul. Stara 7, Katowice'),
    (8, 8, '2023-10-27 16:45:00', 'W trakcie realizacji', 4, '2023-10-28 21:15:00', 'Wysłano', '8901234567', 0, NULL),
    (9, 9, '2023-10-28 18:00:00', 'Zrealizowano', 4, '2023-10-29 22:30:00', 'Dostarczono', '9012345678', 1, 'ul. Dolna 9, Lublin'),
    (10, 10, '2023-10-29 19:15:00', 'Przyjęte do realizacji', 2, NULL, NULL, NULL, 0, NULL);


INSERT INTO SzczegolyZamowienia (ZamowienieID, ProduktID, Ilosc)
VALUES
    (1, 1, 3),
    (1, 3, 2),
    (2, 5, 4),
    (3, 30, 1),
    (3, 6, 2),
    (4, 9, 3),
    (4, 11, 2),
    (4, 13, 1),
    (5, 4, 5),
    (5, 7, 4),
    (6, 8, 2),
    (7, 28, 1),
    (7, 26, 1),
    (7, 15, 3),
    (8, 16, 2),
    (8, 18, 4),
    (8, 21, 2),
    (9, 24, 1),
    (9, 27, 1),
    (10, 29, 2);


INSERT INTO Opinie (OpiniaID, ProduktID, KlientID, Ocena, Komentarz, DataOpinii)
VALUES
    (1, 1, 1, 5, 'Bardzo dobry telefon!', '2023-10-21 12:30:00'),
    (2, 3, 1, 4, 'Laptop działa płynnie.', '2023-10-22 13:45:00'),
    (3, 5, 2, 5, 'Słuchawki z doskonałym dźwiękiem.', '2023-10-23 14:45:00'),
    (4, 9, 4, 4, 'Klawiatura jest wygodna.', '2023-10-24 15:30:00'),
    (5, 11, 4, 5, 'Monitor spełnił moje oczekiwania.', '2023-10-25 16:30:00'),
    (6, 13, 4, 3, 'Router działa poprawnie.', '2023-10-26 17:15:00'),
    (7, 15, 7, 4, 'Bardzo dobry router mesh.', '2023-10-27 18:15:00'),
    (8, 18, 8, 4, 'Drukarka działa bez zarzutu.', '2023-10-28 19:00:00'),
    (9, 21, 8, 5, 'Robot odkurzający oszczędza czas.', '2023-10-29 20:00:00'),
    (10, 24, 9, 4, 'Oczyszczacz powietrza działa cicho.', '2023-10-30 21:00:00'),
    (11, 26, 7, 4, 'Braun to marka godna zaufania.', '2023-11-01 22:00:00'),
    (12, 28, 7, 5, 'Smartband jest bardzo użyteczny.', '2023-11-02 23:00:00'),
    (13, 29, 10, 4, 'Laptop Microsofta działa szybko.', '2023-11-03 13:00:00'),
    (14, 30, 3, 3, 'Dobry zestaw narzędzi.', '2023-11-04 14:00:00');

COMMIT;