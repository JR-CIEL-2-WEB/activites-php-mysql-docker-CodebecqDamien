<?php
// Connexion à la base de données
$host = 'mysql';
$dbname = 'appdb';
$username = 'user';
$password = 'password';

try {
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Fonction pour récupérer tous les employés
function getEmployees($pdo) {
    $query = "SELECT id, nom_complet, adresse, salaire FROM Employees";
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour calculer la médiane des salaires
function calculerMediane($pdo) {
    $query = "SELECT salaire FROM Employees ORDER BY salaire";
    $stmt = $pdo->query($query);
    $salaires = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $n = count($salaires);
    if ($n == 0) return 0;

    if ($n % 2 == 0) {
        return ($salaires[$n / 2 - 1] + $salaires[$n / 2]) / 2;
    } else {
        return $salaires[floor($n / 2)];
    }
}

// Gestion des requêtes HTTP
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $employees = getEmployees($pdo);
    $mediane = calculerMediane($pdo);
    echo json_encode(['employees' => $employees, 'mediane' => $mediane]);

} elseif ($method == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $query = "INSERT INTO Employees (nom_complet, adresse, salaire) VALUES (:nom_complet, :adresse, :salaire)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'nom_complet' => $data['nom_complet'],
        'adresse' => $data['adresse'],
        'salaire' => $data['salaire']
    ]);
    echo json_encode(['message' => 'Employé ajouté avec succès']);

} elseif ($method == 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $id = $data['id'] ?? null;

    if ($id) {
        $query = "DELETE FROM Employees WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        echo json_encode(['message' => 'Employé supprimé']);
    }

} elseif ($method == 'PUT') {
    // Gestion de la mise à jour d'un employé
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id'], $data['nom_complet'], $data['adresse'], $data['salaire'])) {
        $query = "UPDATE Employees SET nom_complet = :nom_complet, adresse = :adresse, salaire = :salaire WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'id' => $data['id'],
            'nom_complet' => $data['nom_complet'],
            'adresse' => $data['adresse'],
            'salaire' => $data['salaire']
        ]);
        echo json_encode(['message' => 'Employé mis à jour avec succès']);
    } else {
        echo json_encode(['message' => 'Erreur: Données manquantes pour la mise à jour']);
    }
}
?>
