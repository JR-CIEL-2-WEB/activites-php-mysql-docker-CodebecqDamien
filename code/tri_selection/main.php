<?php
    include 'tri_selection.php';
    
    echo 'Tableau initial: ' . implode(", ", $tableau) . '<br>'; 
    
    $sortedArray = tri_selection($tableau);
    echo 'Tri par sélection: ' . implode(", ", $sortedArray) . '<br>';

    tri_selection_reference($tableau);
    echo 'Tri par sélection par référence: ' . implode(", ", $tableau) . '<br>';
?>
