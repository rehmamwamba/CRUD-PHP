<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\ContactManager;
use App\Session;
use App\Request;

Session::start();

// Instanciation du gestionnaire de contacts
$fileHandler = new \App\FileHandler(__DIR__ . '/data/contacts.json');
$contactManager = new ContactManager($fileHandler);

// Récupération de l'ID du contact à supprimer depuis l'URL
$contactId = Request::get('id');

// Vérification si l'ID du contact est présent
if (!$contactId) {
    Session::setFlash('error', 'ID de contact non spécifié.');
    header('Location: index.php');
    exit;
}

// Suppression du contact
$contactManager->deleteContact($contactId);
Session::setFlash('success', 'Le contact a été supprimé avec succès.');

// Redirection vers la page d'index
header('Location: index.php');
exit;
?>
