<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\ContactManager;
use App\Form;
use App\Request;
use App\Session;

Session::start();

$fileHandler = new \App\FileHandler(__DIR__ . '/data/contacts.json');
$contactManager = new ContactManager($fileHandler);

$message = '';
$error = '';

// Traitement du formulaire d'ajout de contact
if (Request::post('action') === 'add') {
    $name = Request::post('name');
    $email = Request::post('email');
    $phone = Request::post('phone');
    $contactManager->addContact($name, $email, $phone);
    $message = 'Le contact a été ajouté avec succès.';
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Contact</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Ajouter un Contact</h1>

        <?php if (!empty($message)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <form action="add.php" method="post">
            <input type="hidden" name="action" value="add">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
            <a href="index.php" class="btn btn-secondary">Retour</a>
        </form>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
