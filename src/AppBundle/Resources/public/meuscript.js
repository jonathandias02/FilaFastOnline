//Base Começa aqui
var login = $("input[name='login']").val();

$(function () {
    $("input[name='confirmar']").blur(function () {
        var senha = document.getElementById("senha").value;
        var confirmar = document.getElementById("confirmar").value;

        if (confirmar !== "") {

            if (senha !== confirmar) {
                $('#senhas').html("As senhas não conferem!");
                $("input[name='senha']").focus().val("");
                $("input[name='confirmar']").val("");
                $("input[name='senha']").removeClass("form-control");
                $("input[name='senha']").addClass("form-control is-invalid");
                $("input[name='confirmar']").removeClass("form-control");
                $("input[name='confirmar']").addClass("form-control is-invalid");
//                $("#btnalterarSenha").prop("disabled", true);
            } else {
                $('#senhas').html("");
                $("input[name='senha']").removeClass("form-control is-invalid");
                $("input[name='senha']").addClass("form-control is-valid");
                $("input[name='confirmar']").removeClass("form-control is-invalid");
                $("input[name='confirmar']").addClass("form-control is-valid");
//                $("#btnalterarSenha").prop("disabled", false);
            }
        } else {
            $('#senhas').html("");
            $("input[name='senha']").removeClass("form-control is-invalid");
            $("input[name='senha']").removeClass("form-control is-valid");
            $("input[name='senha']").addClass("form-control");
            $("input[name='confirmar']").removeClass("form-control is-invalid");
            $("input[name='confirmar']").removeClass("form-control is-valid");
            $("input[name='confirmar']").addClass("form-control");
//            $("#btnalterarSenha").prop("disabled", true);
        }
    });
});

$(function () {
    $("input[name='senha']").blur(function () {
        var senha = document.getElementById("senha").value;
        var confirmar = document.getElementById("confirmar").value;

        if (senha.length < 6 && senha.length > 0 && confirmar.length === 0) {
            $('#senhas').html("A senha deve conter entre 6 e 12 caracteres, podendo conter letras, numeros e caracteres especias.");
            $("input[name='senha']").removeClass("form-control");
            $("input[name='senha']").removeClass("form-control is-valid");
            $("input[name='senha']").addClass("form-control is-invalid");
            $("input[name='senha']").focus().val("");
        } else {

            if (confirmar === "") {
                $('#senhas').html("");
                $("input[name='senha']").removeClass("form-control is-invalid");
                $("input[name='senha']").removeClass("form-control is-valid");
                $("input[name='senha']").addClass("form-control");
                $("input[name='confirmar']").removeClass("form-control is-invalid");
                $("input[name='confirmar']").removeClass("form-control is-valid");
                $("input[name='confirmar']").addClass("form-control");
//                $("#btnalterarSenha").prop("disabled", true);
            } else {
                if (senha !== confirmar) {
                    $('#senhas').html("As senhas não conferem!");
                    $("input[name='senha']").focus().val("");
                    $("input[name='confirmar']").val("");
                    $("input[name='senha']").removeClass("form-control");
                    $("input[name='senha']").addClass("form-control is-invalid");
                    $("input[name='confirmar']").removeClass("form-control");
                    $("input[name='confirmar']").addClass("form-control is-invalid");
//                    $("#btnalterarSenha").prop("disabled", true);
                } else {
                    $('#senhas').html("");
                    $("input[name='senha']").removeClass("form-control is-invalid");
                    $("input[name='senha']").addClass("form-control is-valid");
                    $("input[name='confirmar']").removeClass("form-control is-invalid");
                    $("input[name='confirmar']").addClass("form-control is-valid");
//                    $("#btnalterarSenha").prop("disabled", false);
                }
            }

        }
    });
});

// Termina aqui

$("#CancelarAltSenha").click(function () {
    $("input[name='senha']").val("");
    $("input[name='confirmar']").val("");
    $('#senhas').html("");
    $("#btnalterarSenha").prop("disabled", true);
    $("input[name='senha']").removeClass("form-control is-invalid");
    $("input[name='senha']").removeClass("form-control is-valid");
    $("input[name='senha']").addClass("form-control");
    $("input[name='confirmar']").removeClass("form-control is-invalid");
    $("input[name='confirmar']").removeClass("form-control is-valid");
    $("input[name='confirmar']").addClass("form-control");
});

function somenteNumeros(num) {
    var er = /[^0-9.]/;
    er.lastIndex = 0;
    var campo = num;
    if (er.test(campo.value)) {
        campo.value = "";
    }

}


function somenteLetras(letra) {
    letra.value = letra.value.replace(/[^a-zA-ZãõÃÕá-úÁ-ÚçÇ]/g, '');
}

function somenteLetras2(letra) {
    letra.value = letra.value.replace(/[^a-zA-ZãõÃÕá-úÁ-ÚçÇ ]/g, '');
}


$(function () { // declaro o início do jquery
    $("input[name='login']").blur(function () {

        var usuario = $("input[name='login']").val().length;
        if (usuario < 4 && usuario > 0) {
            $('#resultado').html("O login deve possuir no mínimo 4 números, você digitou apenas " + usuario);
            $("input[name='login']").focus().select();
            $("input[name='login']").removeClass("form-control");
            $("input[name='login']").removeClass("form-control is-valid");
            $("input[name='login']").addClass("form-control is-invalid");
        } else {
            var usuario = $("input[name='login']").val();

            if (usuario !== "") {

                if (usuario !== login) {
                    $.post('../../verificaUsuario/2f91be91b6240fd004bb9dba4f6f5919.php', {usuario: usuario}, function (data) {
                        if (data !== "Não existe!") {
                            $('#resultado').html(data);
                            $("input[name='login']").focus().select();
                            $("input[name='login']").removeClass("form-control");
                            $("input[name='login']").addClass("form-control is-invalid");
                        } else {
                            $('#resultado').html("");
                            $("input[name='login']").removeClass("form-control is-invalid");
                            $("input[name='login']").addClass("form-control is-valid");
                        }
                    });
                } else {
                    $('#resultado').html("");
                    $("input[name='login']").removeClass("form-control is-valid");
                    $("input[name='login']").removeClass("form-control is-invalid");
                    $("input[name='login']").addClass("form-control");
                }
            } else {
                $('#resultado').html("");
                $("input[name='login']").removeClass("form-control is-valid");
                $("input[name='login']").removeClass("form-control is-invalid");
                $("input[name='login']").addClass("form-control");
            }
        }
    });
});


$(function () {
    $("input[name='nome']").blur(function () {
        var nome = $("input[name='nome']").val().toLowerCase().split(" ");
        for (var a = 0; a < nome.length; a++) {
            var n = nome[a];
            nome[a] = n[0].toUpperCase() + n.slice(1);
        }

        $("input[name='nome']").val(nome.join(" "));

    });
});

$(function () {
    $("input[name='sobrenome']").blur(function () {
        var nome = $("input[name='sobrenome']").val().toLowerCase().split(" ");
        for (var a = 0; a < nome.length; a++) {
            var n = nome[a];
            nome[a] = n[0].toUpperCase() + n.slice(1);
        }

        $("input[name='sobrenome']").val(nome.join(" "));

    });
});