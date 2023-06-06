
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

    public function getArtikelen() {
        $sql = "SELECT artId, artOmschrijving, artInkoop, artVerkoop, artVoorraad, artMinVoorraad, artMaxVoorraad, artLocatie FROM artikelen";
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

// Artikelen ophalen
$artikelen = $database->getArtikelen();

// Controleren of artikelen zijn gevonden
if (!empty($artikelen)) {
    echo "<table>";
    echo "<tr>";
    echo "<th>Artikel ID</th>";
    echo "<th>Omschrijving</th>";
    echo "<th>Inkoopprijs</th>";
    echo "<th>Verkoopprijs</th>";
    echo "<th>Voorraad</th>";
    echo "<th>Minimale Voorraad</th>";
    echo "<th>Maximale Voorraad</th>";
    echo "<th>Locatie</th>";
    echo "</tr>";

    foreach ($artikelen as $artikel) {
        echo "<tr>";
        echo "<td>" . $artikel['artId'] . "</td>";
        echo "<td>" . $artikel['artOmschrijving'] . "</td>";
        echo "<td>" . $artikel['artInkoop'] . "</td>";
        echo "<td>" . $artikel['artVerkoop'] . "</td>";
        echo "<td>" . $artikel['artVoorraad'] . "</td>";
        echo "<td>" . $artikel['artMinVoorraad'] . "</td>";
        echo "<td>" . $artikel['artMaxVoorraad'] . "</td>";
        echo "<td>" . $artikel['artLocatie'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Geen artikelen gevonden.";
}

// Databaseverbinding sluiten
$database->closeConnection();

?>
