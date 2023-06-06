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

// Controleren of een order is geselecteerd
if (isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['new_status'];

    // Query om de orderstatus bij te werken
    $sql = "UPDATE orders SET status = '$newStatus' WHERE id = $orderId";

    if ($conn->query($sql) === TRUE) {
        echo "Orderstatus is succesvol bijgewerkt.";
    } else {
        echo "Fout bij het bijwerken van de orderstatus: " . $conn->error;
    }
}

// Query om de orders op te halen
$sql = "SELECT id, order_number, status FROM orders";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Formulier om orderstatus bij te werken
    echo "<form method='post' action=''>";
    echo "<select name='order_id'>";
    while ($row = $result->fetch_assoc()) {
        $orderId = $row['id'];
        $orderNumber = $row['order_number'];
        $orderStatus = $row['status'];
        echo "<option value='$orderId'>$orderNumber - $orderStatus</option>";
    }
    echo "</select>";
    echo "<input type='text' name='new_status' placeholder='Nieuwe status'>";
    echo "<input type='submit' value='Bijwerken'>";
    echo "</form>";
} else {
    echo "Geen orders gevonden.";
}

// Sluit de databaseverbinding
$conn->close();
?>
