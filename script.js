// ---------- Helpers (same as Assignment 4, plus afterDone) ----------
function sendGet(url, outputId, afterDone) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        document.getElementById(outputId).innerHTML = xhr.responseText;
        if (afterDone) { afterDone(); }
      } else {
        document.getElementById(outputId).innerHTML =
          "<div class='error'>Something went wrong (status " + xhr.status + ")</div>";
      }
    }
  };
  xhr.open("GET", url, true);
  xhr.send();
}

function sendPost(url, formId, outputId, afterDone) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        document.getElementById(outputId).innerHTML = xhr.responseText;
        if (afterDone) { afterDone(); }
      } else {
        document.getElementById(outputId).innerHTML =
          "<div class='error'>Something went wrong (status " + xhr.status + ")</div>";
      }
    }
  };
  var data = new FormData(document.getElementById(formId));
  xhr.open("POST", url, true);
  xhr.send(data);
}

// ---------- Current sort settings (Q8) ----------
var sortColumn = "id";
var sortOrder = "ASC";

// ---------- Q3 + Q5 + Q8: load the table ----------
function loadTable() {
  var search = document.getElementById("search").value;
  var url = "list.php?search=" + encodeURIComponent(search) +
            "&sort=" + sortColumn + "&order=" + sortOrder;
  sendGet(url, "tableBox");
}

// ---------- Q8: header click ----------
function sortBy(column) {
  if (sortColumn == column && sortOrder == "ASC") {
    sortOrder = "DESC";
  } else {
    sortColumn = column;
    sortOrder = "ASC";
  }
  loadTable();
}

// ---------- Q6: report ----------
function loadReport() {
  sendGet("report.php", "reportBox");
}

// Reload both table and report (used on page load and after any change)
function refreshAll() {
  loadTable();
  loadReport();
}

// ---------- Q4: add ----------
function addStudent() {
  sendPost("add.php", "addForm", "addMsg", refreshAll);
}

// ---------- Q7: edit ----------
function editStudent(btn, id) {
  var row = btn.parentNode.parentNode;          // button -> td -> tr
  var oldName = row.cells[1].innerText;
  var oldMarks = row.cells[4].innerText;

  var newName = prompt("Enter new name:", oldName);
  if (newName == null) { return; }              // user pressed Cancel
  var newMarks = prompt("Enter new marks (0-100):", oldMarks);
  if (newMarks == null) { return; }

  var url = "update.php?id=" + id +
            "&name=" + encodeURIComponent(newName) +
            "&marks=" + encodeURIComponent(newMarks);
  sendGet(url, "tableMsg", refreshAll);
}

// ---------- Q7: delete ----------
function deleteStudent(id) {
  if (confirm("Delete this record?")) {
    sendGet("delete.php?id=" + id, "tableMsg", refreshAll);
  }
}