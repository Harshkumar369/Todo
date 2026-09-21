<?php
include 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$user_id = intval($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $task = trim($_POST['task']);

    if (!empty($task)) {
        $stmt = $conn->prepare("UPDATE tasks SET task = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $task, $id, $user_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating task"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Task cannot be empty"]);
    }
}
$conn->close();
?>
