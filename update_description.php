<?php
var_dump($_POST);
// update_description.php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "travelblog";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postId = $_POST["postId"];
    $description = $_POST["description"];

    $sql = "UPDATE posts SET description = '$description' WHERE id = $postId";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }

    $conn->close();
}
?>
