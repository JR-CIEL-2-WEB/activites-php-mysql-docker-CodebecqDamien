<?php
// Si le formulaire a été soumis (envoi de données par POST)
if (isset($_POST['t'])) {
    $tableau = $_POST['t']; // Le tableau envoyé par le frontend

    // Fonction pour trier le tableau (tri par sélection)
    function tri_selection($tableau) {
        $n = count($tableau);
        for ($i = 0; $i < $n - 1; $i++) {
            $min = $i;
            for ($j = $i + 1; $j < $n; $j++) {
                if ($tableau[$j] < $tableau[$min]) {
                    $min = $j;
                }
            }
            if ($min != $i) {
                $temp = $tableau[$i];
                $tableau[$i] = $tableau[$min];
                $tableau[$min] = $temp;
            }
        }
        return $tableau;
    }

    // Trier le tableau
    $tableau_trie = tri_selection($tableau);

    // Calcul de la médiane
    function mediane($arr) {
        $n = count($arr);
        $middle = floor($n / 2);
        if ($n % 2) {
            return $arr[$middle]; // Si impaire, retourner la valeur du milieu
        } else {
            return ($arr[$middle - 1] + $arr[$middle]) / 2; // Sinon, la moyenne des deux milieux
        }
    }

    $mediane = mediane($tableau_trie);

    // Créer le JSON à renvoyer
    $response = [
        'sorted' => $tableau_trie,
        'median' => $mediane
    ];

    // Renvoyer la réponse en format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcul de Médiane</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let tableau = [];

        // Fonction pour ajouter les valeurs au tableau
        function startAddingValues() {
            let valeur;
            do {
                // Demander une valeur à l'utilisateur via un alert
                valeur = parseInt(prompt("Entrez une valeur (un nombre négatif pour arrêter):"));

                // Ajouter la valeur au tableau si elle est positive
                if (valeur >= 0) {
                    tableau.push(valeur);
                    console.log(tableau); // Affiche le tableau dans la console pour le débogage
                }
            } while (valeur >= 0); // Continue tant que la valeur n'est pas négative

            // Une fois un nombre négatif entré, envoyer le tableau au serveur
            sendData();
        }

        // Fonction pour envoyer le tableau au serveur
        function sendData() {
            $.ajax({
                url: 'https://61f47b00-9496-420c-98a5-40c48a9c0bb5.mock.pstmn.io', // URL avec le bon endpoint
                method: 'POST',
                data: JSON.stringify({ t: tableau }), // Envoi du tableau sous forme JSON
                contentType: 'application/json', // Indique que les données sont envoyées en JSON
                dataType: 'json', // Le type de la réponse attendue est JSON
                success: function(response) {
                    console.log('Réponse du serveur:', response);
                    // Afficher le JSON reçu dans le DOM
                    document.getElementById('result').innerHTML = `JSON reçu : ${JSON.stringify(response)}`;
                    
                    // Vérifier si la médiane est présente dans la réponse
                    if (response.median !== undefined) {
                        document.getElementById('mediane').innerHTML = `Médiane : ${response.median}`;
                    } else {
                        console.error('La médiane n\'est pas présente dans la réponse.');
                    }
                },
                error: function(err) {
                    console.error('Erreur:', err);
                }
            });
        }
    </script>
</head>
<body>
    <h1>Calcul de Médiane</h1>
    <button onclick="startAddingValues()">Ajouter des valeurs</button>

    <div id="result"></div>
    <div id="mediane"></div>
</body>
</html>
