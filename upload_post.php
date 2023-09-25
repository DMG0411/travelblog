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
    $photoFile = $_FILES['photo']['tmp_name'];
    if($photoFile){
        $x = file_get_contents($photoFile);
    }
   else{
    $x = "";
   }
    $y = $_POST['description'];
    
    $sql = "INSERT INTO posts (photo, description) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $x, $y);

    if ($stmt->execute()) {
        header("Refresh:0, url=index.php");
    }
}
?>