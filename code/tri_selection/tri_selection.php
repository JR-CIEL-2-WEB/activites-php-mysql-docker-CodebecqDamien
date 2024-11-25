<?php
    $tableau = array(1500, 4500, 2200, 1500, 3300, 1800, 1700, 2000, 4000);

    function read_tab($tableau){
        // Directly return the array as a string
        return implode(", ", $tableau);
    }

    function tri_selection($tableau){
        $n = count($tableau);
        for($i = 0; $i < $n - 1; $i++){
            $min = $i;
            for($j = $i + 1; $j < $n; $j++){
                if($tableau[$j] < $tableau[$min]){
                    $min = $j;
                }
            }
            if($min != $i){
                $temp = $tableau[$i];
                $tableau[$i] = $tableau[$min];
                $tableau[$min] = $temp;
            }
        }
        return $tableau; // Return the sorted array
    }

    function tri_selection_reference(&$tableau){
        $n = count($tableau);
        for($i = 0; $i < $n - 1; $i++){
            $min = $i;
            for($j = $i + 1; $j < $n; $j++){
                if($tableau[$j] < $tableau[$min]){
                    $min = $j;
                }
            }
            if($min != $i){
                $temp = $tableau[$i];
                $tableau[$i] = $tableau[$min];
                $tableau[$min] = $temp;
            }
        }
    }
?>