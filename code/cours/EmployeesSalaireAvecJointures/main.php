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

// Récupérer tous les employés et leurs salaires
function getEmployees($pdo) {
    $query = "SELECT e.id, e.nom_complet, e.adresse, s.salaire 
              FROM Employes e 
              LEFT JOIN Salaires s ON e.id = s.employe_id";
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Calculer la médiane des salaires
function calculerMediane($pdo) {
    $query = "SELECT salaire FROM Salaires ORDER BY salaire";
    $stmt = $pdo->query($query);
    $salaires = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $n = count($salaires);
    if ($n == 0) return 0;

    return ($n % 2 == 0) ? ($salaires[$n / 2 - 1] + $salaires[$n / 2]) / 2 : $salaires[floor($n / 2)];
}

// Gestion des requêtes HTTP
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $employees = getEmployees($pdo);
    $mediane = calculerMediane($pdo);
    echo json_encode(['employees' => $employees, 'mediane' => $mediane]);
} 
elseif ($method == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['id'])) {
        // Mise à jour d'un employé
        $query = "UPDATE Employes e 
                  JOIN Salaires s ON e.id = s.employe_id 
                  SET e.nom_complet = :nom_complet, e.adresse = :adresse, s.salaire = :salaire 
                  WHERE e.id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'id' => $data['id'],
            'nom_complet' => $data['nom_complet'],
            'adresse' => $data['adresse'],
            'salaire' => $data['salaire']
        ]);
        echo json_encode(['message' => 'Employé mis à jour avec succès']);
    } else {
        // Ajout d'un employé
        $query1 = "INSERT INTO Employes (nom_complet, adresse) VALUES (:nom_complet, :adresse)";
        $stmt1 = $pdo->prepare($query1);
        $stmt1->execute([
            'nom_complet' => $data['nom_complet'],
            'adresse' => $data['adresse']
        ]);
        $employe_id = $pdo->lastInsertId();

        $query2 = "INSERT INTO Salaires (employe_id, salaire) VALUES (:employe_id, :salaire)";
        $stmt2 = $pdo->prepare($query2);
        $stmt2->execute([
            'employe_id' => $employe_id,
            'salaire' => $data['salaire']
        ]);

        echo json_encode(['message' => 'Employé ajouté avec succès']);
    }
} 
elseif ($method == 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $id = $data['id'] ?? null;

    if ($id) {
        $query = "DELETE FROM Employes WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        echo json_encode(['message' => 'Employé supprimé']);
    }
}
?>
