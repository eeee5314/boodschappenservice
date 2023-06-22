<?php

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

    public function getKlanten() {
        $sql = "SELECT klantId, klantNaam FROM klanten";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $klanten = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $klanten;
    }

    public function getArtikelen() {
        $sql = "SELECT artId, artOmschrijving FROM artikelen";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $artikelen = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $artikelen;
    }

    public function insertVerkooporder($klantId, $artId, $verkOrdDatum, $aantal) {
        $sql = "INSERT INTO verkooporders (klantId, artId, verkOrdDatum, verkordbestaantal) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $klantId);
        $stmt->bindValue(2, $artId);
        $stmt->bindValue(3, $verkOrdDatum);
        $stmt->bindValue(4, $aantal);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
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

// Klanten en artikelen ophalen
$klanten = $database->getKlanten();
$artikelen = $database->getArtikelen();

// Controleren of klanten en artikelen zijn gevonden
if (!empty($klanten) && !empty($artikelen)) {
    // Formulier weergeven
    echo "<form method='post' action=''>";
    echo "<label for='klantId'>Klant:</label>";
    echo "<select name='klantId' id='klantId'>";
    foreach ($klanten as $klant) {
        echo "<option value='" . $klant['klantId'] . "'>" . $klant['klantNaam'] . "</option>";
    }
    echo "</select>";

    echo "<label for='artId'>Artikel:</label>";
    echo "<select name='artId' id='artId'>";
    foreach ($artikelen as $artikel) {
        echo "<option value='" . $artikel['artId'] . "'>" . $artikel['artOmschrijving'] . "</option>";
    }
    echo "</select>";

    echo "<label for='verkOrdDatum'>Verkoopdatum:</label>";
    echo "<input type='date' name='verkOrdDatum' id='verkOrdDatum'>";

    echo "<label for='aantal'>Aantal:</label>";
    echo "<input type='number' name='aantal' id='aantal'>";

    echo "<input type='submit' name='submit' value='Verkooporder plaatsen'>";
    echo "</form>";

    // Verkooporder verwerken
    if (isset($_POST['submit'])) {
        $klantId = $_POST['klantId'];
        $artId = $_POST['artId'];
        $verkOrdDatum = $_POST['verkOrdDatum'];
        $aantal = $_POST['aantal'];

        if ($database->insertVerkooporder($klantId, $artId, $verkOrdDatum, $aantal)) {
            echo "Verkooporder succesvol geplaatst.";
        } else {
            echo "Er is een fout opgetreden bij het plaatsen van de verkooporder.";
        }
    }
} else {
    echo "Geen klanten of artikelen gevonden.";
}

// Databaseverbinding sluiten
$database->closeConnection();

?>
