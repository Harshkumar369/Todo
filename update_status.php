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

    // Get current status, only if this task belongs to the logged-in user
    $stmt = $conn->prepare("SELECT status FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row) {
        $newStatus = ($row['status'] == 'pending') ? 'completed' : 'pending';

        $update = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?");
        $update->bind_param("sii", $newStatus, $id, $user_id);

        if ($update->execute()) {
            echo json_encode(["success" => true, "status" => $newStatus]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating task"]);
        }
        $update->close();
    } else {
        echo json_encode(["success" => false, "message" => "Task not found"]);
    }
}
$conn->close();
?>
