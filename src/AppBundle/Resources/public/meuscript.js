var login = $("input[name='login']").val();
var nomeGlobal = $("input[name='nome'").val();
var siglaGlobal = $("input[name='sigla'").val();

//funcao para verificar se confirmar senha bate com a senha
$(function () {
    $("input[name='confirmar']").blur(function () {
        var senha = document.getElementById("senha").value;
        var confirmar = document.getElementById("confirmar").value;

        if (confirmar !== "") {

            if (senha !== confirmar) {
                $('#senhas').html("As senhas não conferem!");
                $('#resultadoConfirmar').html("");
                $("input[name='senha']").focus().val("");
                $("input[name='confirmar']").val("");
                $("input[name='senha']").removeClass("form-control");
                $("input[name='senha']").addClass("form-control is-invalid");
                $("input[name='confirmar']").removeClass("form-control");
                $("input[name='confirmar']").addClass("form-control is-invalid");
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
            $('#resultadoConfirmar').html("");
            $("input[name='senha']").removeClass("form-control is-invalid");
            $("input[name='senha']").removeClass("form-control is-valid");
            $("input[name='senha']").addClass("form-control");
            $("input[name='confirmar']").removeClass("form-control is-invalid");
            $("input[name='confirmar']").removeClass("form-control is-valid");
            $("input[name='confirmar']").addClass("form-control");
        }
    });
});

//funcao para verificar se senha é valida
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
                }
            }

        }
    });
});

//funcao para cancelar o alterar senha
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

function maiuscula(letra) {
    letra.value = letra.value.toUpperCase();
}

function somenteLetras(letra) {
    letra.value = letra.value.replace(/[^a-zA-ZãõÃÕá-úÁ-ÚçÇ]/g, '');
}

function somenteLetras2(letra) {
    letra.value = letra.value.replace(/[^a-zA-ZãõÃÕá-úÁ-ÚçÇ ]/g, '');
}

//função para verificar se o login já esta em uso
$(function () {
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

//função para colocar a primeira letra de cada palavra maiuscula campo nome
$(function () {
    $("input[name='nome']").blur(function () {
        $('#resultadoNome').html("");
        var nome = $("input[name='nome']").val().toLowerCase().split(" ");
        for (var a = 0; a < nome.length; a++) {
            var n = nome[a];
            nome[a] = n[0].toUpperCase() + n.slice(1);
        }
        $("input[name='nome']").val(nome.join(" "));
    });
});

//função para colocar a primeira letra de cada palavra maiuscula campo sobrenome
$(function () {
    $("input[name='sobrenome']").blur(function () {
        $('#resultadoSobrenome').html("");
        var nome = $("input[name='sobrenome']").val().toLowerCase().split(" ");
        for (var a = 0; a < nome.length; a++) {
            var n = nome[a];
            nome[a] = n[0].toUpperCase() + n.slice(1);
        }

        $("input[name='sobrenome']").val(nome.join(" "));

    });
});

//função para colocar a primeira letra de cada palavra maiuscula campo identificacao
$(function () {
    $("input[name='identificacao']").blur(function () {
        $('#resultado').html("");
        var identificacao = $("input[name='identificacao']").val().toLowerCase().split(" ");
        for (var a = 0; a < identificacao.length; a++) {
            var n = identificacao[a];
            identificacao[a] = n[0].toUpperCase() + n.slice(1);
        }
        $("input[name='identificacao']").val(identificacao.join(" "));
    });
});

//funçao para limpar a div resultadoPerfil quando for preenchida
$(function () {
    $("select[name='tipo']").blur(function () {
        $('#resultadoPerfil').html("");
    });
});

//função para botao salvar usuario
function salvarUsuario() {
    var nome = $("input[name='nome']").val();
    var sobrenome = $("input[name='sobrenome']").val();
    var login = $("input[name='login']").val();
    var senha = $("input[name='senha']").val();
    var confirmar = $("input[name='confirmar']").val();
    var perfil = $("select[name='tipo']").val();
    if (nome === "") {
        $('#resultadoNome').html("O campo nome é obrigatório!");
        $("input[name='nome']").focus();
    } else if (sobrenome === "") {
        $('#resultadoSobrenome').html("O campo sobrenome é obrigatório!");
        $("input[name='sobrenome']").focus();
    } else if (login === "") {
        $('#resultado').html("O campo login é obrigatório!");
        $("input[name='login']").focus();
    } else if (senha === "") {
        $('#senhas').html("O campo senha é obrigatório!");
        $("input[name='senha']").focus();
    } else if (confirmar === "") {
        $('#resultadoConfirmar').html("O campo confirmar senha é obrigatório!");
        $("input[name='confirmar']").focus();
    } else if (perfil === "") {
        $('#resultadoPerfil').html("Selecione um perfil!");
        $("select[name='tipo']").focus();
    } else {
        var usuarioCount = $("input[name='login']").val().length;
        if (usuarioCount < 4 && usuarioCount > 0) {
            $('#resultado').html("O login deve possuir no mínimo 4 números, você digitou apenas " + usuarioCount);
            $("input[name='login']").focus().select();
            $("input[name='login']").removeClass("form-control");
            $("input[name='login']").removeClass("form-control is-valid");
            $("input[name='login']").addClass("form-control is-invalid");
        } else {
            $.post('../../verificaUsuario/2f91be91b6240fd004bb9dba4f6f5919.php', {usuario: login}, function (data) {
                if (data !== "Não existe!") {
                    $('#resultado').html(data);
                    $("input[name='login']").focus().select();
                    $("input[name='login']").removeClass("form-control");
                    $("input[name='login']").addClass("form-control is-invalid");
                } else {
                    $('#resultado').html("");
                    $("input[name='login']").removeClass("form-control is-invalid");
                    $("input[name='login']").addClass("form-control is-valid");
                    $('#formUsuario').submit();
                }
            });
        }
    }
}

//função para botao alterar usuario
function alterarUsuario() {
    var nome = $("input[name='nome']").val();
    var sobrenome = $("input[name='sobrenome']").val();
    var usuario = $("input[name='login']").val();
    var perfil = $("select[name='tipo']").val();
    if (nome === "") {
        $('#resultadoNome').html("O campo nome é obrigatório!");
        $("input[name='nome']").focus();
    } else if (sobrenome === "") {
        $('#resultadoSobrenome').html("O campo sobrenome é obrigatório!");
        $("input[name='sobrenome']").focus();
    } else if (usuario === "") {
        $('#resultado').html("O campo login é obrigatório!");
        $("input[name='login']").focus();
    } else if (perfil === "") {
        $('#resultadoPerfil').html("Selecione um perfil!");
        $("select[name='tipo']").focus();
    } else {
        var usuarioCount = $("input[name='login']").val().length;
        if (usuarioCount < 4 && usuarioCount > 0) {
            $('#resultado').html("O login deve possuir no mínimo 4 números, você digitou apenas " + usuarioCount);
            $("input[name='login']").focus().select();
            $("input[name='login']").removeClass("form-control");
            $("input[name='login']").removeClass("form-control is-valid");
            $("input[name='login']").addClass("form-control is-invalid");
        } else {
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
                        $('#formUsuario').submit();
                    }
                });
            } else {
                $('#resultado').html("");
                $("input[name='login']").removeClass("form-control is-invalid");
                $("input[name='login']").addClass("form-control is-valid");
                $('#formUsuario').submit();
            }
        }
    }
}

//função para botao alterar senha do usuario
function alterarSenha() {
    var senha = $("input[name='senha']").val();
    var confirmar = $("input[name='confirmar']").val();

    if (senha === "") {
        if ($('#senhas').text() !== "As senhas não conferem!") {
            $('#senhas').html("O campo senha é obrigatório!");
        }
        $("input[name='senha']").focus();
    } else if (confirmar === "") {
        $('#resultadoConfirmar').html("O campo confirmar senha é obrigatório!");
        $("input[name='confirmar']").focus();
    } else {
        $('#senhas').html("");
        $('#resultadoConfirmar').html("");
        $("input[name='senha']").removeClass("form-control is-invalid");
        $("input[name='senha']").addClass("form-control is-valid");
        $("input[name='confirmar']").removeClass("form-control is-invalid");
        $("input[name='confirmar']").addClass("form-control is-valid");
        $("#formAlteraSenha").submit();
    }

}

//função para botao salvar fila
function salvarFila() {
    var nome = $("input[name='nome']").val();
    if (nome === "") {
        $('#resultado').html("O campo nome é obrigatório!");
        $("input[name='nome']").focus();
    } else {
        if (nome !== nomeGlobal) {
            $.post('../../verificaUsuario/6ea13bffb6e18ece1265286ee9203fa0.php', {nome: nome}, function (data) {
                if (data !== "Não existe!") {
                    $('#resultado').html(data);
                    $("input[name='nome']").focus().select();
                    $("input[name='nome']").removeClass("form-control");
                    $("input[name='nome']").addClass("form-control is-invalid");
                } else {
                    $('#resultado').html("");
                    $("input[name='nome']").removeClass("form-control is-invalid");
                    $("input[name='nome']").addClass("form-control is-valid");
                    $('#formFila').submit();
                }
            });
        } else {
            $('#resultado').html("");
            $("input[name='nome']").removeClass("form-control is-invalid");
            $("input[name='nome']").addClass("form-control is-valid");
            $('#formFila').submit();
        }
    }
}

//funcao complicada de entender para botao salvar servico ifs aninhados
function salvarServico() {
    var sigla = $("input[name='sigla']").val();
    var nome = $("input[name='nome']").val();

    if (sigla === "") {
        $('#resultado').html("O campo sigla é obrigatório!");
        $("input[name='sigla']").focus();
    } else {
        if (sigla !== siglaGlobal) {
            $.post('../../verificaUsuario/07cec372873365e1192cfc1fe6b94e56.php', {sigla: sigla}, function (data) {
                if (data !== "Não existe!") {
                    $('#resultado').html(data);
                    $("input[name='sigla']").focus().select();
                    $("input[name='sigla']").removeClass("form-control");
                    $("input[name='sigla']").addClass("form-control is-invalid");
                } else {
                    $('#resultado').html("");
                    $("input[name='sigla']").removeClass("form-control is-invalid");
                    $("input[name='sigla']").addClass("form-control is-valid");


//                    caso a sigla não esteja em uso confere o nome para entao autorizar o submit INICIO


                    if (nome === "") {
                        $('#resultado2').html("O campo nome é obrigatório!");
                        $("input[name='nome']").focus();
                    } else {
                        if (nome !== nomeGlobal) {
                            $.post('../../verificaUsuario/07cec372873365e1192cfc1fe6b94e56.php', {nome: nome}, function (data) {
                                if (data !== "Não existe!") {
                                    $('#resultado2').html(data);
                                    $("input[name='nome']").focus().select();
                                    $("input[name='nome']").removeClass("form-control");
                                    $("input[name='nome']").addClass("form-control is-invalid");
                                } else {
                                    $('#resultado2').html("");
                                    $("input[name='nome']").removeClass("form-control is-invalid");
                                    $("input[name='nome']").addClass("form-control is-valid");
                                    $('#formServico').submit();
                                }
                            });
                        } else {
                            $('#resultado2').html("");
                            $("input[name='nome']").removeClass("form-control is-invalid");
                            $("input[name='nome']").removeClass("form-control is-valid");
                            $("input[name='nome']").addClass("form-control");
                            $('#formServico').submit();
                        }

                    }


//                    FIM do else $post


                }
            });
        } else {
            $('#resultado').html("");
            $("input[name='sigla']").removeClass("form-control is-invalid");
            $("input[name='sigla']").removeClass("form-control is-valid");
            $("input[name='sigla']").addClass("form-control");


//            caso a sigla não tenha sido alterada mantem os campos limpos e verifica o nome para assim autorizar submit
//            INICIO


            if (nome === "") {
                $('#resultado2').html("O campo nome é obrigatório!");
                $("input[name='nome']").focus();
            } else {
                if (nome !== nomeGlobal) {
                    $.post('../../verificaUsuario/07cec372873365e1192cfc1fe6b94e56.php', {nome: nome}, function (data) {
                        if (data !== "Não existe!") {
                            $('#resultado2').html(data);
                            $("input[name='nome']").focus().select();
                            $("input[name='nome']").removeClass("form-control");
                            $("input[name='nome']").addClass("form-control is-invalid");
                        } else {
                            $('#resultado2').html("");
                            $("input[name='nome']").removeClass("form-control is-invalid");
                            $("input[name='nome']").addClass("form-control is-valid");
                            $('#formServico').submit();
                        }
                    });
                } else {
                    $('#resultado2').html("");
                    $("input[name='nome']").removeClass("form-control is-invalid");
                    $("input[name='nome']").removeClass("form-control is-valid");
                    $("input[name='nome']").addClass("form-control");
                    $('#formServico').submit();
                }

            }


//            FIM do else varivel sigla igual a global


        }
    } //fim do 1º else
} //fim da função salvarServico


//funcao para nao aceitar submit com tecla enter
function EnterKeyFilter()
{
    if (window.event.keyCode === 13)
    {
        event.returnValue = false;
        event.cancel = true;
    }
}

//funcao para imprimir senha
function imprimir() {
    var conteudo = document.getElementById('imprimeSenha').innerHTML,
            tela_impressao = window.open('about:blank');

    tela_impressao.document.write(conteudo);
    tela_impressao.window.print();
    tela_impressao.window.close();

}

//funcao para imprimir relatorio
function imprimirRelatorio() {
    var conteudo = document.getElementById('imprimirRelatorio').innerHTML,
            tela_impressao = window.open('about:blank');

    tela_impressao.document.write(conteudo);
    tela_impressao.window.print();
    tela_impressao.window.close();

}

//função para chamar e atender senha
function chamarSenha() {
    $("#chamarSenha").submit();
}

//ajax para atualizar senhas na tela de atendimento
function updateSenha(idFila) {
    $.post("../../verificaUsuario/senhas.php", {idFila: idFila}, function (data) {
        if (data === "NULL") {
            $("#botao").hide();
            $("#senhaAtendimento").html('<div class="alert alert-primary text-center" role="alert" style="margin: 50px 0 50px 0;">' +
                    'Não há senhas aguardando atendimento!' +
                    '</div>');
        } else {
            $("#botao").show();
            $("#senhaAtendimento").html('<div class="row" style="margin-top: 20px;" >' +
                    '<div class="col-2">' +
                    '<label><b class="h5">Senha:</b></label><br/>' +
                    '<label><b class="h5">Serviço:</b></label><br/>' +
                    '<label><b class="h5">Prioridade:</b></label><br/>' +
                    '<label><b class="h5">Identificação:</b></label>' +
                    '</div>' +
                    '<div class="col">' +
                    '<label style="margin-top: -10px;"><b class="h2" id="senhaNumero"></b></label><br/>' +
                    '<label id="senhaNome"></label><br/>' +
                    '<label id="senhaPreferencia"></label><br/>' +
                    '<label id="senhaIdentificacao"></label>' +
                    '</div>' +
                    '</div>');

            var senha = JSON.parse(data);
            $("#npessoas").html(senha.npessoas);
            $("#senhaNumero").html(senha.sigla + senha.numero);
            $("#senhaNome").html(senha.nomeServico);
            $("#senhaPreferencia").html(senha.preferencia);
            $("#senhaIdentificacao").html(senha.identificacao);

            $("#idSenha").val(senha.id);
            $("#sigla").val(senha.sigla);
            $("#numero").val(senha.numero);
            if (senha.preferencia === "Preferencial") {
                $("#senhaAtendimento").css("color", "red");
            }
        }

    });
    setTimeout("updateSenha(" + idFila + ")", 1000);
}

//fechar mensagens de alerta
function fechar() {
    $("#mensagem").hide();
}

//buscar serviços com ajax pagina de relatorios por serviços
function buscarServicos(idFila) {
    $.post("../../verificaUsuario/servicos.php", {idFila: idFila}, function (data) {
        if (data === "NULL") {
            $("#servicos option").remove();
            $("#servicos").append('<option value=""></option>');
            $("#servicos").prop("disabled", true);
        } else {
            var servicos = JSON.parse(data);
            $('#servicos option').remove();
            $("#servicos").append('<option value="">Selecionar</option>');
            $("#servicos").prop("disabled", false);
            servicos.forEach(function (item) {
                $("#servicos").append('<option value="' + item.id + '">' + item.nomeServico + '</option>');
            });
        }
    });
}

//botao alterar Senha
function AlterarSenha() {
    $(document).ready(function () {
        $('#AlterarSenha').modal('show');
    });
}

//botao voltar para o serviço
$("#voltarServico").click(function () {
    $("#enviaID").submit();
});

//funcao para botoes voltar nos cadastros
function voltar(url) {
    window.location.href = url;
}

//funcao para botoes novo usuario/fila/serviço
function novo(url) {
    window.location.href = url;
}

//funcao para confirmar exclusao
function confirmar(id) {
    $(document).ready(function () {
        $('#ModalCenter').modal('show');
    });

    $("#sim").click(function () {
        $("input[name='id']").val(id);
        $("#enviaDelete").submit();
    });
}
//confirmar exclusao do servico
function confirmarServico(id, idFila) {
    $(document).ready(function () {
        $('#ModalCenter').modal('show');
    });

    $("#sim").click(function () {
        $("input[name='id']").val(id);
        $("input[name='idFila']").val(idFila);
        $("#enviaDelete").submit();
    });
}
