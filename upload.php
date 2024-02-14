<?php 
include_once 'Database.php';
require_once 'CSVImport.php';

$db = new Database;
$csvImport = new CSVImport($db);

if($_FILES['csvFile']['error'] == 0){
    $file = $_FILES['csvFile']['tmp_name'];

    if($csvImport->importCSV($file)){
        echo 'success';
    }else{
        echo 'error';
    }
}else{
    echo 'error';
}