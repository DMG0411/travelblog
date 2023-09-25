<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travelblog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

$sql = "SELECT * FROM posts";
$result = $conn->query($sql);

$posts = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');

echo json_encode($posts);
?>
