<?php

namespace App;

class FileHandler
{
    private $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        
        // Vérifier et créer le répertoire si nécessaire
        $directory = dirname($filePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true); 
        }
    }

    public function read()
    {
        if (file_exists($this->filePath)) {
            $contents = file_get_contents($this->filePath);
            return json_decode($contents, true);
        }
        return [];
    }

    public function write($data)
    {
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($this->filePath, $jsonData);
    }
}
?>
