<?php
// variaveis de conexao
$servername = "mariadb";
$dbname = "db";
$username = "user";
$password = "123456";

try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
      echo "Connection to DB failed: " . $e->getMessage();
}

?>