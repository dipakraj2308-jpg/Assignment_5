<?php
require "db.php";

function addStudent($conn) {
    // the hidden element: only continue if it says "add"
    if ($_POST["action"] != "add") {
        echo "<div class='error'>Failed: invalid request</div>";
        return;
    }

    $name   = trim($_POST["name"]);
    $gender = $_POST["gender"];
    $dept   = $_POST["dept"];
    $marks  = $_POST["marks"];

    if ($name == "" || $marks == "" || $marks < 0 || $marks > 100) {
        echo "<div class='error'>Failed: enter a name and marks between 0 and 100</div>";
        return;
    }

    $stmt = $conn->prepare("INSERT INTO " . TABLE . " (name, gender, dept, marks) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $gender, $dept, $marks);

    if ($stmt->execute()) {
        echo "<div class='result'>Success: " . htmlspecialchars($name) . " was added</div>";
    } else {
        echo "<div class='error'>Failed: could not add the record</div>";
    }
}

addStudent($conn);
?>