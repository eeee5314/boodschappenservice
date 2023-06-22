<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "boodschappenservice";

try {
    // Maak de databaseverbinding met PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Zet de foutmodus in uitzonderingen
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Controleren of een klant-ID is ingediend
if (isset($_POST['customer_id'])) {
    $customerId = $_POST['customer_id'];

    // Query om de klantgegevens op te halen
    $sql = "SELECT * FROM customers WHERE klantid = :customer_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':customer_id', $customerId);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Toon de klantgegevens
        echo "Klantgegevens:<br>";
        echo "Klant ID: " . $result['klantid'] . "<br>";
        echo "Klantnaam: " . $result['klantnaam'] . "<br>";
        echo "Klantemail: " . $result['klantemail'] . "<br>";
        echo "Klantadres: " . $result['klantadres'] . "<br>";
        echo "Klantpostcode: " . $result['klantpostcode'] . "<br>";
        echo "Klantwoonplaats: " . $result['klantwoonplaats'] . "<br>";
    } else {
        echo "Geen klant gevonden met het opgegeven klant-ID.";
    }
}

// Formulier om op klant-ID te zoeken
echo "<form method='post' action=''>";
echo "<input type='text' name='customer_id' placeholder='Klant-ID'>";
echo "<input type='submit' value='Zoeken'>";
echo "</form>";

// Sluit de databaseverbinding
$conn = null;
?>
