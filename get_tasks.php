<?php
include 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$user_id = intval($_SESSION['user_id']);
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'today';

switch ($filter) {
    case 'week':
        $where = "YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
        break;
    case 'month':
        $where = "MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
        break;
    case 'year':
        $where = "YEAR(created_at) = YEAR(CURDATE())";
        break;
    case 'today':
    default:
        $where = "DATE(created_at) = CURDATE()";
        break;
}

$sql = "SELECT * FROM tasks WHERE user_id = ? AND $where ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
$completed = 0;

while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
    if ($row['status'] == 'completed') {
        $completed++;
    }
}

echo json_encode([
    "success" => true,
    "tasks" => $tasks,
    "total" => count($tasks),
    "completed" => $completed
]);

$stmt->close();
$conn->close();
?>
