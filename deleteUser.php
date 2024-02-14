<?php
if($_SERVER['REQUEST_METHOD']==='POST'){
    require_once 'Database.php';
    $db = new Database;
    $conn = $db->getConnection();
    try{
        $userId = $_POST['userId'];

        $stmt = $conn->prepare("DELETE FROM users WHERE id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        echo 'success';
    }catch(PDOException $e){
        echo 'error';
    }

}else{
    echo 'error';
}