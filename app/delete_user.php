<?php

require_once("connection.php");

try {

    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
} catch (\Throwable $th) {
    // echo $th;
}
header( "Location: /", true, 303 );
?>