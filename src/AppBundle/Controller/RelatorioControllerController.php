<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Senha;

class RelatorioControllerController extends Controller {

    /**
     * @Route ("/relatorioperiodo", name="RelatorioPeriodo")
     */
    public function relatorioPeriodo() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $dataInicio = isset($filtro['inicio']) ? $filtro['inicio'] : null;
            $dataFim = isset($filtro['fim']) ? $filtro['fim'] : null;
            if ($dataInicio === null && $dataFim === null) {
                return $this->render("Relatorios/periodo.html.twig", array(
                            "nome" => $_SESSION['nome'],
                ));
            } else {
                $msg = null;
                $atendimentos = $this->getDoctrine()->getRepository(Senha::class)->relatorioPeriodo($dataInicio, $dataFim);
                if (count($atendimentos) == 0) {
                    $msg = "Nenhum atendimento realizado neste período.";
                }
                return $this->render("Relatorios/periodo.html.twig", array(
                            "nome" => $_SESSION['nome'],
                            "atendimentos" => $atendimentos,
                            "mensagem" => $msg,
                            "dataInicio" => $dataInicio,
                            "dataFim" => $dataFim,
                ));
            }
        }
    }

    /**
     * @Route ("/relatoriofila", name="RelatorioFila")
     */
    public function relatorioFila() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            return $this->render("Relatorios/fila.html.twig", array(
                        "nome" => $_SESSION['nome'],
            ));
        }
    }

    /**
     * @Route ("/relatorioservico", name="RelatorioServico")
     */
    public function relatorioServico() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            return $this->render("Relatorios/servico.html.twig", array(
                        "nome" => $_SESSION['nome'],
            ));
        }
    }

    /**
     * @Route ("/relatorio", name="Relatorio")
     */
    public function relatorio() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $dataInicio = isset($filtro['inicio']) ? $filtro['inicio'] : null;
            $dataFim = isset($filtro['fim']) ? $filtro['fim'] : null;
            if ($dataInicio === null && $dataFim === null) {
                return $this->render("Relatorios/periodo.html.twig", array(
                            "nome" => $_SESSION['nome'],
                ));
            } else {
                $msg = null;
                $atendimentos = $this->getDoctrine()->getRepository(Senha::class)->relatorioPeriodo($dataInicio, $dataFim);
                if (count($atendimentos) == 0) {
                    $msg = "Nenhum atendimento realizado neste período.";
                }
            }
            return $this->render("Relatorios/relatorio.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        "atendimentos" => $atendimentos,
                        "dataInicio" => $dataInicio,
                        "dataFim" => $dataFim,
            ));
        }
    }

}
