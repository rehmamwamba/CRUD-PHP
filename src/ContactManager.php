<?php

namespace App;

class ContactManager
{
    private $fileHandler;

    public function __construct(FileHandler $fileHandler)
    {
        $this->fileHandler = $fileHandler;
    }

    public function getAllContacts()
    {
        return $this->fileHandler->read();
    }

    public function getContactById($id)
    {
        $contacts = $this->fileHandler->read();
        
        foreach ($contacts as $contact) {
            if ($contact['id'] === $id) {
                return $contact;
            }
        }

        return null; 
    }

    public function addContact($name, $email, $phone)
    {
        $contacts = $this->fileHandler->read();
        $newContact = [
            // Générer un ID unique (vous pouvez ajuster selon votre logique)
            'id' => uniqid(), 
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];
        $contacts[] = $newContact;
        $this->fileHandler->write($contacts);
    }

    public function updateContact($id, $name, $email, $phone)
    {
        $contacts = $this->fileHandler->read();
        
        foreach ($contacts as &$contact) {
            if ($contact['id'] === $id) {
                $contact['name'] = $name;
                $contact['email'] = $email;
                $contact['phone'] = $phone;
                break;
            }
        }

        $this->fileHandler->write($contacts);
    }

    public function deleteContact($id)
    {
        $contacts = $this->fileHandler->read();
        
        foreach ($contacts as $key => $contact) {
            if ($contact['id'] === $id) {
                unset($contacts[$key]); // Supprimer le contact du tableau
                break;
            }
        }

        $this->fileHandler->write($contacts);
    }
}
?>
