<?php
require "db.php";

function deleteStudent($conn) {
    $id = $_GET["id"];

    $stmt = $conn->prepare("DELETE FROM " . TABLE . " WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<div class='result'>Record deleted</div>";
    } else {
        echo "<div class='error'>Delete failed</div>";
    }
}

deleteStudent($conn);
?>