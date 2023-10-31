<?php

require_once 'config/database.php';
require_once 'partials/header.php';

// Récupérer les contacts dans la BDD
$contacts = $db->query('SELECT * FROM contacts')->fetchAll();
// var_dump($contacts);

// Recap tableau
['a', 'b', 'c']; // Tableau numérique
$a = [
    'Titi', // Index 0
    'A' => 'Fiorella',
    0 => 'Marina',
    'B' => 'Matthieu',
    'Toto',
]; // Tableau associatif
// var_dump($a);

// Tips pour le echo
// echo '<?= est la même chose que <?php echo';
?>

<h1 class="text-3xl font-bold mb-4 text-center">Liste des contacts</h1>
<a href="ajout.php" class="underline text-blue-500">Ajouter un contact</a>

<?php if (isset($_SESSION['success'])) { ?>
    <p class="bg-green-300 px-4 py-2 text-green-800 rounded-lg">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </p>
<?php } ?>

<ul>
    <?php foreach ($contacts as $contact) { ?>
        <li class="item blue exemple">
            <?= $contact['name']; ?>: <?= $contact['message']; ?>
            <a href="supprimer.php?id=<?= $contact['id']; ?>">❌</a>
        </li>
    <?php } ?>
</ul>

<?php require_once 'partials/footer.php'; ?>
