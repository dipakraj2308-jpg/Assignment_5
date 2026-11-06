<?php
require "db.php";

function findGrade($marks) {
    if ($marks >= 80) return "A";
    if ($marks >= 60) return "B";
    return "C";
}

function showReport($conn) {
    $result = $conn->query("SELECT name, marks FROM " . TABLE);

    $names = array();
    $marksList = array();
    while ($row = $result->fetch_assoc()) {
        $names[] = $row["name"];
        $marksList[] = $row["marks"];
    }

    if (count($marksList) == 0) {
        echo "<div class='error'>No records to report</div>";
        return;
    }

    $total = array_sum($marksList);
    $average = $total / count($marksList);

    echo "<table><tr><th>Name</th><th>Marks</th><th>Grade</th></tr>";
    for ($i = 0; $i < count($marksList); $i++) {
        echo "<tr><td>" . htmlspecialchars($names[$i]) . "</td>";
        echo "<td>" . $marksList[$i] . "</td>";
        echo "<td>" . findGrade($marksList[$i]) . "</td></tr>";
    }
    echo "<tr><th>Total</th><th colspan='2'>$total</th></tr>";
    echo "<tr><th>Average</th><th colspan='2'>" . round($average, 2) . "</th></tr>";
    echo "</table>";
}

showReport($conn);
?>