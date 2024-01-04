<?php

class ZarzadzanieKategoriami {
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
            CREATE TABLE IF NOT EXISTS Kategorie (
                id INT AUTO_INCREMENT PRIMARY KEY,
                matka INT DEFAULT 0,
                nazwa VARCHAR(255)
            )
        ";

        if ($this->conn->query($sql) === FALSE) {
            die("Error creating table: " . $this->conn->error);
        }
    }

    public function dodajKategorie($matka, $nazwa) {
        $sql = "
            INSERT INTO Kategorie (matka, nazwa) VALUES (?, ?)
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $matka, $nazwa);

        if ($stmt->execute() === FALSE) {
            die("Error adding category: " . $this->conn->error);
        }

        $stmt->close();
    }

    public function usunKategorie($id_kategorii) {
        $sql = "
            DELETE FROM Kategorie WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_kategorii);

        if ($stmt->execute() === FALSE) {
            die("Error deleting category: " . $this->conn->error);
        }

        $stmt->close();
    }

    public function edytujKategorie($id_kategorii, $nowa_nazwa) {
        $sql = "
            UPDATE Kategorie SET nazwa = ? WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $nowa_nazwa, $id_kategorii);

        if ($stmt->execute() === FALSE) {
            die("Error updating category: " . $this->conn->error);
        }

        $stmt->close();
    }

    public function pokazKategorie() {
        $result = $this->conn->query("SELECT * FROM Kategorie");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row["id"] . ", Matka: " . $row["matka"] . ", Nazwa: " . $row["nazwa"] . "<br>";
            }
        } else {
            echo "Brak kategorii w bazie danych.";
        }
    }

    public function generujDrzewoKategorii() {
        $result = $this->conn->query("SELECT * FROM Kategorie WHERE matka = 0");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "Kategoria główna: " . $row["nazwa"] . "<br>";

                $subcategories = $this->conn->query("SELECT * FROM Kategorie WHERE matka = " . $row["id"]);

                if ($subcategories->num_rows > 0) {
                    while ($subrow = $subcategories->fetch_assoc()) {
                        echo "&nbsp;&nbsp;&nbsp;Podkategoria: " . $subrow["nazwa"] . "<br>";
                    }
                }
            }
        } else {
            echo "Brak kategorii głównych w bazie danych.";
        }
    }
}

$zarzadzanieKategoriami = new ZarzadzanieKategoriami("localhost", "username", "password", "my_database");

$zarzadzanieKategoriami->dodajKategorie(0, "Elektronika");
$zarzadzanieKategoriami->dodajKategorie(1, "Telewizory");
$zarzadzanieKategoriami->dodajKategorie(1, "Laptopy");

$zarzadzanieKategoriami->pokazKategorie();
$zarzadzanieKategoriami->generujDrzewoKategorii();

?>
