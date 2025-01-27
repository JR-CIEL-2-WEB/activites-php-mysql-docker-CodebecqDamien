<?php
header('Content-Type: application/json');

// Vérifier si l'ID a été fourni
if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID non fourni']);
    exit;
}

$id = $_GET['id'];

// Charger le fichier JSON
$jsonFile = 'courses.json';
if (!file_exists($jsonFile)) {
    echo json_encode(['error' => 'Fichier JSON introuvable']);
    exit;
}

$jsonData = file_get_contents($jsonFile);
$courses = json_decode($jsonData, true);

// Vérifier si le fichier JSON est valide
if ($courses === null) {
    echo json_encode(['error' => 'Erreur lors de la lecture du fichier JSON']);
    exit;
}

// Rechercher la course correspondant à l'ID
$selectedCourse = null;
foreach ($courses as $course) {
    if ($course['id'] === $id) {
        $selectedCourse = $course;
        break;
    }
}

// Vérifier si la course a été trouvée
if ($selectedCourse === null) {
    echo json_encode(['error' => 'Course non trouvée']);
    exit;
}

// Renvoyer les données de la course
echo json_encode($selectedCourse['markers']);
exit;

?>