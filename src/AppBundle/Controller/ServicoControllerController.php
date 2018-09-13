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
            ));
        }
    }

}
