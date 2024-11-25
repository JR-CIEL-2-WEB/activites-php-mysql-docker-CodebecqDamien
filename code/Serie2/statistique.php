<?php
    include 'Exercice0.1.php';

    function calcul_medianne($note_global) {
        sort($note_global);
        $count = count($note_global);
        if ($count % 2 == 1) {
            return $note_global[($count - 1) / 2] ;
        } else {
            return ($note_global[$count / 2 - 1] + $note_global[$count / 2]) / 2 ;
        }
    }

    echo 'La médiane est de : ' . calcul_medianne($note_global) . ' / 20.';
?>
