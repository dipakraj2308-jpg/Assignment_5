<?php
require "db.php";

function updateStudent($conn) {
    $id    = $_GET["id"];
    $name  = trim($_GET["name"]);
    $marks = $_GET["marks"];

    if ($name == "" || !is_numeric($marks) || $marks < 0 || $marks > 100) {
        echo "<div class='error'>Update failed: invalid name or marks</div>";
        return;
    }

    $stmt = $conn->prepare("UPDATE " . TABLE . " SET name = ?, marks = ? WHERE id = ?");
    $stmt->bind_param("sii", $name, $marks, $id);

    if ($stmt->execute()) {
        echo "<div class='result'>Record updated</div>";
    } else {
        echo "<div class='error'>Update failed</div>";
    }
}

updateStudent($conn);
?>