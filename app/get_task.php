<?php
$conn = new mysqli("localhost", "root", "", "databaze");

$sql = "SELECT id, title, deadline, status FROM tasks";
$result = $conn->query($sql);

$events = [];

while($row = $result->fetch_assoc()){
    $events[] = [
        "id" => $row["id"],
        "title" => $row["title"],
        "start" => $row["deadline"],
        "color" => $row["status"] == "completed" ? "green" : "red"
    ];
}

echo json_encode($events);
?>