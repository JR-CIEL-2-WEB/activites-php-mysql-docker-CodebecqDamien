<?php
    $note_global = array(1500, 4500, 2200, 1500, 3300, 1800, 1700, 2000, 4000);

    function calcul_moyenne($note_global){
        $moyenne = 0;
        for($i = 0; $i < count($note_global); $i++){
            $moyenne += $note_global[$i];
        }
        $moyenne = $moyenne / count($note_global);
        return $moyenne;
    }

    function calcul_medianne($note_global) {
        sort($note_global);
        $count = count($note_global);
        if ($count % 2 == 1) {
            return $note_global[($count - 1) / 2] ;
        } else {
            return ($note_global[$count / 2 - 1] + $note_global[$count / 2]) / 2 ;
        }
    }

?>
