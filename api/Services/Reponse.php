<?php
class Reponse
{
   
    public static function sendResponse($status, $message) {
        header("HTTP/1.1 $status");
        $response = ['status' => $status,'message' => $message];
        header('Content-Type: application/json');
        echo json_encode($message);

        exit();
    }
}
?>