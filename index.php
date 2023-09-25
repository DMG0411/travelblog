<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
    <title>WikiTravel</title>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="home.html">Home</a></li>
            <li><a href="index.php">Blog</a></li>
        </ul>
    </nav>
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search...">
        <button id="searchButton" onclick="searchKeyword();">Search</button>
    </div>
    <div class="container">
        <div class="postForm">
            <h3>Add a post<br>
            <form enctype="multipart/form-data" id="postForm" action="upload_post.php" method="POST">
                <h5>Choose a photo to upload:
                <input type="file" id="photo" name="photo"><br>
                <h5>Write your thoughts:
                <input type="text" id="description" name="description"><br>
                <input type="submit" class="button" value="Post">
            </form>
        </div>
        <br>
        <div id="postsContainer">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "travelblog";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM posts";
                $result = $conn->query($sql);

                if ($result === false) {
                    echo "Eroare la interogare: " . $conn->error;
                } else {
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="card">';
                                if (!empty($row["photo"])) {
                                    echo '<img src="data:image;base64,' . base64_encode($row['photo']) . '" style="width: auto; height:auto;">';
                                } else {
                                    echo "<h3> There is no image to show!</h3>";
                                }
                                echo '<p>' . $row["description"] . '</p>';         
                        ?>
                            <div class="btn-container">
                                <button class="btn-edit" onclick="showEditForm(this)">Edit</button>

                                <div class="edit-form" style="display : none;">
                                <input type="text" class="edit-description" name="edit_description" value="<?php echo $row["description"];?>">
                                <button class="btn-done" onclick="saveEdit(this)" data-post-id="<?php echo $row['id']; ?>">Done</button>
                                </div>
                                <button class="btn-delete" onclick="deletePost(this)" data-post-id="<?php echo $row['id']; ?>">Delete</button>
                            </div>
                            <br>
                        <?php
                            echo '</div>';
                        }
                    } else {
                        echo "There are no posts yet!";
                    }
                }

                $conn->close();
                ?>
        </div>
    </div>
</body>
</html>