<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

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
            $entityManager = $this->getDoctrine()->getRepository(\AppBundle\Entity\Usuario::class);
            $usuario = $entityManager->findOneBy(array("usuario" => $login, "senha" => $senha));
            if ($usuario != null) {
                $this->iniciaSessao($login, $usuario);
                return $this->render("Usuario/inicio.html.twig", array(
                            'nome' => $_SESSION['nome'],
                ));
            } else {
                return $this->redirectToRoute("Login");
            }
        }
    }

    public function iniciaSessao($login, $usuario) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
            $_SESSION['login'] = $login;
            $_SESSION['nome'] = $usuario->getNome() . " " . $usuario->getSobrenome();
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
            $entityManager = $this->getDoctrine()->getRepository(\AppBundle\Entity\Usuario::class);
            $verifica = $entityManager->findByUsuario($login);
            if($verifica == null){
            
            $usuario = new \AppBundle\Entity\Usuario();
            $usuario->setNome($nome);
            $usuario->setSobrenome($sobrenome);
            $usuario->setUsuario($login);
            $usuario->setSenha($senha);
            $usuario->setStatus($status);
            $usuario->setTipo($tipo);
            
            $em->persist($usuario);
            $em->flush();
            
            $usuarios = $entityManager->findAll();
            $msg = "Usuário cadastrado com sucesso!";
            
            return $this->render("Usuario/usuarios.html.twig", array(
                "mensagem" => $msg,
                "nome" => $_SESSION['nome'],
                "usuarios" => $usuarios,
            ));
            
            }else{
                $msg = "Já existe um usuário utilizando este login!";
                return $this->render("Usuario/cadastrar.html.twig", array(
                    "mensagem" => $msg,
                    "nome" => $_SESSION['nome'],
                ));
            }
            
        }
    }
    
    /**
     * @Route ("/usuarios", name="Usuarios")
     */
    public function show(){
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $entityManage = $this->getDoctrine()->getRepository(\AppBundle\Entity\Usuario::class);
            $usuarios = $entityManage->findAll();
            return $this->render("Usuario/usuarios.html.twig", array(
                "nome" => $_SESSION['nome'],
                "usuarios" => $usuarios,
            ));
        }
    }
    
}
