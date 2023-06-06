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

// Controleren of een ID is ingediend
if (isset($_POST['id']) && isset($_POST['type'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];

    // Verwijder de gegevens op basis van het type
    switch ($type) {
        case 'klant':
            $table = 'klanten';
            $relatedTable = 'verkooporders';
            $relatedColumn = 'klantId';
            break;
        case 'leverancier':
            $table = 'leveranciers';
            break;
        case 'product':
            $table = 'producten';
            break;
        default:
            die("Ongeldig type.");
    }

    // Verwijder eerst gerelateerde gegevens
    if (isset($relatedTable) && isset($relatedColumn)) {
        $relatedSql = "DELETE FROM $relatedTable WHERE $relatedColumn = $id";
        if ($conn->query($relatedSql) !== TRUE) {
            echo "Fout bij het verwijderen van gerelateerde gegevens: " . $conn->error;
            exit;
        }
    }

    // Verwijder de gegevens
    $sql = "DELETE FROM $table WHERE klantid = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Gegevens zijn succesvol verwijderd.";
    } else {
        echo "Fout bij het verwijderen van gegevens: " . $conn->error;
    }
}

// Formulier om gegevens te verwijderen
echo "<form method='post' action=''>";
echo "<select name='type'>";
echo "<option value='klant'>Klant</option>";
echo "<option value='leverancier'>Leverancier</option>";
echo "<option value='product'>Product</option>";
echo "</select>";
echo "<input type='text' name='id' placeholder='ID'>";
echo "<input type='submit' value='Verwijderen'>";
echo "</form>";

// Sluit de databaseverbinding
$conn->close();
?>
