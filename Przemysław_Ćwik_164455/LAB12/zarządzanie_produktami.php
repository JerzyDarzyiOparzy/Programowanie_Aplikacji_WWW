<?php

class ZarzadzanieProduktami {
    private $conn;

    public function __construct($host, $username, $password, $database) {
        $this->conn = new mysqli($host, $username, $password, $database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        $this->utworzTabele();
    }

    public function utworzTabele() {
        $sql = "
            CREATE TABLE IF NOT EXISTS Produkty (
                id INT AUTO_INCREMENT PRIMARY KEY,
                tytul VARCHAR(255),
                opis TEXT,
                data_utworzenia DATE,
                data_modyfikacji DATE,
                data_wygasniecia DATE,
                cena_netto DECIMAL(10, 2),
                podatek_vat DECIMAL(5, 2),
                ilosc_dostepnych_sztuk INT,
                status_dostepnosci ENUM('Dostępny', 'Niedostępny'),
                kategoria VARCHAR(255),
                gabaryt_produktu VARCHAR(255),
                zdjecie TEXT
            )
        ";

        if ($this->conn->query($sql) === FALSE) {
            die("Error creating table: " . $this->conn->error);
        }
    }

    public function dodajProdukt($tytul, $opis, $data_utworzenia, $data_modyfikacji, $data_wygasniecia, 
        $cena_netto, $podatek_vat, $ilosc_dostepnych_sztuk, $status_dostepnosci, $kategoria, 
        $gabaryt_produktu, $zdjecie) {
        
        $sql = "
            INSERT INTO Produkty (tytul, opis, data_utworzenia, data_modyfikacji, data_wygasniecia, 
                cena_netto, podatek_vat, ilosc_dostepnych_sztuk, status_dostepnosci, kategoria, 
                gabaryt_produktu, zdjecie) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssssss", $tytul, $opis, $data_utworzenia, $data_modyfikacji, 
            $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc_dostepnych_sztuk, $status_dostepnosci, 
            $kategoria, $gabaryt_produktu, $zdjecie);

        if ($stmt->execute() === FALSE) {
            die("Error adding product: " . $this->conn->error);
        }

        $stmt->close();
    }

    public function usunProdukt($id_produktu) {
        $sql = "
            DELETE FROM Produkty WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_produktu);

        if ($stmt->execute() === FALSE) {
            die("Error deleting product: " . $this->conn->error);
        }

        $stmt->close();
    }

    public function edytujProdukt($id_produktu, $nowe_dane) {
    }

    public function pokazProdukty() {
        $result = $this->conn->query("SELECT * FROM Produkty");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row["id"] . ", Tytuł: " . $row["tytul"] . ", Cena: " . $row["cena_netto"] . "<br>";
            }
        } else {
            echo "Brak produktów w bazie danych.";
        }
    }
}

$zarzadzanieProduktami = new ZarzadzanieProduktami("localhost", "username", "password", "my_database");

$zarzadzanieProduktami->dodajProdukt("Laptop", "Szybki laptop z nowoczesnym procesorem", "2022-01-01", "2022-01-01", "2023-01-01", 
    2500.00, 0.23, 10, "Dostępny", "Elektronika", "Standardowy", "url/do/zdjecia/laptopa.jpg");

$zarzadzanieProduktami->pokazProdukty();

?>
