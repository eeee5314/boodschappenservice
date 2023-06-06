<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "boodschappenservice";

// Maak de databaseverbinding
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Controleren of een klant-ID is ingediend
if (isset($_POST['customer_id'])) {
    $customerId = $_POST['customer_id'];

    // Query om de klantgegevens op te halen
    $sql = "SELECT * FROM customers WHERE klantid = '$customerId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Toon de klantgegevens
        $row = $result->fetch_assoc();
        echo "Klantgegevens:<br>";
        echo "Klant ID: " . $row['klantid'] . "<br>";
        echo "Klantnaam: " . $row['klantnaam'] . "<br>";
        echo "Klantemail: " . $row['klantemail'] . "<br>";
        echo "Klantadres: " . $row['klantadres'] . "<br>";
        echo "Klantpostcode: " . $row['klantpostcode'] . "<br>";
        echo "Klantwoonplaats: " . $row['klantwoonplaats'] . "<br>";
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
$conn->close();
?>
