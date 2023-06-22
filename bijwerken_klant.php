<?php
require_once 'customer.php';

// Controleren of een klant-ID is doorgegeven via de querystring
if (isset($_GET['klantid'])) {
    // Klant-ID uit de querystring ophalen
    $customerId = $_GET['klantid'];

    // Nieuwe instantie van de Customer klasse maken
    $customer = new Customer();

    // Klantgegevens ophalen op basis van klant-ID
    $customerData = $customer->getCustomerDetails($customerId);

    // Controleren of klantgegevens zijn opgehaald
    if ($customerData) {
        // Klantgegevens weergeven in een formulier
        echo "<h1>Klantgegevens bijwerken</h1>";
        echo "<form method='post' action='klantbijwerken.php?klantid=" . $customerId . "'>";
        echo "<input type='hidden' name='customer_id' value='" . $customerData['klantid'] . "'>";
        echo "Naam: <input type='text' name='customer_name' value='" . $customerData['klantnaam'] . "'><br>";
        echo "E-mail: <input type='text' name='customer_email' value='" . $customerData['klantemail'] . "'><br>";
        echo "<input type='submit' value='Bijwerken'>";
        echo "</form>";

        // Controleren of het bijwerken van de klant is ingediend
        if (isset($_POST['customer_name']) && isset($_POST['customer_email'])) {
            $customerName = $_POST['customer_name'];
            $customerEmail = $_POST['customer_email'];

            // Klantgegevens bijwerken in de database
            $customer->updateCustomer($customerId, $customerName, $customerEmail);

            echo "Klantgegevens zijn bijgewerkt.";
        }
    } else {
        echo "Geen klant gevonden met het opgegeven ID.";
    }
} else {
    echo "Geen klant-ID doorgegeven.";
}
?>
