<?php
require 'config/database.php';
session_start();

// Récupérer l'id qu'on doit supprimer
$id = $_GET['id'] ?? null;
$id = (int) $id; // On force l'id à être un entier (caster)

// Faire la requête
$query = $db->prepare('DELETE FROM contacts WHERE id = :id');
$query->execute(['id' => $id]);

$_SESSION['success'] = "Le contact $id a été supprimé.";
header('Location: index.php');
