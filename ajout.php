<?php

require_once 'config/database.php';
require_once 'partials/header.php';

// Traitement du formulaire
// 1 - Récupérer les données
$name = $_POST['name'] ?? null; // PHP 7
// $name = isset($_POST['name']) ? $_POST['name'] : null; // PHP 5
$message = $_POST['message'] ?? null;
$errors = [];

// 2 - Vérifier les données (si le formulaire a été envoyé)
if (! empty($_POST)) { // Formulaire NON vide
    if (strlen($name) <= 0) {
        $errors['name'] = 'Le nom est obligatoire.';
    }

    if (strlen($message) < 15) {
        $errors['message'] = 'Le message doit faire 15 caractères minimum.';
    }

    // Erreur si la BDD contient 5 messages ou plus.
    $messagesCount = $db->query('SELECT COUNT(id) FROM contacts')->fetchColumn();
    if ($messagesCount >= 5) {
        $errors['count'] = 'Désolé, il y a trop de messages.';
    }

    if (empty($errors)) { // Pas d'erreurs dans le formulaire
        // "Toto'); DROP DATABASE toto";
        // Attention aux Injections SQL... On doit toujours préparer les requêtes
        // $db->query("INSERT INTO contacts (name, message) VALUES ('$name', '$message')");
        $query = $db->prepare('INSERT INTO contacts (name, message) VALUES (:name, :message)');
        $query->execute([
            'name' => htmlspecialchars($name), // < === &lt; et permet d'éviter les failles XSS
            'message' => htmlspecialchars($message),
        ]);

        // Avant la redirection, on ajoute un message dans la session (qu'on affiche plus tard)
        $_SESSION['success'] = 'Votre message a été envoyé '.htmlspecialchars($name);

        // Redirection vers une page
        header('Location: index.php');
    }
}
?>

<h1 class="text-3xl font-bold mb-4 text-center">Ajouter un contact</h1>

<ul>
    <?php foreach ($errors as $error) { ?>
        <li class="text-red-500">
            <?= $error; ?>
        </li>
    <?php } ?>
</ul>

<form action="" method="post">
    <div class="mb-3">
        <label for="name" class="block">Nom</label>
        <input type="text" name="name" id="name" class="w-full" value="<?= $name; ?>">
    </div>

    <div class="mb-3">
        <label for="message" class="block">Message</label>
        <textarea name="message" id="message" class="w-full"><?= $message; ?></textarea>
    </div>

    <button class="bg-blue-500 text-gray-100 px-4 py-2 rounded-lg hover:bg-blue-600 duration-300">Envoyer</button>
</form>

<?php require_once 'partials/footer.php'; ?>
