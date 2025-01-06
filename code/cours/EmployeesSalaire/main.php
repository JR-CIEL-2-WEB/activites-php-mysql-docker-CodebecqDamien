<?php
// Connexion à la base de données
$host = 'localhost';  // Remplacez par l'adresse de votre serveur
$dbname = 'appdb';
$username = 'root';    // Remplacez par votre nom d'utilisateur
$password = '';        // Remplacez par votre mot de passe

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Fonction pour récupérer tous les salaires
function getSalaires($pdo) {
    $query = "SELECT salaire FROM Employees";
    $stmt = $pdo->query($query);
    $salaires = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $salaires[] = $row['salaire'];
    }
    return $salaires;
}

// Fonction pour trier les salaires par ordre croissant
function tri_selection($tab) {
    $n = count($tab);
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = $i + 1; $j < $n; $j++) {
            if ($tab[$i] > $tab[$j]) {
                // Échanger les éléments
                $temp = $tab[$i];
                $tab[$i] = $tab[$j];
                $tab[$j] = $temp;
            }
        }
    }
    return $tab;
}

// Fonction pour calculer la médiane
function medianne($tab) {
    $n = count($tab);
    if ($n % 2 == 0) {
        // Si le nombre d'éléments est pair, la médiane est la moyenne des deux éléments du milieu
        return ($tab[$n / 2 - 1] + $tab[$n / 2]) / 2;
    } else {
        // Si le nombre d'éléments est impair, la médiane est l'élément du milieu
        return $tab[floor($n / 2)];
    }
}

// Récupérer les salaires et les trier
$salaires = getSalaires($pdo);
$salairesTries = tri_selection($salaires);

// Calculer la médiane
$mediane = medianne($salairesTries);

// Retourner la médiane au format JSON pour l'afficher dans le DOM
echo json_encode(['mediane' => $mediane]);

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médiane des salaires</title>
</head>
<body>
    <div id="medianne"></div>

    <script>
        // Fonction pour appeler le serveur PHP et récupérer la médiane
        fetch('main.php')
            .then(response => response.json())
            .then(data => {
                // Afficher la médiane dans la div avec l'ID 'medianne'
                document.getElementById('medianne').innerText = "La médiane des salaires est : " + data.medianne;
            })
            .catch(error => console.error('Erreur:', error));
    </script>
</body>
</html>
