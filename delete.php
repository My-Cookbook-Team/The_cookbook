<?php

session_start();

$id = $_GET['id'];
echo $id . " ";
$conn = mysqli_connect('localhost', 'root', '', 'regis');
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to delete a record
$sql = "DELETE FROM recipe WHERE rid = $id";

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header('Location: recipe.php');
    exit;
} else {
    echo "Error deleting record";
}
