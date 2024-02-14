<?php 
require_once 'Database.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $name = filter_input(INPUT_POST, 'insertUserName', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'insertUserEmail', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'insertUserPhone', FILTER_SANITIZE_SPECIAL_CHARS);

    try{
        $database = new Database;
        $conn=$database->getConnection();
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone) VALUES(:name, :email, :phone)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();
        echo 'success';
    }catch(PDOException $e){
        echo 'error: '. $e->getMessage();
    }
}