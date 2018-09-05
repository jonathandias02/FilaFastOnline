//Base Começa aqui

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
                $("#btnalterarSenha").prop("disabled", true);
            } else {
                $('#senhas').html("");
                $("input[name='senha']").removeClass("form-control is-invalid");
                $("input[name='senha']").addClass("form-control is-valid");
                $("input[name='confirmar']").removeClass("form-control is-invalid");
                $("input[name='confirmar']").addClass("form-control is-valid");
                $("#btnalterarSenha").prop("disabled", false);
            }
        } else {
            $('#senhas').html("");
            $("input[name='senha']").removeClass("form-control is-invalid");
            $("input[name='senha']").removeClass("form-control is-valid");
            $("input[name='senha']").addClass("form-control");
            $("input[name='confirmar']").removeClass("form-control is-invalid");
            $("input[name='confirmar']").removeClass("form-control is-valid");
            $("input[name='confirmar']").addClass("form-control");
            $("#btnalterarSenha").prop("disabled", true);
        }
    });
});

$(function () {
    $("input[name='senha']").blur(function () {
        var senha = document.getElementById("senha").value;
        var confirmar = document.getElementById("confirmar").value;
        if (confirmar === "") {
            $('#senhas').html("");
            $("input[name='senha']").removeClass("form-control is-invalid");
            $("input[name='senha']").removeClass("form-control is-valid");
            $("input[name='senha']").addClass("form-control");
            $("input[name='confirmar']").removeClass("form-control is-invalid");
            $("input[name='confirmar']").removeClass("form-control is-valid");
            $("input[name='confirmar']").addClass("form-control");
            $("#btnalterarSenha").prop("disabled", true);
        } else {
            if (senha !== confirmar) {
                $('#senhas').html("As senhas não conferem!");
                $("input[name='senha']").focus().val("");
                $("input[name='confirmar']").val("");
                $("input[name='senha']").removeClass("form-control");
                $("input[name='senha']").addClass("form-control is-invalid");
                $("input[name='confirmar']").removeClass("form-control");
                $("input[name='confirmar']").addClass("form-control is-invalid");
                $("#btnalterarSenha").prop("disabled", true);
            } else {
                $('#senhas').html("");
                $("input[name='senha']").removeClass("form-control is-invalid");
                $("input[name='senha']").addClass("form-control is-valid");
                $("input[name='confirmar']").removeClass("form-control is-invalid");
                $("input[name='confirmar']").addClass("form-control is-valid");
                $("#btnalterarSenha").prop("disabled", false);
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