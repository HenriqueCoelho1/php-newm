<?php
require_once("connection.php");
require_once("header.php");

$sql = "
    SELECT 
        id,
        name,
        email,
        birth,
        phone,
        address,
        cpf,
        description
    FROM users
    WHERE 1 = 1
";

if (isset($_GET['query'])) {
    $query_string = '%' . $_GET['query'] . '%';
    $sql .= " AND name LIKE :query or email LIKE :query";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':query', $query_string);
} else {
    $stmt = $conn->prepare($sql);
}
$sql .= " ORDER BY id";
$stmt->execute();

echo '
<div class="container">
    <input id="query_string" type="text" name="query" placeholder="Nome ou Email" maxlength="250" autofocus>
    <a href="" type="button" class="btn btn-primary" onclick="this.href=\'/?query=\'+document.getElementById(\'query_string\').value">Filtrar</a>
</div>
';

echo '
<br>
<div class="container">
    <table class="table table-striped">
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Nascimento</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>CPF</th>
            <th>Comentário</th>
            <th>Ações</th>
        </tr>
';

$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$user_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($user_list as $value) {
    echo "<tr>";
    echo "<td>" . $value["id"] . "</td>";
    echo "<td>" . $value["name"] . "</td>";
    echo "<td>" . $value["email"] . "</td>";
    echo "<td>" . $value["birth"] . "</td>";
    echo "<td>" . $value["phone"] . "</td>";
    echo "<td>" . $value["address"] . "</td>";
    echo "<td>" . $value["cpf"] . "</td>";
    echo "<td>" . $value["description"] . "</td>";
    echo "<td><a><a href='update_user.php?id=" . $value["id"] . "'type='button' class='btn btn-warning'>Editar</a></a></td>";
    echo "<td><a><a href='delete_user.php?id=" . $value["id"] . "'type='button' class='btn btn-danger'>Deletar</a></a></td>";
    echo "<tr>";
}

echo '
    </table>
    <a href="register_user.php" type="button" class="btn btn-success">Registrar Usuário</a>
</div>
';
?>



<?php
require_once("footer.php");

?>