<?php
// Uključivanje konekcije sa bazom
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prikupljanje podataka iz forme
    $customer_name = trim($_POST['customer_name'] ?? '');
    $burger_id = intval($_POST['burger'] ?? 0);
    $delivery_method = $_POST['delivery'] ?? '';
    $quantity = intval($_POST['quantity'] ?? 0);
    $addons = $_POST['addons'] ?? [];
    $phone_number = trim($_POST['phone_number'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // Detaljna validacija
    if (empty($customer_name)) {
        die('Greška: Ime kupca je obavezno.');
    }
    if ($burger_id <= 0) {
        die('Greška: Morate izabrati validan burger.');
    }
    if (!in_array($delivery_method, ['pickup', 'delivery'])) {
        die('Greška: Morate izabrati validan metod dostave.');
    }
    if ($quantity <= 0) {
        die('Greška: Količina mora biti veća od 0.');
    }
    if ($delivery_method === 'delivery' && empty($address)) {
        die('Greška: Adresa je obavezna za dostavu.');
    }

    // Ubacivanje dodataka (default vrednost je FALSE)
    $cheese = in_array('cheese', $addons) ? 1 : 0;
    $bacon = in_array('bacon', $addons) ? 1 : 0;
    $pickles = in_array('pickles', $addons) ? 1 : 0;

    // Priprema SQL upita za unos podataka u tabelu
    $sql = "INSERT INTO orders (customer_name, burger_id, delivery_method, cheese, bacon,
        pickles, quantity, phone_number, address)
        VALUES (:customer_name, :burger_id, :delivery_method, :cheese, :bacon, :pickles,
        :quantity, :phone_number, :address)";
    $stmt = $pdo->prepare($sql);

    // Povezivanje vrednosti sa parametrima
    $stmt->bindParam(':customer_name', $customer_name);
    $stmt->bindParam(':burger_id', $burger_id);
    $stmt->bindParam(':delivery_method', $delivery_method);
    $stmt->bindParam(':cheese', $cheese, PDO::PARAM_BOOL);
    $stmt->bindParam(':bacon', $bacon, PDO::PARAM_BOOL);
    $stmt->bindParam(':pickles', $pickles, PDO::PARAM_BOOL);
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $stmt->bindParam(':phone_number', $phone_number);
    $stmt->bindParam(':address', $address);

    // Izvršavanje SQL upita
    try {
        $stmt->execute();
        echo "Porudžbina je uspešno zabeležena!";
    } catch (PDOException $e) {
        echo "Greška pri unosu podataka: " . $e->getMessage();
    }
} else {
    die('Greška: Forma nije poslata na validan način.');
}
?>
