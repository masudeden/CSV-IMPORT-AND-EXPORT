<?php 
class CSVImport{
    private $db;
    public function __construct($db){
        $this->db =  $db;
    }

    public function importCSV($file){
        $conn= $this->db->getConnection();
        try{
            $conn->beginTransaction();
            $handle = fopen($file, "r");

            if($handle !==false){
                fgetcsv($handle, 1000, ",");

                while(($data = fgetcsv($handle, 1000, ",")) !== false){
                    $stmt = $conn->prepare("INSERT INTO users (name, email, phone) VALUES (:name, :email, :phone)");
                    $stmt->bindParam(':name', $data[0]);
                    $stmt->bindParam(':email', $data[1]);
                    $stmt->bindParam(':phone', $data[2]);

                    $stmt->execute();
                }
                fclose($handle);
            }
            $conn->commit();
            return true;
        }catch(PDOException $e){
            $conn->rollBack();
            error_log("CSV Import Error: ". $e->getMessage());
            return false;
        }
    }
}