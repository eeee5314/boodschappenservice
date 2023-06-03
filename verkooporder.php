<?php
class Database {
    private $conn;

    public function __construct($servername, $username, $password, $dbname) {
        $this->conn = new mysqli($servername, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Verbinding met de database is mislukt: " . $this->conn->connect_error);
        }
    }

    public function insertVerkooporder($verkOrdId, $klantId, $artId, $verkOrdDatum, $verkOrdBestAantal, $verkOrdStatus) {
        $sql = "INSERT INTO verkooporders (verkOrdId, klantId, artId, verkOrdDatum, verkOrdBestAantal, verkOrdStatus) VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiisss", $verkOrdId, $klantId, $artId, $verkOrdDatum, $verkOrdBestAantal, $verkOrdStatus);

        if ($stmt->execute()) {
            echo "Verkooporder is succesvol aangemaakt.";
        } else {
            echo "Fout bij het aanmaken van de verkooporder: " . $stmt->error;
        }

        $stmt->close();
    }

    public function getKlanten() {
        $sql = "SELECT klantId, klantNaam FROM klanten";
        $result = $this->conn->query($sql);

        $klanten = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $klanten[$row['klantId']] = $row['klantNaam'];
            }
        }

        return $klanten;
    }

    public function getArtikelen() {
        $sql = "SELECT artId, artOmschrijving FROM artikelen";
        $result = $this->conn->query($sql);

        $artikelen = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $artikelen[$row['artId']] = $row['artOmschrijving'];
            }
        }

        return $artikelen;
    }

    public function close() {
        $this->conn->close();
    }
}

// Verbinding maken met de database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "boodschappenservice";

$database = new Database($servername, $username, $password, $dbname);

// Controleren of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Waarden ophalen uit het formulier
    $verkOrdId = $_POST["verkOrdId"];
    $klantId = $_POST["klantId"];
    $artId = $_POST["artId"];
    $verkOrdDatum = $_POST["verkOrdDatum"];
    $verkOrdBestAantal = $_POST["verkOrdBestAantal"];
    $verkOrdStatus = $_POST["verkOrdStatus"];

    // Verkooporder aanmaken
    $database->insertVerkooporder($verkOrdId, $klantId, $artId, $verkOrdDatum, $verkOrdBestAantal, $verkOrdStatus);
}

// Klanten ophalen
$klanten = $database->getKlanten();

// Artikelen ophalen
$artikelen = $database->getArtikelen();

// Verbinding met de database sluiten
$database->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verkooporder aanmaken</title>
</head>
<body>
    <h1>Verkooporder aanmaken</h1>
    
    <form method="POST" action="">
        <label for="verkOrdId">Verkooporder ID:</label>
        <input type="text" name="verkOrdId" id="verkOrdId" required><br>

        <label for="klantId">Klant:</label>
        <select name="klantId" id="klantId" required>
            <option value="">Selecteer een klant</option>
            <?php foreach ($klanten as $klantId => $klantNaam): ?>
                <option value="<?php echo $klantId; ?>"><?php echo $klantNaam; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="artId">Artikel:</label>
        <select name="artId" id="artId" required>
            <option value="">Selecteer een artikel</option>
            <?php foreach ($artikelen as $artId => $artOmschrijving): ?>
                <option value="<?php echo $artId; ?>"><?php echo $artOmschrijving; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="verkOrdDatum">Datum:</label>
        <input type="date" name="verkOrdDatum" id="verkOrdDatum" required><br>

        <label for="verkOrdBestAantal">Bestelde hoeveelheid:</label>
        <input type="text" name="verkOrdBestAantal" id="verkOrdBestAantal" required><br>

        <label for="verkOrdStatus">Status:</label>
        <input type="text" name="verkOrdStatus" id="verkOrdStatus" required><br>

        <input type="submit" value="Verkooporder aanmaken">
    </form>
</body>
</html>
