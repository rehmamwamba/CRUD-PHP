<?php
// Chargement de l'autoloader de Composer
require_once __DIR__ . '/vendor/autoload.php';

use App\ContactManager;
use App\Form;
use App\Request;
use App\Session;

// Démarrage de la session
Session::start();

// Instanciation du gestionnaire de contacts
$fileHandler = new \App\FileHandler(__DIR__ . '/data/contacts.json');
$contactManager = new ContactManager($fileHandler);

// Variables pour messages de succès ou d'erreur
$message = '';
$error = '';

// Traitement des actions (ajouter, modifier, supprimer)
if (Request::post('action') === 'add') {
    $name = Request::post('name');
    $email = Request::post('email');
    $phone = Request::post('phone');
    $contactManager->addContact($name, $email, $phone);
    $message = 'Le contact a été ajouté avec succès.';
} elseif (Request::post('action') === 'update') {
    $id = Request::post('id');
    $name = Request::post('name');
    $email = Request::post('email');
    $phone = Request::post('phone');
    $contactManager->updateContact($id, $name, $email, $phone);
    $message = 'Le contact a été mis à jour avec succès.';
} elseif (Request::get('action') === 'delete') {
    $id = Request::get('id');
    $contactManager->deleteContact($id);
    $message = 'Le contact a été supprimé avec succès.';
}

// Récupération de la liste des contacts
$contacts = $contactManager->getAllContacts();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My CRUD App contact </title>
    <!-- Inclure Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>My CRUD App contact </h1>

        <?php if (!empty($message)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?php echo $contact['id']; ?></td>
                    <td><?php echo $contact['name']; ?></td>
                    <td><?php echo $contact['email']; ?></td>
                    <td><?php echo $contact['phone']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $contact['id']; ?>" class="btn btn-primary btn-sm">Modifier</a>
                        <a href="delete.php?id=<?php echo $contact['id']; ?>" class="btn btn-danger btn-sm">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="add.php" class="btn btn-success">Ajouter un Contact</a>
    </div>

    <!-- Inclure Bootstrap JS et les dépendances requises (Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
