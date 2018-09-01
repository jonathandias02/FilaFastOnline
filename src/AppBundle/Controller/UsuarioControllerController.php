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
     * @Route ("/entrar", name="Entrar")
     */
    public function entrar() {
        if (isset($_SESSION['login'])) {
            return $this->render("Usuario/inicio.html.twig", array(
                        'nome' => $_SESSION['nome'],
            ));
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $login = isset($filtro['login']) ? $filtro['login'] : null;
            $senha = isset($filtro['senha']) ? $filtro['senha'] : null;
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
        }else{
            return $this->redirectToRoute('Login');
        }
    }

}
