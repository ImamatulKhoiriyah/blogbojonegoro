
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog ima</title>
    <!-- Box-icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="nav container">
            <a href="#" class="logo">Blog <span>Bojonegoro</span></a>
            <a href="../AdminController/login.php" class="login">Login</a>
        </div>
    </header>

    <section class="home" id="home">
        <div class="home-text container">
            <h2 class="home-title">Bojonegoro Matoh</h2>
            <span class="home-subtitle">sepi ing pamrih, rame ing gawe</span>
        </div>
    </section>

    <section class="about container" id="about">
        <div class="contentBx">
            <h2 class="titleText"  >Kabupaten Bojonegoro</h2>
            <p class="title-text" style="text-align: justify;">
            Bojonegoro, kota yang terletak di Jawa Timur, Indonesia, merupakan sebuah destinasi yang memikat dengan kekayaan budaya dan sumber daya alamnya. 
            Dikenal sebagai salah satu daerah penghasil minyak dan gas, Bojonegoro menawarkan keindahan alam yang memukau, seperti Sungai Bengawan Solo yang mengalir di sepanjang kota. 
            Selain itu, kota ini juga memiliki situs-situs bersejarah yang menarik, seperti candi-candi kuno yang menceritakan tentang warisan budaya yang kaya. Dengan pemandangan sawah yang hijau dan pesona desa yang memikat, 
            Bojonegoro menjadi tujuan yang populer bagi wisatawan yang ingin menggali kekayaan tradisi dan kehidupan pedesaan yang autentik.
            </p>
        </div>
        <div class="imgBx">
            <img src="images/banner.png" alt="" class="fitBg">
        </div>
    </section>

    <div class="post-filter container">
    <span class="filter-item active-filter" data-filter="all">Semua</span>
    <?php
    include "../connection.php";

    $query = "SELECT * FROM kategori";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categoryName = $row['nama_kategori'];
            $categoryId = $row['id_kategori'];

            // Display the category names
            echo '<span class="filter-item" data-filter="' . $categoryName . '">' . $categoryName . '</span>';
        }
    } else {
        echo "No categories found.";
    }
    ?>
</div>
<div class="post container">
    <?php
    session_start();
    include "../connection.php";
    $query = "SELECT a.id_artikel, a.*, c.nama_kategori AS nama_kategori 
              FROM artikel AS a
              INNER JOIN kategori AS c ON a.id_kategori = c.id_kategori
              ORDER BY a.id_artikel DESC";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $postTitle = $row['judul'];
            $postCategory = $row['nama_kategori'];
            $postDate = $row['tanggal'];
            $postDescription = $row['isi'];
            $postAuthor = $row['penulis'];
            $postImage = $row['gambar'];

            // Display the post
            echo '<div class="post-box ' . $postCategory . '">';
            echo '<img src="../AdminController/img/' . $postImage . '" alt="Image Article" class="post-img">';
            echo '<h2 class="category">' . $postCategory . '</h2>';
            echo '<a href="detailArticle.php?id=' . $row['id_artikel'] . '" class="post-title">' . $postTitle . '</a>';
            echo '<span class="post-date">' . $postDate . '</span>';
            echo '<p class="post-description">' . $postDescription . '</p>';
            echo '<div class="profile">';
            echo '<img src="images/iconadmin.png" alt="" class="profile-img">';
            echo '<span class="profile-name">' . $postAuthor . '</span>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No articles found.";
    }
    ?>
</div>

<script>
    // Get all the filter items
    const filterItems = document.querySelectorAll('.filter-item');

    // Add click event listener to each filter item
    filterItems.forEach(function(filterItem) {
        filterItem.addEventListener('click', function() {
            const selectedFilter = filterItem.getAttribute('data-filter');
            const postBoxes = document.querySelectorAll('.post-box');

            // Show all post boxes if 'All' is selected
            if (selectedFilter === 'all') {
                postBoxes.forEach(function(postBox) {
                    postBox.style.display = 'block';
                });
            } else {
                // Hide post boxes that don't match the selected filter
                postBoxes.forEach(function(postBox) {
                    const postCategory = postBox.querySelector('.category').textContent;
                    if (postCategory !== selectedFilter) {
                        postBox.style.display = 'none';
                    } else {
                        postBox.style.display = 'block';
                    }
                });
            }

            // Update the active filter item
            filterItems.forEach(function(item) {
                item.classList.remove('active-filter');
            });
            filterItem.classList.add('active-filter');
        });
    });
</script>
    </div>

    <footer>
        <div class="footer-container">
            <div class="sec aboutus">
                <h2>About me</h2>
                <p>Imamatul Khoiriyah</p>
                <p>Mahasiswa Teknik Informatika Universitas Islam Negeri Maulana Malik Ibrahim Malang</p>
                <ul class="sci">
                    <li><a href="https://www.facebook.com/profile.php?id=100072051579782"><i class="bx bxl-facebook"></i></a></li>
                    <li><a href="https://instagram.com/imamtl.k?igshid=MzNlNGNkZWQ4Mg=="><i class="bx bxl-instagram"></i></a></li>
                    <li><a href="https://www.linkedin.com/in/imamatul-khoiriyah-106269248/"><i class="bx bxl-linkedin"></i></a></li>
                </ul>
            </div>
        
            <div class="sec contactBx">
                <h2>Contact Info</h2>
                <ul class="info">
                    <li>
                        <span><i class='bx bxs-map'></i></span>
                        <span>Jalan Simpang Sunan Kalijaga Nomor 6 Lowokwaru, Dinoyo, <br>Kec. Lowokwaru, Kota Malang,</span>
                    </li>
                    <li>
                        <span><i class='bx bx-envelope'></i></span>
                        <p><a href="mailto:codemyhobby9@gmail.com">heremichiii@gmail.com</a></p>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="main.js"></script>
</body>

</html>