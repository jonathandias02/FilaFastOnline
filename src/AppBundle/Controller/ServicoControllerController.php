<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Servico;

class ServicoControllerController extends Controller {

    /**
     * @Route ("/cadastroServico", name="CadastroServico")
     */
    public function nova() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $idFila = isset($filtro['idFila']) ? $filtro['idFila'] : null;
            return $this->render("Servico/cadastrar.html.twig", array(
                        'nome' => $_SESSION['nome'],
                        'idUsuario' => $_SESSION['id'],
                        'idFila' => $idFila,
            ));
        }
    }

    /**
     * @Route ("/salvarServico", name="SalvarServico")
     */
    public function salvar() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $em = $this->getDoctrine()->getManager();
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $nome = isset($filtro['nome']) ? $filtro['nome'] : null;
            $idUsuario = isset($filtro['id']) ? $filtro['id'] : null;
            $idFila = isset($filtro['idFila']) ? $filtro['idFila'] : null;
            $sigla = isset($filtro['sigla']) ? $filtro['sigla'] : null;
            $descricao = isset($filtro['descricao']) ? $filtro['descricao'] : null;
            $status = isset($filtro['status']) ? $filtro['status'] : null;
            $servico = new Servico();
            $servico->setNome($nome);
            $servico->setIdUsuario($idUsuario);
            $servico->setIdFila($idFila);
            $servico->setSigla($sigla);
            $servico->setStatus_2($status);
            $servico->setDescricao($descricao);
            $em->persist($servico);
            $em->flush();
            $msg = "Serviço cadastrado com sucesso!";
            return $this->render("Servico/cadastrar.html.twig", array(
                        "mensagem" => $msg,
                        "nome" => $_SESSION['nome'],
                        "idFila" => $idFila,
            ));
        }
    }

    /**
     * @Route ("/buscarServico", name="BuscarServico")
     */
    public function buscar() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $busca = isset($filtro['busca']) ? "%" . $filtro['busca'] . "%" : null;
            $busca2 = isset($filtro['busca']) ? $filtro['busca'] : null;
            $idFila = isset($filtro['idFila']) ? $filtro['idFila'] : null;
            $entityManage = $this->getDoctrine()->getRepository(Servico::class);
            $fila = $this->getDoctrine()->getRepository(\AppBundle\Entity\Fila::class)->findOneBy(["id" => $idFila]); 

            if ($busca != "%%") {
                $servicos = $this->getDoctrine()->getRepository(Servico::class)->buscarServico($busca, $busca2, $idFila);
                return $this->render("Fila/exibefila.html.twig", array(
                            "nome" => $_SESSION['nome'],
                            "servicos" => $servicos,
                            "fila" => $fila,
                ));
            } else {
                $servicos = $entityManage->findBy(["idFila" => $idFila, "deletar" => 0]);
                return $this->render("Fila/exibefila.html.twig", array(
                            "nome" => $_SESSION['nome'],
                            "servicos" => $servicos,
                            "fila" => $fila,
                ));
            }
        }
    }

    /**
     * @Route ("/alterarServico", name="AlterarServico")
     */
    public function alterar() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $entityManage = $this->getDoctrine()->getRepository(Servico::class);
            $servico = $entityManage->findOneBy(["id" => $id, "deletar" => 0]);
            $idFila = $servico->getIdFila();

            return $this->render("Servico/alterar.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        "servico" => $servico,
                        "idFila" => $idFila,
            ));
        }
    }

    /**
     * @Route ("/salvarAlteracaoServico", name="SalvarAlteracaoServico")
     */
    public function salvarAlteracao() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $sigla = isset($filtro['sigla']) ? $filtro['sigla'] : null;
            $nome = isset($filtro['nome']) ? $filtro['nome'] : null;
            $descricao = isset($filtro['descricao']) ? $filtro['descricao'] : null;
            $status = isset($filtro['status']) ? $filtro['status'] : null;

            $alteracao = $this->getDoctrine()->getRepository(Servico::class);
            $alteracao->alterarServico($id, $sigla, $nome, $descricao, $status);
            $servico = $this->getDoctrine()->getRepository(Servico::class)->findOneBy(["id" => $id, "deletar" => 0]);
            $idFila = $servico->getIdFila();
            if ($alteracao) {
                $msg = "Alterado com sucesso!";
            } else {
                $msg = "Não foi possivel alterar!";
            }

            return $this->render("Servico/alterar.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        "mensagem" => $msg,
                        "servico" => $servico,
                        "idFila" => $idFila,
            ));
        }
    }

    /**
     * @Route ("/deletarServico", name="DeletarServico")
     */
    public function delete() {

        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {

            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $id = isset($filtro['id']) ? $filtro['id'] : null;
            $idFila = isset($filtro['idFila']) ? $filtro['idFila'] : null;
            $entityManage = $this->getDoctrine()->getRepository(Servico::class);
            $deletar = $entityManage->deletarServico($id);
            $fila = $this->getDoctrine()->getRepository(\AppBundle\Entity\Fila::class)->findOneBy(["id" => $idFila]);
            $servico = $entityManage->findBy(["idFila" => $idFila, "deletar" => 0], ["createAt" => "ASC"], 10);
            if ($deletar) {
                $msg = "Serviço deletado com sucesso!";
            } else {
                $msg = "Não foi possivel deletar serviço!";
            }
            return $this->render("Fila/exibefila.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        "servicos" => $servico,
                        "mensagem" => $msg,
                        "fila" => $fila,
            ));
        }
    }

}
