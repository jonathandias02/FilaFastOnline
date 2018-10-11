<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Fila;

class FilaControllerController extends Controller {

    /**
     * @Route ("/filas", name="Filas")
     */
    public function filas() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $entityManage = $this->getDoctrine()->getRepository(Fila::class);
            $filas = $entityManage->findBy(["deletar" => 0], ["createAt" => "DESC"], 5);
            return $this->render("Fila/filas.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        "filas" => $filas,
            ));
        }
    }

    /**
     * @Route ("/cadastroFila", name="CadastroFila")
     */
    public function nova() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            return $this->render("Fila/cadastrar.html.twig", array(
                        'nome' => $_SESSION['nome'],
                        'id' => $_SESSION['id'],
            ));
        }
    }

    /**
     * @Route ("/salvarFila", name="SalvarFila")
     */
    public function salvar() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $em = $this->getDoctrine()->getManager();
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $nome = isset($filtro['nome']) ? $filtro['nome'] : null;
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $status = isset($filtro['status']) ? $filtro['status'] : null;
            $entityManage = $this->getDoctrine()->getRepository(Fila::class);
            $teste = $entityManage->findOneBy(["deletar" => 0], ["id" => "DESC"], 1);
            if ($teste->getNome() == $nome) {
                return $this->redirectToRoute("Filas");
            } else {
                $fila = new Fila();
                $fila->setNome($nome);
                $fila->setIdUsuario($id);
                $fila->setStatus_2($status);
                $em->persist($fila);
                $em->flush();
                $msg = "Fila cadastrada com sucesso!";
                $filas = $entityManage->findBy(["deletar" => 0], ["createAt" => "DESC"], 5);
                return $this->render("Fila/filas.html.twig", array(
                            "mensagem" => $msg,
                            "nome" => $_SESSION['nome'],
                            "filas" => $filas,
                ));
            }
        }
    }

    /**
     * @Route ("/buscarFila", name="BuscarFila")
     */
    public function buscar() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $busca = isset($filtro['busca']) ? "%" . $filtro['busca'] . "%" : null;
            $busca2 = isset($filtro['busca']) ? $filtro['busca'] : null;
            $entityManage = $this->getDoctrine()->getRepository(Fila::class);

            if ($busca != null) {
                $filas = $this->getDoctrine()->getRepository(Fila::class)->buscarFila($busca, $busca2);
                return $this->render("Fila/filas.html.twig", array(
                            "nome" => $_SESSION['nome'],
                            "filas" => $filas,
                ));
            } else {
                $filas = $entityManage->findBy(["deletar" => 0]);
                return $this->render("Fila/filas.html.twig", array(
                            "nome" => $_SESSION['nome'],
                            "filas" => $filas,
                ));
            }
        }
    }

    /**
     * @Route ("/alterarFila", name="AlterarFila")
     */
    public function alterar() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $entityManage = $this->getDoctrine()->getRepository(Fila::class);
            $fila = $entityManage->findOneBy(["id" => $id, "deletar" => 0]);

            return $this->render("Fila/alterar.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        "fila" => $fila,
            ));
        }
    }

    /**
     * @Route ("/salvarAlteracaoFila", name="SalvarAlteracaoFila")
     */
    public function salvarAlteracao() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $nome = isset($filtro['nome']) ? $filtro['nome'] : null;
            $status = isset($filtro['status']) ? $filtro['status'] : null;

            $alteracao = $this->getDoctrine()->getRepository(Fila::class);
            $alteracao->alterarFila($id, $nome, $status);
            $fila = $this->getDoctrine()->getRepository(Fila::class)->findOneBy(["id" => $id, "deletar" => 0]);
            if ($alteracao) {
                $msg = "Alterado com sucesso!";
            } else {
                $msg = "Não foi possivel alterar!";
            }

            return $this->render("Fila/alterar.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        "mensagem" => $msg,
                        "fila" => $fila,
            ));
        }
    }

    /**
     * @Route ("/visualizafila", name="VisualizaFila")
     */
    public function exibefila() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $entityManage = $this->getDoctrine()->getRepository(Fila::class);
            $fila = $entityManage->findOneBy(["deletar" => 0, "id" => $id]);
            $servicos = $this->getDoctrine()->getRepository(\AppBundle\Entity\Servico::class)->findBy(["idFila" => $fila->getId(), "deletar" => 0], [], 10);
            return $this->render("Fila/exibefila.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        "fila" => $fila,
                        "servicos" => $servicos,
            ));
        }
    }

    /**
     * @Route ("/deletarFila", name="DeletarFila")
     */
    public function delete() {

        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {

            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $entityManage = $this->getDoctrine()->getRepository(Fila::class);
            $teste = $entityManage->findOneBy(["id" => $id, "deletar" => 0]);
            if ($teste != null) {
                $entityManage->deletarFila($id);
                $filas = $entityManage->findBy(["deletar" => 0], ["createAt" => "DESC"], 5);
                $msg = "Fila deletada com sucesso!";
                return $this->render("Fila/filas.html.twig", array(
                            "nome" => $_SESSION['nome'],
                            "login" => $_SESSION['login'],
                            "filas" => $filas,
                            "mensagem" => $msg,
                ));
            } else {
                return $this->redirectToRoute("Filas");
            }
        }
    }

}
