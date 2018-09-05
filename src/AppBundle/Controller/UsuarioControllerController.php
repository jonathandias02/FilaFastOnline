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
            ));
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $login = isset($filtro['login']) ? $filtro['login'] : null;
            $senha = isset($filtro['senha']) ? md5($filtro['senha']) : null;
            $entityManager = $this->getDoctrine()->getRepository(Usuario::class);
            $usuario = $entityManager->findOneBy(array("usuario" => $login, "senha" => $senha));
            if ($usuario != null) {
                if ($usuario->getStatus_2() === "Ativo") {
                    $this->iniciaSessao($login, $usuario);
                    return $this->render("Usuario/inicio.html.twig", array(
                                'nome' => $_SESSION['nome'],
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
        }
    }

    /**
     * @Route ("/sair", name="Sair")
     */
    public function logout() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            unset($_SESSION['login']);
            unset($_SESSION['nome']);
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
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            return $this->render("Usuario/cadastrar.html.twig", array(
                        'nome' => $_SESSION['nome'],
            ));
        }
    }

    /**
     * @Route ("/salvarUsuario", name="SalvarUsuario")
     */
    public function salvar() {
        if (!isset($_SESSION['login'])) {
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
            return $this->render("Usuario/cadastrar.html.twig", array(
                        "mensagem" => $msg,
                        "nome" => $_SESSION['nome'],
            ));
        }
    }

    /**
     * @Route ("/usuarios", name="Usuarios")
     */
    public function show() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $entityManage = $this->getDoctrine()->getRepository(Usuario::class);
            $usuarios = $entityManage->findBy([], ["createAt" => "DESC"], 6);
            return $this->render("Usuario/usuarios.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        "usuarios" => $usuarios,
            ));
        }
    }

    /**
     * @Route ("/buscarUsuario", name="BuscarUsuario")
     */
    public function buscar() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $busca = isset($filtro['busca']) ? $filtro['busca'] : null;
            $entityManage = $this->getDoctrine()->getRepository(Usuario::class);

            if ($busca != null) {
                $usuarios = $this->getDoctrine()->getRepository(Usuario::class)->buscarUsuario($busca);
                return $this->render("Usuario/usuarios.html.twig", array(
                            "nome" => $_SESSION['nome'],
                            "usuarios" => $usuarios,
                ));
            } else {
                $usuarios = $entityManage->findAll();
                return $this->render("Usuario/usuarios.html.twig", array(
                            "nome" => $_SESSION['nome'],
                            "usuarios" => $usuarios,
                ));
            }
        }
    }
    
    /**
     * @Route ("/alterarUsuario", name="AlterarUsuario")
     */
    public function alterar(){
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $entityManage = $this->getDoctrine()->getRepository(Usuario::class);
            $usuario = $entityManage->findOneBy(["id" => $id]);
            $direito = $entityManage->direitos($usuario->getTipo());
            
            return $this->render("Usuario/alterar.html.twig", array(
                "nome" => $_SESSION['nome'],
                "usuario" => $usuario,
                "direito" => $direito,
            ));
            
        }
    }

    /**
     * @Route ("/deletarUsuario", name="DeletarUsuario")
     */
    public function delete() {

        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $entityManage = $this->getDoctrine()->getRepository(Usuario::class);
            $deletar = $entityManage->deletarUsuario($id);
            $usuarios = $entityManage->findBy([], ["createAt" => "DESC"], 6);
            if($deletar){
                $msg = "Usuário deletado com sucesso!";
            }else{
                $msg = "Não foi possivel deletar usuário!";
            }
            return $this->render("Usuario/usuarios.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        "usuarios" => $usuarios,
                        "mensagem" => $msg,
            ));
            
        }
    }

}
