<?php
// Verkooporder.php

class Verkooporder {
    private $db;

    public function __construct() {
        // Databaseverbinding opzetten met PDO
        $dsn = 'mysql:host=localhost;dbname=boodschappenservice';
        $username = 'root';
        $password = '';

        try {
            $this->db = new PDO($dsn, $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
            exit;
        }
    }

    public function getVerkooporderDetails($orderID) {
        try {
            // Prepared statement om verkoopordergegevens op te halen op basis van order-ID
            $stmt = $this->db->prepare("SELECT * FROM verkooporders WHERE orderID = :orderID");
            $stmt->bindParam(':orderID', $orderID);
            $stmt->execute();

            // Verkoopordergegevens ophalen als rijassociatieve array
            $orderData = $stmt->fetch(PDO::FETCH_ASSOC);

            return $orderData;
        } catch (PDOException $e) {
            echo "Error retrieving order details: " . $e->getMessage();
            exit;
        }
    }

    public function updateVerkooporder($orderID, $klantID, $bestelDatum, $leverDatum) {
        try {
            // Prepared statement om verkoopordergegevens bij te werken in de database
            $stmt = $this->db->prepare("UPDATE verkooporders SET klantID = :klantID, bestelDatum = :bestelDatum, leverDatum = :leverDatum WHERE orderID = :orderID");
            $stmt->bindParam(':orderID', $orderID);
            $stmt->bindParam(':klantID', $klantID);
            $stmt->bindParam(':bestelDatum', $bestelDatum);
            $stmt->bindParam(':leverDatum', $leverDatum);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error updating order: " . $e->getMessage();
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Verkooporder bijwerken</title>
    <!-- Voeg hier de CSS-styling toe -->
</head>
<body>
    <?php
    require_once 'Verkooporder.php';

    // Controleren of een order-ID is doorgegeven via de querystring
    if (isset($_GET['orderID'])) {
        // Order-ID uit de querystring ophalen
        $orderID = $_GET['orderID'];

        // Nieuwe instantie van de Verkooporder klasse maken
        $order = new Verkooporder();

        // Ordergegevens ophalen op basis van order-ID
        $orderData = $order->getVerkooporderDetails($orderID);

        // Controleren of ordergegevens zijn opgehaald
        if ($orderData) {
            // Ordergegevens weergeven in een formulier
            echo "<h1>Verkooporder bijwerken</h1>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='orderID' value='" . $orderData['orderID'] . "'>";
            echo "Klant ID: <input type='text' name='klantID' value='" . $orderData['klantID'] . "'><br>";
            echo "Bestel Datum: <input type='text' name='bestelDatum' value='" . $orderData['bestelDatum'] . "'><br>";
            echo "Lever Datum: <input type='text' name='leverDatum' value='" . $orderData['leverDatum'] . "'><br>";
            echo "<input type='submit' value='Bijwerken'>";
            echo "</form>";

            // Controleren of het bijwerken van de order is ingediend
            if (isset($_POST['klantID']) && isset($_POST['bestelDatum']) && isset($_POST['leverDatum'])) {
                $klantID = $_POST['klantID'];
                $bestelDatum = $_POST['bestelDatum'];
                $leverDatum = $_POST['leverDatum'];

                // Ordergegevens bijwerken in de database
                $order->updateVerkooporder($orderID, $klantID, $bestelDatum, $leverDatum);

                echo "Verkooporder is bijgewerkt.";
            }
        } else {
            echo "Geen verkooporder gevonden met het opgegeven ID.";
        }
    } else {
        echo "Geen order-ID doorgegeven.";
    }
    ?>
</body>
</html>
