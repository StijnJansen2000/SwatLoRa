<?php
session_start();
include 'dbh.php';

if (isset($_POST['submit'])){
    $id = htmlspecialchars($_POST['data_id']);

    $query = $conn->prepare('DELETE FROM data WHERE data_id=:id');
    $query->execute(array(
        ':id' => $id
    ));

    header("Location: ../?page=data");
}
