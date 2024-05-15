<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Article Detail</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
    <div class="container">
    <?php
include "connection.php";

// Check if article ID is provided
if (isset($_GET['id'])) {
    $articleId = $_GET['id'];

    // Retrieve article details from the database
    $query = "SELECT a.id_artikel, a.*, c.nama_kategori AS nama_kategori 
              FROM artikel AS a
              INNER JOIN kategori AS c ON a.id_kategori = c.id_kategori
              WHERE a.id_artikel = $articleId";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $postTitle = $row['judul'];
        $postCategory = $row['nama_kategori'];
        $postDate = $row['tanggal'];
        $postDescription = $row['isi'];
        $postAuthor = $_SESSION["username"];
        $postImage = $row['gambar'];

        // Display the article details
        echo '<div class="post-box ' . $postCategory . '">';
        echo '<img src="../AdminController/img/' . $postImage . '" alt="" class="post-img">';
        echo '<a href="index.php" class="back-link">home</a>';
        echo '<p href="#" class="post-title">' . $postTitle . '</p>';
        echo '<h2 class="category">' . $postCategory . '</h2>';
        echo '<span class="post-date">' . $postDate . '</span>';
        $paragraphs = explode("\n", $postDescription); // Split by line breaks
        foreach ($paragraphs as $paragraph) {
        echo '<p class="post-description">' . nl2br($paragraph) . '</p>';
    }
        echo '<div class="profile">';
        echo '<img src="images/iconadmin.png" alt="" class="profile-img">';
        echo '<span class="profile-name">' . $postAuthor . '</span>';
        echo '</div>';
        echo '</div>';

    } else {
        echo "Article not found.";
    }
} else {
    echo "Invalid article ID.";
}
?>

    </div>
</body>
</html>
