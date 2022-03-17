<?php

require_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $birth = $_POST["birth"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $cpf = $_POST["cpf"];
    $cpf_validate = preg_replace('/[^0-9]/', '', $cpf);
    $phone_validate = preg_replace('/[^0-9]/', '', $phone);
    $description = $_POST["description"];
    try {
        $stmt = $conn->prepare("
            INSERT INTO users (
                name,
                email,
                birth,
                phone,
                address,
                cpf,
                description
            ) VALUES (
                :name,
                :email,
                :birth,
                :phone,
                :address,
                :cpf,
                :description
            )
            ");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':birth', $birth);
        $stmt->bindParam(':phone', $phone_validate);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':cpf', $cpf_validate);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
        header("Location: {$_SERVER['REQUEST_URI']}new_record=1", true, 303);
    } catch (PDOException $e) {
        header("Location: {$_SERVER['REQUEST_URI']}error=1", true, 303);
    }
    exit();
} else {
    require_once("header.php");
    echo '
    <div class="container">
        <form method="post" action="?">
            <div class="mb-3">
                <label class="form-label">Nome Completo</label>
                <input class="form-control" type="text" id="name" name="name" max="250" required onblur="validate_name(this, 3)" placeholder="Nome Completo" maxlength="250">
                <div class="invalid-feedback">Nome inválido!</div>
            </div>
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input class="form-control" type="email" id="email" name="email" max="250" required onblur="validate_email(this)" placeholder="e-mail" maxlength="250">
                <div class="invalid-feedback">Email inválido!</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Endereço</label>
                <input class="form-control" type="text" id="address" name="address" max="250" required placeholder="endereço">
            </div>
            <div class="mb-3">
                <label class="form-label">Nascimento</label>
                <input class="form-control" type="date" id="birth" name="birth" required placeholder="Data de nascimento">
            </div>
            <div class="mb-3">
                <label class="form-label">Celular</label>
                <input class="form-control" type="text" id="phone" name="phone" required onblur="validate_phone(this)" placeholder="celular" maxlength="13">
                <div class="invalid-feedback">Celular inválido!</div>
            </div>
            <div class="mb-3">
                <label class="form-label">CPF</label>
                <input class="form-control" type="text" id="cpf" name="cpf" required onchange="formatar_cpf_cnpj(this)" placeholder="CPF" maxlength="11">
            </div>
            <div class="mb-3">
                <label class="form-label">Observação</label>
                <textarea class="form-control" rows="5" type="text" id="description" name="description" id="description" placeholder="Observação"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
            <a type="button" href="/" class="btn btn-warning">Cancelar</a>
        </form>
    </div>
    ';
    if (isset($_GET['new_record'])) {
        echo '<script>alert("Novo usuário salvo!")</script>';
    }
    if (isset($_GET['error'])) {
        echo '<script>alert("Erro ao inserir novo usuário!")</script>';
    }
    require_once "footer.php";
}
