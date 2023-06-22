<?php

class Database {
    private $conn;

    public function __construct($servername, $username, $password, $dbname) {
        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Verbinding met de database is mislukt: " . $e->getMessage());
        }
    }

    public function insertKlant($klantNaam, $klantEmail, $klantAdres, $klantPostcode, $klantWoonplaats) {
        // Controleren op dubbele klanten
        $existingQuery = "SELECT COUNT(*) as count FROM KLANTEN WHERE klantEmail = :klantEmail";
        $existingStmt = $this->conn->prepare($existingQuery);
        $existingStmt->bindParam(':klantEmail', $klantEmail);
        $existingStmt->execute();
        $existingCount = $existingStmt->fetchColumn();

        if ($existingCount > 0) {
            return 'Dubbele klant';
        }

        // Klant toevoegen aan de database
        $sql = "INSERT INTO KLANTEN (klantNaam, klantEmail, klantAdres, klantPostcode, klantWoonplaats)
                VALUES (:klantNaam, :klantEmail, :klantAdres, :klantPostcode, :klantWoonplaats)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':klantNaam', $klantNaam);
        $stmt->bindParam(':klantEmail', $klantEmail);
        $stmt->bindParam(':klantAdres', $klantAdres);
        $stmt->bindParam(':klantPostcode', $klantPostcode);
        $stmt->bindParam(':klantWoonplaats', $klantWoonplaats);

        if ($stmt->execute()) {
            return 'Succesvol toegevoegd';
        } else {
            return 'Fout bij het toevoegen van de klant: ' . $stmt->errorInfo()[2];
        }
    }

    public function close() {
        $this->conn = null;
    }
}

// Verbinding maken met de database
$servername = "localhost";
$username = "root";
$dbname = "boodschappenservice";

$database = new Database($servername, $username, '', $dbname);

// Controleren of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Waarden ophalen uit het formulier
    $klantNaam = $_POST["klantNaam"];
    $klantEmail = $_POST["klantEmail"];
    $klantAdres = $_POST["klantAdres"];
    $klantPostcode = $_POST["klantPostcode"];
    $klantWoonplaats = $_POST["klantWoonplaats"];

    // Klant toevoegen aan de database
    $result = $database->insertKlant($klantNaam, $klantEmail, $klantAdres, $klantPostcode, $klantWoonplaats);

    if ($result === 'Succesvol toegevoegd') {
        $message = "Nieuwe klant is succesvol toegevoegd.";
    } elseif ($result === 'Dubbele klant') {
        $message = "Deze klant bestaat al.";
    } else {
        $message = "Fout bij het toevoegen van de klant.";
    }
}

// Verbinding met de database sluiten
$database->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Nieuwe klant toevoegen</title>
</head>
<body>
    <h1>Nieuwe klant toevoegen</h1>
    
    <?php if (isset($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="klantNaam">Naam:</label>
        <input type="text" name="klantNaam" id="klantNaam" required>
        
        <label for="klantEmail">E-mail:</label>
        <input type="email" name="klantEmail" id="klantEmail" required>
        
        <label for="klantAdres">Adres:</label>
        <input type="text" name="klantAdres" id="klantAdres" required>
        
        <label for="klantPostcode">Postcode:</label>
        <input type="text" name="klantPostcode" id="klantPostcode" required>
        
        <label for="klantWoonplaats">Woonplaats:</label>
        <input type="text" name="klantWoonplaats" id="klantWoonplaats" required>
        
        <input type="submit" value="Klant toevoegen">
    </form>
</body>
</html>
