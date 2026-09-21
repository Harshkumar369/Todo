<?php
include 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$user_id = intval($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = trim($_POST['task']);

    if (!empty($task)) {
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, task) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $task);

        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "id" => $stmt->insert_id,
                "task" => $task
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Error adding task"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Task cannot be empty"]);
    }
}
$conn->close();
?>
