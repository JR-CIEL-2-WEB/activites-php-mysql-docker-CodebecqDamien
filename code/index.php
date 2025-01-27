<?php

echo "<p>Bonjour !</p>";

$servername = "mysql";
$username = "user";
$password = "password";
$dbname = "appdb";

try {

    $connexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    $sql = "CREATE TABLE IF NOT EXISTS example_table (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        fistname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL
    )";

    $connexion->exec($sql);

    $sql = "INSERT INTO example_table(fistname, lastname)
            VALUE ('John', 'DAC')";

    $connexion->exec($sql);


} catch (PDOException $e) {

    echo "Error: " . $e->getMessage();

}