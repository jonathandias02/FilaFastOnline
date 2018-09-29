<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Fila;
use AppBundle\Entity\Senha;
use AppBundle\Entity\Servico;

class SenhaControllerController extends Controller {

    /**
     * @Route ("/triagemFila", name="TriagemFila")
     */
    public function triagemFilas() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $entityManage = $this->getDoctrine()->getRepository(Fila::class);
            $filas = $entityManage->findBy(["deletar" => 0]);
            return $this->render("Senha/filaTriagem.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        "filas" => $filas,
            ));
        }
    }

    /**
     * @Route ("/triagem/{id}", name="Triagem")
     */
    public function triagem($id) {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $entityManage = $this->getDoctrine()->getRepository(Fila::class);
            $repositorioSenha = $this->getDoctrine()->getRepository(Senha::class);
            $fila = $entityManage->findOneBy(["deletar" => 0, "id" => $id]);
//            recebe dados via post
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $idFila = $id;
            $identificacao = isset($filtro['identificacao']) ? $filtro['identificacao'] : null;
            $idPreferencia = isset($filtro['idPreferencia']) ? $filtro['idPreferencia'] : null;
            $idServico = isset($filtro['idServico']) ? $filtro['idServico'] : null;
            $sigla = isset($filtro['sigla']) ? $filtro['sigla'] : null;
            //se não vinher nenhum dado exibe serviços normalmente caso contrario gera a senha
            if ($identificacao !== null && $idPreferencia !== null && $idServico !== null && $sigla !== null) {
                if ($idPreferencia == 1) {
                    $tipo = "Normal";
                } else {
                    $tipo = "Preferencial";
                }
                $servico = $this->getDoctrine()->getRepository(Servico::class)->findOneBy(["id" => $idServico]);
                $em = $this->getDoctrine()->getManager();
                $numero = str_pad($fila->getNsenha(), 4, '0', STR_PAD_LEFT);
                $senha = new Senha();
                $senha->setIdentificacao($identificacao);
                $senha->setIdPreferencia($idPreferencia);
                $senha->setIdServico($idServico);
                $senha->setIdFila($idFila);
                $senha->setSigla($sigla);
                $senha->setNumero($numero);
                $em->persist($senha);
                $em->flush();
                $repositorioSenha->atualizarSenha($idFila, $numero);
                $numeroSenha = "$sigla" . "$numero";
                $data = $senha->getDataSolicitacao();
                $emServ = $this->getDoctrine()->getRepository(Servico::class);
                $servicos = $emServ->findBy(["deletar" => 0, "idFila" => $id]);
                for ($i = 0; $i < count($servicos); $i++) {
                    $servicos[$i]->setSenhasAguardando($repositorioSenha->numeroDeSenhas($servicos[$i]->getId()));
                    $servicos[$i]->setSenhasAtendidas($repositorioSenha->numeroDeSenhasAtendidas($servicos[$i]->getId()));
                }


                return $this->render("Senha/servicoTriagem.html.twig", array(
                            "nome" => $_SESSION['nome'],
                            "id" => $id,
                            "servicos" => $servicos,
                            "fila" => $fila,
                            "senha" => $numeroSenha,
                            "data" => $data,
                            "servico" => $servico,
                            "tipo" => $tipo,
                ));
            } else {
                if ($fila) {
                    $emServ = $this->getDoctrine()->getRepository(Servico::class);
                    $servicos = $emServ->findBy(["deletar" => 0, "idFila" => $id]);
                    for ($i = 0; $i < count($servicos); $i++) {
                        $servicos[$i]->setSenhasAguardando($repositorioSenha->numeroDeSenhas($servicos[$i]->getId()));
                        $servicos[$i]->setSenhasAtendidas($repositorioSenha->numeroDeSenhasAtendidas($servicos[$i]->getId()));
                    }
                    return $this->render("Senha/servicoTriagem.html.twig", array(
                                "nome" => $_SESSION['nome'],
                                "id" => $id,
                                "servicos" => $servicos,
                                "fila" => $fila,
                    ));
                } else {
                    return $this->redirectToRoute("TriagemFila");
                }
            }
        }
    }

    /**
     * @Route ("/atendimentoFila", name="AtendimentoFila")
     */
    public function atendimentoFilas() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $entityManage = $this->getDoctrine()->getRepository(Fila::class);
            $filas = $entityManage->findBy(["deletar" => 0]);
            return $this->render("Senha/atendimentoFila.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        "filas" => $filas,
            ));
        }
    }

    /**
     * @Route ("/selecionarguiche/{id}", name="SelecionarGuiche")
     */
    public function guiche($id) {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            return $this->render("Senha/atendimentoGuiche.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        "idFila" => $id,
            ));
        }
    }

    /**
     * @Route ("/atendimento", name="Atendimento")
     */
    public function atendimento() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {

            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $idFila = isset($filtro['idFila']) ? $filtro['idFila'] : null;
            $guiche = isset($filtro['guiche']) ? $filtro['guiche'] : null;
            $fila = $this->getDoctrine()->getRepository(Fila::class)->findOneBy(["id" => $idFila]);
            $senhasNormal = $this->getDoctrine()->getRepository(Senha::class)->senhasNormais($idFila);
            $senhasPrefencial = $this->getDoctrine()->getRepository(Senha::class)->senhasPreferenciais($idFila);
            $proximaSenha = $senhasNormal[0];
            return $this->render("Senha/atendimento.html.twig", array(
                        "nome" => $_SESSION['nome'],
                        "idFila" => $idFila,
                        "guiche" => $guiche,
                        "fila" => $fila,
                        "proximaSenha" => $proximaSenha,
            ));
        }
    }

}
