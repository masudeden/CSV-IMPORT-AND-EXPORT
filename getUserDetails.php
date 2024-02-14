<?php
if($_SERVER['REQUEST_METHOD']==='POST'){
    require_once 'Database.php';
    $db = new Database;
    $conn = $db->getConnection();
    try{
        $userId = $_POST['userId'];

        $stmt = $conn->prepare("SELECT id, name, email, phone FROM users WHERE id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($userDetails);
    }catch(PDOException $e){
        echo 'error';
    }

}else{
    echo 'error';
}