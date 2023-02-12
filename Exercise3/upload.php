<?php

// verification de la methode utilisée
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // processus de charger un fichier
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {

        // specification de l'extension
        $extension= ["pdf" => "application/pdf"];

        // reccuperer les informations du fichier
        $filename = $_FILES['file']['name'];
        $filesize = $_FILES['file']['size'];
        $filetype = $_FILES['file']['type'];

        // reccuperer l'extention du fichier
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        // verification de l'extension
        if (!array_key_exists($ext, $extension)) die("Error: le format du fichier est incorrect");

        //verification de la taille du fichier
        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) die("Error: le fichier est trop grand!");

        if (in_array($filetype, $extension)) {
            if (file_exists("uploads/" . $filename)) {
                die("desole le fichier existe deja");
            } else {
                move_uploaded_file($_FILES['file']['tmp_name'], "uploads/" . $filename);
                echo "Fichier chargé avec succes <br>";
            }
        } else {
            echo "Désolé nous ne pouvons pas charger le fichier!";
        }
    } else {
        echo "Erreur: " . $_FILES['file']['error'];
    }
    
    // information apres chargement du fichier avec succes
    if ($_FILES['file']['error'] == 0) {
        echo "Filename: " . $_FILES['file']['name'] . "<br>";
        echo "Filetype :" . $_FILES['file']['type'] . "<br>";
        echo "Filesize: " . ($_FILES['file']['size'] / 1024) . "KB <br>";
    }
}