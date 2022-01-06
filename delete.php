<?php

session_start();

$id = $_GET['id'];
$conn = mysqli_connect('localhost', 'root', '', 'regis');
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to delete a record
$sql = "DELETE FROM recipe WHERE rid = $id";
$sql2 = "DELETE FROM images WHERE rid = $id";

//get image path
$sql_old = "SELECT img_loc FROM images WHERE rid = $id";
$result = mysqli_query($conn, $sql_old);
$row_old = mysqli_fetch_assoc($result);
$old_img = $row_old["img_loc"];


//delete old img
if (file_exists($old_img)) {
    unlink($old_img);
} else {
    echo 'Could not delete ' . $old_img . ', file does not exist';
}

//delete recipe and image table entry
if (mysqli_query($conn, $sql)) {

    if (mysqli_query($conn, $sql2)) {
    } else {
        echo "Error deleting image";
    }

    mysqli_close($conn);
    header('Location: recipe.php');
    exit;
} else {
    echo "Error deleting recipe";
}
