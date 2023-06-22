<?php

require_once 'config.php';

class Database {
    private $dsn;
    private $username;
    private $password;
    private $connection;

    public function __construct($dsn, $username, $password) {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;

        try {
            // Verbinding maken met de database met behulp van PDO
            $this->connection = new PDO($dsn, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Verbinding mislukt: " . $e->getMessage());
        }
    }

    public function getArtikelen() {
        $sql = "SELECT artId, artOmschrijving, artInkoop, artVerkoop, artVoorraad, artMinVoorraad, artMaxVoorraad, artLocatie FROM artikelen";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $artikelen = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $artikelen;
    }

    public function closeConnection() {
        $this->connection = null;
    }
}

// Verbinding maken met de database
$dsn = 'mysql:host=localhost;dbname=boodschappenservice';
$username = 'root';
$password = '';

$database = new Database($dsn, $username, $password);

// Artikelen ophalen
$artikelen = $database->getArtikelen();

// Controleren of artikelen zijn gevonden
if (!empty($artikelen)) {
    echo "<table>";
    echo "<tr>";
    echo "<th>Artikel ID</th>";
    echo "<th>Omschrijving</th>";
    echo "<th>Inkoopprijs</th>";
    echo "<th>Verkoopprijs</th>";
    echo "<th>Voorraad</th>";
    echo "<th>Minimale Voorraad</th>";
    echo "<th>Maximale Voorraad</th>";
    echo "<th>Locatie</th>";
    echo "</tr>";

    foreach ($artikelen as $artikel) {
        echo "<tr>";
        echo "<td>" . $artikel['artId'] . "</td>";
        echo "<td>" . $artikel['artOmschrijving'] . "</td>";
        echo "<td>" . $artikel['artInkoop'] . "</td>";
        echo "<td>" . $artikel['artVerkoop'] . "</td>";
        echo "<td>" . $artikel['artVoorraad'] . "</td>";
        echo "<td>" . $artikel['artMinVoorraad'] . "</td>";
        echo "<td>" . $artikel['artMaxVoorraad'] . "</td>";
        echo "<td>" . $artikel['artLocatie'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Geen artikelen gevonden.";
}

// Databaseverbinding sluiten
$database->closeConnection();

?>
