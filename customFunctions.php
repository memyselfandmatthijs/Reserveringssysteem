<?php
session_start();

if (!isset($_SESSION['login'])){
    header('location: inlog.php');
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location: inlog.php');
}

function check_logged_in() {
    if (!isset($_SESSION['login'])){
        header('location: inlog.php');
    }
}

function check_admin_right($conn) {
    $username = $_SESSION['username'];
    $adminCheckSql = " SELECT admin FROM bezorgers WHERE relatie_nummer = $username ";
    $result = mysqli_query($conn, $adminCheckSql);
    return mysqli_fetch_assoc($result)['admin'];
}

function registerDate($date, $conn, $username){
    $sql = "INSERT INTO `beschikbaarheid` (datum, relatie_nummer) VALUES ('$date', '$username')";
    if (mysqli_query($conn, $sql)){
        echo "gegevens opgeslagen";
    }
    else{
        //echo "u heeft al beschikbaarheid aangegeven voor:" . $date . "<br>";
        //echo "Error: " . "<br>" . mysqli_error($conn);
    }
}
