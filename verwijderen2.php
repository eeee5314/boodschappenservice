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

// Controleren of een bestelnummer is ingediend
if (isset($_POST['order_number']) && isset($_POST['type'])) {
    $orderNumber = $_POST['order_number'];
    $type = $_POST['type'];

    // Verwijder de gegevens op basis van het type
    switch ($type) {
        case 'verkoop':
            $table = 'verkooporders';
            $column = 'verkordid';
            break;
        case 'inkoop':
            $table = 'inkooporders';
            $column = 'inkordid';
            break;
        default:
            die("Ongeldig type.");
    }

    // Verwijder de gegevens
    $sql = "DELETE FROM $table WHERE $column = '$orderNumber'";

    if ($conn->query($sql) === TRUE) {
        echo "Gegevens zijn succesvol verwijderd.";

        // Toon de klantgegevens
        $customerId = $_POST['customer_id'];
        $customerSql = "SELECT * FROM klanten WHERE klantid = '$customerId'";
        $customerResult = $conn->query($customerSql);

        if ($customerResult->num_rows > 0) {
            $row = $customerResult->fetch_assoc();
            echo "Klantgegevens:<br>";
            echo "Naam: " . $row['name'] . "<br>";
            echo "Adres: " . $row['address'] . "<br>";
            echo "Stad: " . $row['city'] . "<br>";
            echo "Land: " . $row['country'] . "<br>";
        } else {
            echo "Geen klantgegevens gevonden.";
        }
    } else {
        echo "Fout bij het verwijderen van gegevens: " . $conn->error;
    }
}

// Formulier om gegevens te verwijderen
echo "<form method='post' action=''>";
echo "<input type='hidden' name='customer_id' value='123'>"; // Vervang '123' door het daadwerkelijke klant-ID
echo "<select name='type'>";
echo "<option value='verkoop'>Verkooporder</option>";
echo "<option value='inkoop'>Inkooporder</option>";
echo "</select>";
echo "<input type='text' name='order_number' placeholder='Bestelnummer'>";
echo "<input type='submit' value='Verwijderen'>";
echo "</form>";

// Sluit de databaseverbinding
$conn->close();
?>
