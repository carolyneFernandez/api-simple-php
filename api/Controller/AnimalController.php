<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/api/Services/Reponse.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/Services/AnimalValidator.php';

class AnimalController {
    private $conn;
    private $ownerId;
    private $animalId;

    public function __construct($conn,$ownerId =null,$animalId=null) {
        $this->conn = $conn;
        $this->ownerId=$ownerId;
        $this->animalId=$animalId;
    }
    
    /**
     * Returns the list of animal in the database in JSON format.
     */
    public function getAnimal() {
        try {
            $query ="SELECT o.name as name_owner,a.animal_id,a.name,a.owner_id,a.type
                FROM `animal` as a 
                JOIN owner as o on o.owner_id = a.owner_id
                WHERE a.owner_id =:ownerId";

            $sql = $this->conn->prepare($query);
            $sql->bindParam(':ownerId', $this->ownerId, PDO::PARAM_INT);
            $sql->execute();
            $results = $sql->fetchAll(PDO::FETCH_ASSOC);

            Reponse::sendResponse(200, $results);
        } catch (PDOException $e) {
            Reponse::sendResponse(500,"Internal Server Error");
        }

    }

    /**
     * Allows you to create a new animal in the database
     */
    public function newAnimal(){
        $data = json_decode(file_get_contents("php://input"), true);
        //Validate the received data
        $validator = new AnimalValidator($this->conn,$this->ownerId);
        $validationResult = $validator->validate();

        if (!$validationResult['success']) {
            Reponse::sendResponse($validationResult['status'], $validationResult['message']);
        }
     
        // Prepare the SQL INSERT query
        $request = "INSERT INTO `animal` (`owner_id`, `name`, `type`) 
        VALUES ( :owner_id, :name, :type)";

        $sql = $this->conn->prepare($request);
        $sql->bindParam(':owner_id', $this->ownerId,PDO::PARAM_INT);
        $sql->bindParam(':name', $data['name'],PDO::PARAM_STR);
        $sql->bindParam(':type', $data['type'],PDO::PARAM_STR);

        if ($sql->execute()) {
            Reponse::sendResponse(201, "The animal has been successfully registered");
        } else {
            Reponse::sendResponse(500,"Internal Server Error");
        }
    
    }
    
    /**
     * Allows you to delete a animal in the database
     */
    public function deleteAnimal() {
        
        //Validate 
        $validator = new AnimalValidator($this->conn,$this->ownerId,$this->animalId);
        $validationResult = $validator->validate();

        if (!$validationResult['success']) {
            Reponse::sendResponse($validationResult['status'],$validationResult['message']);
        }

        //Delete
        $sqlDelete = $this->conn->prepare("DELETE FROM animal WHERE `animal`.`animal_id` = :animalId");
        $sqlDelete->bindParam(':animalId', $this->animalId, PDO::PARAM_INT);
        $sqlDelete->execute();

        Reponse::sendResponse(200, "success");

    }
}