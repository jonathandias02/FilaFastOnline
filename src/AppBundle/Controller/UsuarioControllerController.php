<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Usuario;

class UsuarioControllerController extends Controller {

    /**
     * @Route ("/", name="Login")
     */
    public function login() {
        if (isset($_SESSION['login'])) {
            return $this->render("Usuario/inicio.html.twig", array(
                        'nome' => $_SESSION['nome'],
                        'perfil' => $_SESSION['direitos'],
            ));
        } else {
            return $this->render("Usuario/login.html.twig");
        }
    }

    /**
     * @Route ("/home", name="Home")
     */
    public function entrar() {
        if (isset($_SESSION['login'])) {
            return $this->render("Usuario/inicio.html.twig", array(
                        'nome' => $_SESSION['nome'],
                        'perfil' => $_SESSION['direitos'],
            ));
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $login = isset($filtro['login']) ? $filtro['login'] : null;
            $senha = isset($filtro['senha']) ? md5($filtro['senha']) : null;
            $entityManager = $this->getDoctrine()->getRepository(Usuario::class);
            $usuario = $entityManager->findOneBy(array("usuario" => $login, "senha" => $senha));
            if ($usuario != null && $usuario->getDeletar() == 0) {
                if ($usuario->getStatus_2() === "Ativo") {
                    $this->iniciaSessao($login, $usuario);
                    return $this->render("Usuario/inicio.html.twig", array(
                                'nome' => $_SESSION['nome'],
                                'perfil' => $_SESSION['direitos'],
                    ));
                } else {
                    $msg = "Este usuário foi desativado, procure um administrador!";
                    return $this->render("Usuario/login.html.twig", array(
                                "mensagem" => $msg,
                    ));
                }
            } else {
                $msg = "Usuário e/ou senha invalido(s)!";
                return $this->render("Usuario/login.html.twig", array(
                            "mensagem" => $msg,
                ));
            }
        }
    }

    public function iniciaSessao($login, $usuario) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
            $_SESSION['login'] = $login;
            $_SESSION['nome'] = $usuario->getNome() . " " . $usuario->getSobrenome();
            $_SESSION['direitos'] = $usuario->getTipo();
            $_SESSION['id'] = $usuario->getId();
            $_SESSION['data'] = $usuario->getCreateAt();
        }
    }

    /**
     * @Route ("/sair", name="Sair")
     */
    public function logout() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            unset($_SESSION['login']);
            unset($_SESSION['nome']);
            unset($_SESSION['id']);
            unset($_SESSION['direitos']);
            unset($_SESSION['data']);
            session_destroy();
            return $this->redirectToRoute('Login');
        } else {
            return $this->redirectToRoute('Login');
        }
    }

    /**
     * @Route ("/cadastroUsuario", name="CadastroUsuario")
     */
    public function novo() {
        if (!isset($_SESSION['login']) || $_SESSION['direitos'] != 1) {
            return $this->redirectToRoute("Login");
        } else {
            return $this->render("Usuario/cadastrar.html.twig", array(
                        'nome' => $_SESSION['nome'],
                        'perfil' => $_SESSION['direitos'],
            ));
        }
    }

    /**
     * @Route ("/salvarUsuario", name="SalvarUsuario")
     */
    public function salvar() {
        if (!isset($_SESSION['login']) || $_SESSION['direitos'] != 1) {
            return $this->redirectToRoute("Login");
        } else {
            $em = $this->getDoctrine()->getManager();
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $nome = isset($filtro['nome']) ? $filtro['nome'] : null;
            $sobrenome = isset($filtro['sobrenome']) ? $filtro['sobrenome'] : null;
            $login = isset($filtro['login']) ? $filtro['login'] : null;
            $senha = isset($filtro['senha']) ? md5($filtro['senha']) : null;
            $status = isset($filtro['status']) ? $filtro['status'] : null;
            $tipo = isset($filtro['tipo']) ? $filtro['tipo'] : null;
            $teste = $this->getDoctrine()->getRepository(Usuario::class)->findOneBy(["deletar" => 0], ["id" => "DESC"], 1);
            if ($teste->getUsuario() == $login) {
                return $this->redirectToRoute("Usuarios");
            } else {
                $usuario = new Usuario();
                $usuario->setNome($nome);
                $usuario->setSobrenome($sobrenome);
                $usuario->setUsuario($login);
                $usuario->setSenha($senha);
                $usuario->setStatus_2($status);
                $usuario->setTipo($tipo);
                $em->persist($usuario);
                $em->flush();
                $msg = "Usuário cadastrado com sucesso!";
                $entityManage = $this->getDoctrine()->getRepository(Usuario::class);
                $usuarios = $entityManage->findBy(["deletar" => 0], ["createAt" => "DESC"], 6);
                return $this->render("Usuario/usuarios.html.twig", array(
                            "mensagem" => $msg,
                            "nome" => $_SESSION['nome'],
                            "login" => $_SESSION['login'],
                            'perfil' => $_SESSION['direitos'],
                            "usuarios" => $usuarios,
                ));
            }
        }
    }

    /**
     * @Route ("/usuarios", name="Usuarios")
     */
    public function show() {
        if (!isset($_SESSION['login']) || $_SESSION['direitos'] != 1) {
            return $this->redirectToRoute("Login");
        } else {
            $entityManage = $this->getDoctrine()->getRepository(Usuario::class);
            $usuarios = $entityManage->findBy(["deletar" => 0], ["createAt" => "DESC"], 6);
            return $this->render("Usuario/usuarios.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        "login" => $_SESSION['login'],
                        'perfil' => $_SESSION['direitos'],
                        "usuarios" => $usuarios,
            ));
        }
    }

    /**
     * @Route ("/buscarUsuario", name="BuscarUsuario")
     */
    public function buscar() {
        if (!isset($_SESSION['login']) || $_SESSION['direitos'] != 1) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $busca = isset($filtro['busca']) ? "%" . $filtro['busca'] . "%" : null;
            $busca2 = isset($filtro['busca']) ? $filtro['busca'] : null;
            $pesquisa = null;
            $entityManage = $this->getDoctrine()->getRepository(Usuario::class);

            if ($busca != null) {
                $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->buscarUsuario($busca, $busca2);
                if ($usuarios == null)
                    $pesquisa = "não encontrado";
                return $this->render("Usuario/usuarios.html.twig", array(
                            "nome" => $_SESSION['nome'],
                            "login" => $_SESSION['login'],
                            'perfil' => $_SESSION['direitos'],
                            "usuarios" => $usuarios,
                            "pesquisa" => $pesquisa,
                ));
            } else {
                $usuarios = $entityManage->findBy(["deletar" => 0]);
                if ($usuarios == null)
                    $pesquisa = "não encontrado";
                return $this->render("Usuario/usuarios.html.twig", array(
                            "nome" => $_SESSION['nome'],
                            "login" => $_SESSION['login'],
                            'perfil' => $_SESSION['direitos'],
                            "usuarios" => $usuarios,
                            "pesquisa" => $pesquisa,
                ));
            }
        }
    }

    /**
     * @Route ("/alterarUsuario", name="AlterarUsuario")
     */
    public function alterar() {
        if (!isset($_SESSION['login']) || $_SESSION['direitos'] != 1) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $entityManage = $this->getDoctrine()->getRepository(Usuario::class);
            $usuario = $entityManage->findOneBy(["id" => $id, "deletar" => 0]);
            $direito = $entityManage->direitos($usuario->getTipo());

            return $this->render("Usuario/alterar.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        'perfil' => $_SESSION['direitos'],
                        "usuario" => $usuario,
                        "direito" => $direito,
            ));
        }
    }

    /**
     * @Route ("/salvarAlteracaoUsuario", name="SalvarAlteracaoUsuario")
     */
    public function salvarAlteracao() {
        if (!isset($_SESSION['login']) || $_SESSION['direitos'] != 1) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $nome = isset($filtro['nome']) ? $filtro['nome'] : null;
            $sobrenome = isset($filtro['sobrenome']) ? $filtro['sobrenome'] : null;
            $login = isset($filtro['login']) ? $filtro['login'] : null;
            $status = isset($filtro['status']) ? $filtro['status'] : null;
            $tipo = isset($filtro['tipo']) ? $filtro['tipo'] : null;

            $alteracao = $this->getDoctrine()->getRepository(Usuario::class);
            $alteracao->alterarUsuario($id, $nome, $sobrenome, $login, $status, $tipo);
            $usuario = $this->getDoctrine()->getRepository(Usuario::class)->findOneBy(["id" => $id, "deletar" => 0]);
            $direito = $this->getDoctrine()->getRepository(Usuario::class)->direitos($usuario->getTipo());
            if ($alteracao) {
                $msg = "Alterado com sucesso!";
            } else {
                $msg = "Não foi possivel alterar!";
            }

            return $this->render("Usuario/alterar.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        'perfil' => $_SESSION['direitos'],
                        "mensagem" => $msg,
                        "usuario" => $usuario,
                        "direito" => $direito,
            ));
        }
    }

    /**
     * @Route ("/alterarPerfil", name="AlterarPerfil")
     */
    public function alterarPerfil() {
        if (!isset($_SESSION['login']) || $_SESSION['direitos'] !== 1) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $entityManage = $this->getDoctrine()->getRepository(Usuario::class);
            $usuario = $entityManage->findOneBy(["id" => $id, "deletar" => 0]);
            $direito = $entityManage->direitos($usuario->getTipo());

            return $this->render("Usuario/alterarPerfil.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        'perfil' => $_SESSION['direitos'],
                        "usuario" => $usuario,
                        "direito" => $direito,
            ));
        }
    }

    /**
     * @Route ("/salvarPerfil", name="SalvarPerfil")
     */
    public function salvarPerfil() {
        if (!isset($_SESSION['login']) || $_SESSION['direitos'] !== 1) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $nome = isset($filtro['nome']) ? $filtro['nome'] : null;
            $sobrenome = isset($filtro['sobrenome']) ? $filtro['sobrenome'] : null;
            $login = isset($filtro['login']) ? $filtro['login'] : null;

            $alteracao = $this->getDoctrine()->getRepository(Usuario::class);
            $alteracao->alterarPerfil($id, $nome, $sobrenome, $login);
            $usuario = $this->getDoctrine()->getRepository(Usuario::class)->findOneBy(["id" => $id, "deletar" => 0]);
            $_SESSION['id'] = $usuario->getId();
            $_SESSION['login'] = $usuario->getUsuario();
            $_SESSION['nome'] = $usuario->getNome() . " " . $usuario->getSobrenome();
            $direito = $this->getDoctrine()->getRepository(Usuario::class)->direitos($usuario->getTipo());
            $msg = "Alterado com sucesso!";

            return $this->render("Usuario/alterarPerfil.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        'perfil' => $_SESSION['direitos'],
                        "mensagem" => $msg,
                        "usuario" => $usuario,
                        "direito" => $direito,
            ));
        }
    }

    /**
     * @Route ("/alterarSenha", name="AlterarSenha")
     */
    public function alterarSenha() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $senha = isset($filtro['senha']) ? md5($filtro['senha']) : null;
            $senhaAtual = isset($filtro['senhaAtual']) ? md5($filtro['senhaAtual']) : null;
            if ($senhaAtual != null) {
                $teste = $this->getDoctrine()->getRepository(Usuario::class)->findOneBy(["id" => $id, "deletar" => 0, "senha" => $senhaAtual]);
                if ($teste == null) {
                    $msg = "Senha atual incorreta!";
                } else {
                    $this->getDoctrine()->getRepository(Usuario::class)->alterarSenha($id, $senha);
                    $msg = "Senha alterada com sucesso!";
                }
                return $this->render("Usuario/perfil.html.twig", array(
                            "nome" => $_SESSION['nome'],
                            "mensagem" => $msg,
                            "login" => $_SESSION['login'],
                            "nome" => $_SESSION['nome'],
                            "perfil" => $_SESSION['direitos'],
                            "data" => $_SESSION['data'],
                            "idUsuario" => $_SESSION['id'],
                ));
            } else {
                $this->getDoctrine()->getRepository(Usuario::class)->alterarSenha($id, $senha);
                $usuario = $this->getDoctrine()->getRepository(Usuario::class)->findOneBy(["id" => $id, "deletar" => 0]);
                $direito = $this->getDoctrine()->getRepository(Usuario::class)->direitos($usuario->getTipo());
                $msg = "Senha alterada com sucesso!";
                return $this->render("Usuario/alterar.html.twig", array(
                            "nome" => $_SESSION['nome'],
                            'perfil' => $_SESSION['direitos'],
                            "mensagem" => $msg,
                            "usuario" => $usuario,
                            "direito" => $direito,
                ));
            }
        }
    }

    /**
     * @Route ("/deletarUsuario", name="DeletarUsuario")
     */
    public function delete() {

        if (!isset($_SESSION['login']) || $_SESSION['direitos'] != 1) {
            return $this->redirectToRoute("Login");
        } else {

            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $entityManage = $this->getDoctrine()->getRepository(Usuario::class);
            $teste = $entityManage->findOneBy(["id" => $id, "deletar" => 0]);
            if ($teste != null) {
                $entityManage->deletarUsuario($id);
                $usuarios = $entityManage->findBy(["deletar" => 0], ["createAt" => "DESC"], 6);
                $msg = "Usuário deletado com sucesso!";
                return $this->render("Usuario/usuarios.html.twig", array(
                            "nome" => $_SESSION['nome'],
                            "login" => $_SESSION['login'],
                            'perfil' => $_SESSION['direitos'],
                            "usuarios" => $usuarios,
                            "mensagem" => $msg,
                ));
            } else {
                return $this->redirectToRoute("Usuarios");
            }
        }
    }

    /**
     * @Route ("/perfil", name="Perfil")
     */
    public function perfil() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            return $this->render("Usuario/perfil.html.twig", array(
                        "login" => $_SESSION['login'],
                        "nome" => $_SESSION['nome'],
                        "perfil" => $_SESSION['direitos'],
                        "data" => $_SESSION['data'],
                        "idUsuario" => $_SESSION['id'],
            ));
        }
    }

}
