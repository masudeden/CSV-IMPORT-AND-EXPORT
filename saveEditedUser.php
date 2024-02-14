<?php
if($_SERVER['REQUEST_METHOD']==='POST'){
    require_once 'Database.php';
    $db = new Database;
    $conn = $db->getConnection();
    try{
        $userId = $_POST['userId'];
        $name = $_POST['editUserName'];
        $email = $_POST['editUserEmail'];
        $phone = $_POST['editUserPhone'];

        $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email, phone = :phone WHERE id = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->execute();

        echo 'success';
    }catch(PDOException $e){
        echo 'error';
    }

}else{
    echo 'error';
}