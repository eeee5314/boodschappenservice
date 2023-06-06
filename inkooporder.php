
<?php

class Database {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $connection;

    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        // Verbinding maken met de database
        $this->connection = new mysqli($servername, $username, $password, $dbname);

        // Controleren op fouten bij het maken van de verbinding
        if ($this->connection->connect_error) {
            die("Verbinding mislukt: " . $this->connection->connect_error);
        }
    }

    public function insertInkooporder($levId, $artId, $inkOrdDatum, $aantal) {
        $sql = "INSERT INTO inkooporders (levId, artId, inkOrdDatum, aantal) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("iisi", $levId, $artId, $inkOrdDatum, $aantal);
    
        if ($stmt->execute()) {
            echo "Inkooporder succesvol toegevoegd.";
        } else {
            echo "Fout bij het toevoegen van de inkooporder: " . $stmt->error;
        }
    
        $stmt->close();
    }
    

    public function getLeveranciers() {
        $sql = "SELECT * FROM leveranciers";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            $leveranciers = [];

            while ($row = $result->fetch_assoc()) {
                $leveranciers[] = $row;
            }

            return $leveranciers;
        } else {
            return [];
        }
    }

    public function getArtikelen() {
        $sql = "SELECT * FROM artikelen";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            $artikelen = [];

            while ($row = $result->fetch_assoc()) {
                $artikelen[] = $row;
            }

            return $artikelen;
        } else {
            return [];
        }
    }

    public function closeConnection() {
        $this->connection->close();
    }
}

// Verbinding maken met de database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "boodschappenservice";

$database = new Database($servername, $username, $password, $dbname);

// Leveranciers en artikelen ophalen
$leveranciers = $database->getLeveranciers();
$artikelen = $database->getArtikelen();

// Inkooporder toevoegen
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $levId = $_POST["leverancier"];
    $artId = $_POST["artikel"];
    $inkOrdDatum = $_POST["datum"];
    $aantal = $_POST["aantal"];

    $database->insertInkooporder($levId, $artId, $inkOrdDatum, $aantal);
}

// Formulier weergeven
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inkooporder</title>
</head>
<body>
    <h2>Maak een inkooporder</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="leverancier">Leverancier:</label>
        <select name="leverancier" id="leverancier">
            <?php foreach ($leveranciers as $leverancier): ?>
                <option value="<?php echo $leverancier["levid"]; ?>"><?php echo $leverancier["levnaam"]; ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <label for="artikel">Artikel:</label>
        <select name="artikel" id="artikel">
            <?php foreach ($artikelen as $artikel): ?>
                <option value="<?php echo $artikel["artId"]; ?>"><?php echo $artikel["artOmschrijving"]; ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <label for="datum">Datum:</label>
        <input type="date" name="datum" id="datum">
        <br><br>
        <label for="aantal">Aantal:</label>
        <input type="number" name="aantal" id="aantal">
        <br><br>
        <input type="submit" value="Inkooporder plaatsen">
    </form>
</body>
</html>

<?php
// Databaseverbinding sluiten
$database->closeConnection();

?>
