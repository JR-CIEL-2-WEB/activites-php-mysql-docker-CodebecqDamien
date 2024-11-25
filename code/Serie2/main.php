<?php
    include 'statistique.php';

    $Nicolas_salaire = 2200;
    echo "La moyenne des salaire est de : ".calcul_moyenne($note_global). "€". "<br>";
    echo "Le salaire median est de : ".calcul_medianne($note_global). "€". "<br>";
    if ($Nicolas_salaire > calcul_medianne($note_global)){
        echo "Nicolas est dans les 50% des salaires les plus élevés";
    } else {
        echo "Nicolas est dans les 50% des salaires les moins élevés";
    }
?>