<?php
class OwnerValidator {

    private $conn;
    private $resources;
    private $ownerId;


    public function __construct($conn,$resources,$ownerId=null) {
        $this->conn = $conn;
        $this->resources = $resources;
        $this->ownerId =$ownerId;

    }
    public function validate() {
        if($this->ownerId == null){ 
            if (empty($this->resources['name']) || empty($this->resources['lastname']) || empty($this->resources['phone'])) {
                return ['success' => false, 'status' => 400, 'message' => 'The name,lastname and phone, fields are required'];
            }
        }
        return ['success' => true];

    }
}
?>