<?php
// Paramètres de connexion à la base de données
$host = 'localhost'; // Adresse du serveur MySQL
$port = 3306; // Port de votre serveur MySQL
$dbname = 'appdb'; // Nom de la base de données
$user = 'user'; // Utilisateur MySQL (par défaut 'root')
$password = 'password'; // Mot de passe MySQL (laisser vide si pas de mot de passe)

// Connexion à la base de données
$conn = new mysqli('activites-php-mysql-docker-codebecqdamien-mysql-1', 'user', 'password', 'appdb', 3306);


// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifier si un paramètre 'id' est passé dans l'URL
if (isset($_GET['id'])) {
    $courseId = $_GET['id'];

    // Requête pour récupérer les données de la course par ID
    $query = "SELECT name, markers FROM courses WHERE id = ?";
    $stmt = $conn->prepare("SELECT name, markers FROM Courses WHERE id = ?");
    $stmt->bind_param("i", $courseId); // "i" pour un entier (id)
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si une course a été trouvée
    if ($result->num_rows > 0) {
        $courseData = $result->fetch_assoc();
        $courseName = $courseData['name'];
        $markers = json_decode($courseData['markers'], true); // Décoder les marqueurs JSON
        // Retourner les données sous forme de JSON
        echo json_encode([
            'name' => $courseName,
            'markers' => $markers
        ]);
    } else {
        echo json_encode(['error' => 'Course not found']);
    }

    // Fermer la requête
    $stmt->close();
} else {
    echo json_encode(['error' => 'No course ID provided']);
}

// Fermer la connexion à la base de données
$conn->close();
?>
