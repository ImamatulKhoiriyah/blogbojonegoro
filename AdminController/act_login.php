<?php
session_start();

include '../connection.php';

if (isset($_POST["submit"])) {
    $username = $_POST['inputUsername'];
    $password = $_POST['inputPassword'];
    $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["login"] = true;
        $_SESSION["username"] = $row["username"];
        header('Location: viewAdmin.php');
        exit();
    } else {
        echo "<script> 
        alert('Invalid username or password');
        document.location='login.php';
        </script>";
    }
}
?>
