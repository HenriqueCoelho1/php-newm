<?php

require_once("connection.php");

if (!isset($_GET['id']) && !isset($_POST['id'])) {
    header("Location: /", true, 303);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $birth = $_POST["birth"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $cpf = $_POST["cpf"];
    $description = $_POST["description"];
    $id = $_POST["id"];

    try {
        $stmt = $conn->prepare("
            UPDATE users 
            SET
                name = :name,
                email = :email,
                birth = :birth,
                phone = :phone,
                address = :address,
                cpf = :cpf,
                description = :description
            WHERE id = :id
        ");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':birth', $birth);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        header("Location: /", true, 303);
    } catch (PDOException $e) {
        header("Location: {$_SERVER['REQUEST_URI']}error=1", true, 303);
        exit();
    }
} else {
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
        WHERE id = :id
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $id = $user['id'];
    $name = $user['name'];
    $email = $user['email'];
    $address = $user['address'];
    $birth = $user['birth'];
    $phone = $user['phone'];
    $cpf = $user['cpf'];
    $description = $user['description'];
    echo
    "<div class='container'>
        <form method='post' action='?'>
            <div class='mb-3'>
                <label class='form-label'>Nome Completo</label>
                <input class='form-control' type='text' id='name' name='name' value='$name' max='250' required onblur='validate_name(this, 3)' placeholder='Nome Completo' maxlength='250'>
                <div class='invalid-feedback'>Nome inválido!</div>
            </div>
            <div class='mb-3'>
                <label class='form-label'>E-mail</label>
                <input class='form-control' type='email' id='email' name='email' max='250' value='$email' required onblur='validate_email(this)' placeholder='e-mail' maxlength='250'>
                <div class='invalid-feedback'>Email inválido!</div>
            </div>
            <div class='mb-3'>
                <label class='form-label'>Endereço</label>
                <input class='form-control' type='text' id='address' name='address' value='$address' max='250' required placeholder='endereço'>
            </div>
            <div class='mb-3'>
                <label class='form-label'>Nascimento</label>
                <input class='form-control' type='date' id='birth' name='birth' value='$birth' required placeholder='Data de nascimento'>
            </div>
            <div class='mb-3'>
                <label class='form-label'>Celular</label>
                <input class='form-control' type='text' id='phone' name='phone' value='$phone' required onblur='validate_phone(this)' placeholder='celular' maxlength='13'>
                <div class='invalid-feedback'>Celular inválido!</div>
            </div>
            <div class='mb-3'>
                <label class='form-label'>CPF</label>
                <input class='form-control' type='text' id='cpf' name='cpf' value='$cpf' required onchange='formatar_cpf_cnpj(this)' placeholder='CPF' maxlength='11'>
            </div>
            <div class='mb-3'>
                <label class='form-label'>Observação</label>
                <textarea class='form-control' rows='5' type='text' id='description'  name='description' id='description' placeholder='Observação'>$description</textarea>
            </div>
            <input type='hidden' name='id' value=''.$id.''>
            <button type='submit' class='btn btn-success'>Salvar</button>
            <a type='button' href='/' class='btn btn-warning'>Cancelar</a>
        </form>
    </div>";
    if (isset($_GET['new_record'])) {
        echo '<script>alert("Usuário salvo!")</script>';
    }
    if (isset($_GET['error'])) {
        echo '<script>alert("Erro ao atualizar usuário!")</script>';
    }
    require_once "footer.php";
}
