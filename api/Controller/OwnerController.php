<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/api/Services/OwnerValidator.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/Services/Reponse.php';

class OwnerController {
    private $conn;
    private $idOwner;

    public function __construct($conn,$idOwner=null) {
        $this->conn = $conn;
        $this->idOwner=$idOwner;
    }

    /**
     * Returns the list of owner in the database in JSON format.
     */
    public function getOwner() {
        try {
            $sql = $this->conn->prepare("SELECT * FROM owner");
            $sql->execute();
            $results = $sql->fetchAll(PDO::FETCH_ASSOC);

            Reponse::sendResponse(200, $results);

        } catch (PDOException $e) {
            Reponse::sendResponse(500,"Internal Server Error");
        }

    }

    /**
     * Allows you to create a new owner in the database
     */
    public function newOwner(){

        //Validate the received data
        $data = json_decode(file_get_contents("php://input"), true);
        $validator = new OwnerValidator($this->conn,$data);
        $validationResult = $validator->validate();

        if (!$validationResult['success']) {
            Reponse::sendResponse($validationResult['status'],$validationResult['message']);
        }

        // Prepare the SQL INSERT query
        $sql = $this->conn->prepare("INSERT INTO owner (name, lastname,phone) VALUES (:name, :lastname,:phone)");
     
        $sql->bindParam(':name', $data['name']);
        $sql->bindParam(':lastname', $data['lastname']);
        $sql->bindParam(':phone', $data['phone']);

        //Reponse
        if ($sql->execute()) {
            Reponse::sendResponse(200, "The owner has been successfully registered");
           
        } else {
            Reponse::sendResponse(500,"Internal Server Error");
        }

    }
  
    /**
     * Allows you to delete a owner in the database and its weather
     */
    public function deleteOwner() {
      
        //Validate the received data
        $validator = new OwnerValidator($this->conn,null,$this->idOwner);
        $validationResult = $validator->validate();

        if (!$validationResult['success']) {
            Reponse::sendResponse($validationResult['status'],$validationResult['message']);
        }

        $sqlAnimal= $this->conn->prepare("DELETE FROM animal WHERE owner_id = :ownerId");
        $sqlAnimal->bindParam(':ownerId', $this->idOwner, PDO::PARAM_INT);
        $sqlAnimal->execute();
        
        $sqlOwner = $this->conn->prepare("DELETE FROM owner WHERE owner_id = :ownerId");
        $sqlOwner->bindParam(':ownerId', $this->idOwner, PDO::PARAM_INT);
        $sqlOwner->execute();
        //Reponse
        Reponse::sendResponse(200, "Owner deleted successfully");
    }

}
