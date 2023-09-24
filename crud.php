<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travelblog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $x = $_POST['photo'];
    $y = $_POST['description'];
    
    $sql = "INSERT INTO posts (photo, description) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $x, $y);

    if ($stmt->execute()) {
        header("Refresh:0, url=index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = 'SELECT photo, description FROM posts';
$result = $conn->query($sql);
?>