<?php
require "db.php";

function showTable($conn, $search, $sort, $order) {
    $columns = array("id" => "ID", "name" => "Name", "gender" => "Gender",
                     "dept" => "Department", "marks" => "Marks");

    // safety: only allow real column names and ASC/DESC
    if (!array_key_exists($sort, $columns)) { $sort = "id"; }
    if ($order != "DESC") { $order = "ASC"; }

    // Q5: search text with % on both sides = "contains"
    $like = "%" . $search . "%";
    $sql = "SELECT * FROM " . TABLE .
           " WHERE name LIKE ? OR gender LIKE ? OR dept LIKE ? OR marks LIKE ? OR id LIKE ?" .
           " ORDER BY $sort $order";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $like, $like, $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<div class='error'>No records found</div>";
        return;
    }

    // Q8: clickable headers
    echo "<table><tr>";
    foreach ($columns as $col => $label) {
        $arrow = "";
        if ($col == $sort) {
            $arrow = ($order == "ASC") ? " &#9650;" : " &#9660;";
        }
        echo "<th onclick=\"sortBy('$col')\">$label$arrow</th>";
    }
    echo "<th>Action</th></tr>";

    // Q3: one table row per record
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["gender"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["dept"]) . "</td>";
        echo "<td>" . $row["marks"] . "</td>";
        echo "<td>";
        echo "<button onclick=\"editStudent(this, " . $row["id"] . ")\">Edit</button>";
        echo "<button class='del' onclick=\"deleteStudent(" . $row["id"] . ")\">Delete</button>";
        echo "</td></tr>";
    }
    echo "</table>";
}

showTable($conn, $_GET["search"] ?? "", $_GET["sort"] ?? "id", $_GET["order"] ?? "ASC");
?>