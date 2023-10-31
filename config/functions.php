<?php

/**
 * Permet de récupérer un contact dans la BDD.
 */
function getContact(int $id) {
    global $db; // Pour utiliser une variable qui est
    // déclarée hors de la fonction

    $query = $db->prepare('SELECT * FROM contacts WHERE id = :modif');
    $query->execute(['modif' => $id]);

    return $query->fetch();
}

function addition($a, $b) {
    return $a + $b;
}

// echo addition(1, 2) + addition(3, 4);
