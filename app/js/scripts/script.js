$(document).ready(function () {
    $("#phone").mask("(00)0000-00009")

    $("#phone").blur(function (event) {
        if ($(this).val().length == 14) {
            $("#phone").mask("(00)00000-0009")
        } else {
            $("#phone").mask("(00)0000-00009")
        }
    })
})


function validate_name(el, size) {
    var valid_name = /[a-zA-Z\u00C0-\u00FF ]+/i

    if (!el.value.match(valid_name)) {
        el.classList.remove('is-valid');
        el.classList.add('is-invalid');
    }
    else {
        el.classList.remove('is-invalid');
        el.classList.add('is-valid');
    }
}


function formatar_cpf_cnpj(campo_texto) {
    var valido;
    if (campo_texto.value.length <= 11) {
        campo_texto.value = mascara_cpf(campo_texto.value).trim();
        valido = valida_cpf(campo_texto.value);
    }
    if (!valido) {
        campo_texto.classList.remove('is-valid');
        campo_texto.classList.add('is-invalid');
    } else {
        campo_texto.classList.remove('is-invalid');
        campo_texto.classList.add('is-valid');
    }
    if (valido) {
        campo_texto.classList.remove('is-invalid');
        campo_texto.classList.add('is-valid');
    } else {
        campo_texto.classList.remove('is-valid');
        campo_texto.classList.add('is-invalid');
    }

}

function mascara_cpf(valor) {
    return valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "\$1.\$2.\$3\-\$4");
}


function valida_cpf(cpf) {
    if (typeof cpf !== "string") return false
    cpf = cpf.replace(/[\s.-]*/igm, '')
    if (
        !cpf ||
        cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999"
    ) {
        return false
    }
    var soma = 0
    var resto
    for (var i = 1; i <= 9; i++)
        soma = soma + parseInt(cpf.substring(i - 1, i)) * (11 - i)
    resto = (soma * 10) % 11
    if ((resto == 10) || (resto == 11)) resto = 0
    if (resto != parseInt(cpf.substring(9, 10))) return false
    soma = 0
    for (var i = 1; i <= 10; i++)
        soma = soma + parseInt(cpf.substring(i - 1, i)) * (12 - i)
    resto = (soma * 10) % 11
    if ((resto == 10) || (resto == 11)) resto = 0
    if (resto != parseInt(cpf.substring(10, 11))) return false
    return true
}

function validate_email(el) {
    var valid_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (!el.value.match(valid_email)) {
        el.classList.remove('is-valid');
        el.classList.add('is-invalid');
    } else {
        el.classList.remove('is-invalid');
        el.classList.add('is-valid');
    }
}

function validate_phone(el) {
    var valid_phone = "^\\(((1[1-9])|([2-9][0-9]))\\)((3[0-9]{3}-[0-9]{4})|(9[0-9]{3}-[0-9]{5}))$"
    if (!el.value.match(valid_phone)) {
        el.classList.remove('is-valid');
        el.classList.add('is-invalid');
    } else {
        el.classList.remove('is-invalid');
        el.classList.add('is-valid');
    }
}

