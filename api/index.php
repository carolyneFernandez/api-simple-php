<?php
header("Content-Type:application/json");
require_once './Services/Database.php';
require_once './Controller/OwnerController.php';
require_once './Controller/AnimalController.php';
require_once './Services/Reponse.php';

// Connexion à la base de données
$database = new Database();
$conn = $database->getConnection();

// Récupération de la méthode HTTP (GET, POST, etc.)
$method = $_SERVER['REQUEST_METHOD'];

// Récupération de l'URI
$request = rtrim(str_replace('/api/index.php/', '', $_SERVER['REQUEST_URI']), '/');
$resource = explode('/', $request);

switch ($method) {
    case 'GET':
        if ($resource[0] == 'owner' && count($resource)==1) {  
            $controller = new OwnerController($conn);
            $controller->getOwner();

        }elseif($resource[0] == 'owner' && $resource[2] == 'animal' && count($resource)==3){
            $controller = new AnimalController($conn,$resource[1]);
            $controller->getAnimal();

        }else {
            Reponse::sendResponse(500,"Internal Server Error");
        }
        break;

    case 'POST':
        if  ($resource[0] == 'owner' && count($resource)== 1) {
            $controller = new OwnerController($conn);
            $controller->newOwner();

        }elseif ($resource[0] == "owner" && $resource[2]=="animal" && count($resource)==3) {
            $controller = new AnimalController($conn,$resource[1]);
            $controller->newAnimal();

        }else {
            Reponse::sendResponse(500,"Internal Server Error");
        }

        break;

    case 'DELETE':
    
        if  ($resource[0] == 'owner' && count($resource)==2){ 
            $controller = new OwnerController($conn,$resource[1]);
            $controller->deleteOwner();

        }elseif ($resource[0] == "owner" && $resource[2]=="animal" && count($resource)==4) {
            $controller = new AnimalController($conn,$resource[1],$resource[3]);
            $controller->deleteAnimal();

        }else {
            Reponse::sendResponse(500,"Internal Server Error");
        }

        break;
    default:
        Reponse::sendResponse(405,"Method Not Allowed");

}
