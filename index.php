<?php
include 'config.php';

// Not logged in? Send to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userName = $_SESSION['user_name'];
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My To-Do Diary</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="desk">

    <!-- Decorative sticky notes -->
    <div class="sticky-note note-yellow">Don't forget<br>to smile 🙂</div>
    <div class="sticky-note note-pink">Call mom<br>tonight!</div>
    <div class="sticky-note note-blue">Stay<br>focused ✎</div>

    <!-- Paperclip on the notebook -->
    <svg class="paperclip" viewBox="0 0 40 90" xmlns="http://www.w3.org/2000/svg">
        <path d="M20 5 C31 5 36 13 36 24 L36 65 C36 76 28 83 18 83 C8 83 2 76 2 66 L2 22 C2 15 7 10 13 10 C19 10 23 15 23 21 L23 62 C23 66 20 68 17 68 C14 68 12 66 12 63 L12 26"
              fill="none" stroke="#8a94a6" stroke-width="4.5" stroke-linecap="round"/>
    </svg>

    <!-- Pen lying near the notebook -->
    <svg class="pen" viewBox="0 0 220 26" xmlns="http://www.w3.org/2000/svg">
        <rect x="0" y="8" width="170" height="10" rx="5" fill="#2b3a55"/>
        <rect x="0" y="8" width="170" height="4" rx="2" fill="#3f5279"/>
        <polygon points="170,8 200,13 170,18" fill="#c9d6e8"/>
        <polygon points="200,13 214,13 207,13" fill="#2b3a55"/>
        <rect x="18" y="8" width="14" height="10" fill="#e2a0a0"/>
    </svg>

    <div class="app">

        <!-- LEFT SIDEBAR -->
        <aside class="sidebar">
            <h2 class="brand">📔 My Diary</h2>

            <nav class="filter-tabs">
                <button class="tab active" data-filter="today">Today</button>
                <button class="tab" data-filter="week">This Week</button>
                <button class="tab" data-filter="month">This Month</button>
                <button class="tab" data-filter="year">This Year</button>
            </nav>

            <div class="summary">
                <p class="user-info">👤 <?php echo htmlspecialchars($userName); ?></p>
                <p id="summaryText" class="summary-text">0 / 0 done</p>
                <div id="checkGrid" class="check-grid"></div>
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
        </aside>

        <!-- RIGHT MAIN PAGE -->
        <main class="page">
            <div class="page-top">
                <h1 id="pageTitle">Today</h1>
                <form id="taskForm" class="task-form">
                    <input type="text" id="taskInput" placeholder="write a new task..." required>
                    <button type="submit">＋</button>
                </form>
            </div>

            <ul id="taskList" class="task-list"></ul>
        </main>

    </div>
</div>

<script src="script.js"></script>
</body>
</html>
