<?php
// getData.php

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    require_once 'Database.php';

    $db = new Database();
    $conn = $db->getConnection();

    try {
        // Pagination parameters
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $rowsPerPage = isset($_GET['rowsPerPage']) ? intval($_GET['rowsPerPage']) : 5;
        $start = isset($_GET['start']) ? intval($_GET['start']) : 0;
        $length = isset($_GET['length']) ? intval($_GET['length']) : 10;
        $draw = isset($_GET['draw']) ? intval($_GET['draw']) : 1;
        $order = $_GET['order'][0];
        $dir = $order['dir'];
        $column = $_GET['order'][0]['column'];
        $orderColumn = $_GET['columns'][$column]['data'];

        // Calculate offset for pagination
        $offset = ($page - 1) * $rowsPerPage;

        // Retrieve total number of records
        $totalRecordsQuery = $conn->query("SELECT COUNT(*) as total FROM users");
        $totalRecords = $totalRecordsQuery->fetchColumn();

        // Retrieve filtered number of records (if filtering is applied)
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $searchTerm = '%' . $search . '%';

        $stmt = $conn->prepare("SELECT id, name, email, phone FROM users 
            WHERE LOWER(name) LIKE LOWER(:search) OR LOWER(email) LIKE LOWER(:search) OR LOWER(phone) LIKE LOWER(:search) 
            ORDER BY $orderColumn $dir LIMIT :offset, :rowsPerPage");

        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':rowsPerPage', $rowsPerPage, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retrieve filtered number of records after applying search
        $totalFilteredRecordsQuery = $conn->prepare("SELECT COUNT(*) as total FROM users 
            WHERE name LIKE :search OR email LIKE :search OR phone LIKE :search");
        $totalFilteredRecordsQuery->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $totalFilteredRecordsQuery->execute();
        $totalFilteredRecords = $totalFilteredRecordsQuery->fetchColumn();

        // Prepare response for DataTables
        $response = [
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalFilteredRecords,
            "data" => $data,
        ];

        // Return the response as JSON
        echo json_encode($response);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
