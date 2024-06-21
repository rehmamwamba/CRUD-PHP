<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\ContactManager;
use App\Form;
use App\Request;
use App\Session;

Session::start();

// Instanciation du gestionnaire de contacts
$fileHandler = new \App\FileHandler(__DIR__ . '/data/contacts.json');
$contactManager = new ContactManager($fileHandler);

$error = '';

// Récupération de l'ID du contact à modifier depuis l'URL
$contactId = Request::get('id');
$contact = $contactManager->getContactById($contactId);

// Vérification si le contact existe
if (!$contact) {
    // Redirection vers la page d'index si le contact n'existe pas
    Session::setFlash('error', 'Contact non trouvé.');
    header('Location: index.php');
    exit;
}

// Traitement du formulaire de mise à jour du contact
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = Request::post('name');
    $email = Request::post('email');
    $phone = Request::post('phone');
    
    // Validation des données ( non vide, format email valide.)
    
    if (!empty($name) && !empty($email) && !empty($phone)) {
        $contactManager->updateContact($contactId, $name, $email, $phone);
        Session::setFlash('success', 'Le contact a été mis à jour avec succès.');
        header('Location: index.php');
        exit;
    } else {
        $error = 'Veuillez remplir tous les champs.';
    }
}

// Affichage du formulaire pré-rempli avec les données du contact
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Modifier un Contact</h1>

        <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $contact['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $contact['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $contact['phone']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="index.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
