<?php
namespace App;

class ContactManager {
    private $fileHandler;

    public function __construct(FileHandler $fileHandler) {
        $this->fileHandler = $fileHandler;
    }

    public function getAllContacts() {
        return $this->fileHandler->readContacts();
    }

    public function getContactById($id) {
        $contacts = $this->fileHandler->readContacts();
        foreach ($contacts as $contact) {
            if ($contact['id'] == $id) {
                return $contact;
            }
        }
        return null;
    }

    public function addContact($name, $email, $phone) {
        $contacts = $this->fileHandler->readContacts();
        $id = uniqid();
        $contacts[] = ['id' => $id, 'name' => $name, 'email' => $email, 'phone' => $phone];
        $this->fileHandler->writeContacts($contacts);
    }

    public function updateContact($id, $name, $email, $phone) {
        $contacts = $this->fileHandler->readContacts();
        foreach ($contacts as &$contact) {
            if ($contact['id'] == $id) {
                $contact['name'] = $name;
                $contact['email'] = $email;
                $contact['phone'] = $phone;
                break;
            }
        }
        $this->fileHandler->writeContacts($contacts);
    }

    public function deleteContact($id) {
        $contacts = $this->fileHandler->readContacts();
        foreach ($contacts as $key => $contact) {
            if ($contact['id'] == $id) {
                unset($contacts[$key]);
                break;
            }
        }
        $this->fileHandler->writeContacts(array_values($contacts));
    }
}
