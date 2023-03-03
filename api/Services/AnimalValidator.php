<?php
class AnimalValidator {

    private $conn;
    private $ownerId;
    private $animalId;

    private $animal = array('DOG','CAT','RABBIT','HAMSTER','BUDGIE');
    public function __construct($conn,$ownerId,$animalId = null) {
        $this->conn = $conn;
        $this->ownerId = $ownerId;
        $this->animalId = $animalId;

    }

    public function validate() {

        if($this->animalId != null){ 
            if (!is_numeric($this->animalId) || !is_numeric($this->ownerId)) {
                return ['success' => false, 'status' => 400, 'message' => 'Invalid owner ID or Invalid animal ID'];
            }

             // Check if the animal exists in the database
            $query ="SELECT animal_id
            FROM `animal`  
            WHERE animal_id =:animal_id;";

            $sqlAnimal = $this->conn->prepare($query);
            $sqlAnimal->bindParam(':animal_id', $this->animalId, PDO::PARAM_INT);
            $sqlAnimal->execute();

            if ($sqlAnimal->rowCount() == 0) 
            return ['success' => false, 'status' => 404, 'message' => 'Animal not found'];
        }else{  //new 

            $data = json_decode(file_get_contents("php://input"), true);

            if (empty($data['name']) || empty($data['type'])) 
            {
                return ['success' => false, 'status' => 400, 'message' => 'The Animal field is not indicated'];
            }
          
            if (!in_array(strtoupper($data['type']), $this->animal)) {
                return ['success' => false, 'status' => 400, 'message' => 'Invalid animal'];
            }
            
        }
 
        
        // Check if the owner exists in the database
        $sql = $this->conn->prepare("SELECT owner_id FROM owner WHERE owner_id = :ownerId");
        $sql->bindParam(':ownerId', $this->ownerId, PDO::PARAM_INT);
        $sql->execute();

        if ($sql->rowCount() == 0) 
            return ['success' => false, 'status' => 404, 'message' => 'City not found'];

        return ['success' => true];
    }

}
?>