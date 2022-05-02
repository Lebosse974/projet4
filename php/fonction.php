<?php

function connect(){
    $mysqli = new mysqli("localhost", "root", "", "projet4");
    if ($mysqli->connect_errno) {
        echo "Problème de connexion à la base de données !";
        return false;
    }
    return $mysqli;
}









?>