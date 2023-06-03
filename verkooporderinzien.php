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

    public function getVerkooporders() {
        $sql = "SELECT * FROM verkooporders";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            $verkooporders = [];

            while ($row = $result->fetch_assoc()) {
                $verkooporders[] = $row;
            }

            return $verkooporders;
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

// Verkooporders ophalen
$verkooporders = $database->getVerkooporders();

// Databaseverbinding sluiten
$database->closeConnection();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Verkooporders</title>
    <style>
        table {
            width: 75%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Verkooporders</h1>

    <?php if (!empty($verkooporders)): ?>
        <table>
            <tr>
                <th>Verkooporder ID</th>
                <th>Klant ID</th>
                <th>Artikel ID</th>
                <!-- Voeg andere kolomkoppen toe voor de andere velden -->
            </tr>
            <?php foreach ($verkooporders as $verkooporder): ?>
                <tr>
                    <td><?php echo $verkooporder['verkOrdId']; ?></td>
                    <td><?php echo $verkooporder['klantId']; ?></td>
                    <td><?php echo $verkooporder['artId']; ?></td>
                    <!-- Voeg andere celwaarden toe voor de andere velden -->
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Geen verkooporders gevonden.</p>
    <?php endif; ?>
</body>
</html>
