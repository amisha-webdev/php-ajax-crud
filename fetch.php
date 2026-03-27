<?php
include('db.php');

// Read parameters from DataTables(Receive Request from datatable)
$draw = isset($_POST['draw']) ? $_POST['draw'] : 1;
$start = isset($_POST['start']) ? $_POST['start'] : 0; // starting record
$length = isset($_POST['length']) ? $_POST['length'] : 10; // how many records to fetch
$orderColumnIndex = $_POST['order'][0]['column'] ?? 0;
$orderDir = $_POST['order'][0]['dir'] ?? 'asc';
$searchValue = $_POST['search']['value'] ?? '';

// Search filter
$searchQuery = "";
if ($searchValue != '') {
    $searchQuery = " AND (st.name LIKE '%$searchValue%' 
                        OR st.id LIKE '%$searchValue%'
                        OR st.email LIKE '%$searchValue%' 
                        OR st.phone_no LIKE '%$searchValue%' 
                        OR st.address LIKE '%$searchValue%')";
}

// Total number of records (without filter)
$totalQuery = "SELECT COUNT(*) AS total FROM student st 
               JOIN state s ON st.state_id = s.id 
               JOIN district d ON st.district_id = d.id";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRecords = mysqli_fetch_assoc($totalResult)['total'];

// Total number of records with filter
$filteredQuery = "SELECT COUNT(*) AS total FROM student st 
                  JOIN state s ON st.state_id = s.id 
                  JOIN district d ON st.district_id = d.id 
                  WHERE 1 $searchQuery";
$filteredResult = mysqli_query($conn, $filteredQuery);
$totalFiltered = mysqli_fetch_assoc($filteredResult)['total'];

// Fetch paginated data
$dataQuery = "SELECT st.id, st.name, st.email, st.phone_no, st.address, s.state_name, d.district_name 
              FROM student st
              JOIN state s ON st.state_id = s.id 
              JOIN district d ON st.district_id = d.id
              WHERE 1 $searchQuery
              LIMIT $start, $length";

$dataResult = mysqli_query($conn, $dataQuery);

$data = [];
while ($row = mysqli_fetch_assoc($dataResult)) {
    $data[] = $row;
}

// Final JSON response for DataTables
$response = [
    "draw" => intval($draw),
    "recordsTotal" => intval($totalRecords),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
];

echo json_encode($response);
