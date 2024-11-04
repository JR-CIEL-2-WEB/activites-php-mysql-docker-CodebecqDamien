<?php 
    $note_global = array(2,19,15,8,12,16,20,14,17,13);
    $moyenne = 0;

    function calcul_moyenne($note_global){
        $moyenne = 0;
        for($i = 0; $i < count($note_global); $i++){
            $moyenne += $note_global[$i];
        }
        $moyenne = $moyenne / count($note_global);
        return $moyenne;
    }

    echo 'La moyenne est de : '.calcul_moyenne($note_global) .' / 20.'.'<br>';
?>