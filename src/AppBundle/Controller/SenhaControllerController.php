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
                if($idPreferencia == 1){
                    $tipo = "Normal";
                }else{
                    $tipo = "Preferencial";
                }
                $servico = $this->getDoctrine()->getRepository(Servico::class)->findOneBy(["id" => $idServico]);
                $em = $this->getDoctrine()->getManager();
                $repositorioSenha = $this->getDoctrine()->getRepository(Senha::class);
                $numero = str_pad($fila->getNsenha(), 4, '0', STR_PAD_LEFT);
                $senha = new Senha();
                $senha->setIdentificacao($identificacao);
                $senha->setIdPreferencia($idPreferencia);
                $senha->setIdServico($idServico);
                $senha->setSigla($sigla);
                $senha->setNumero($numero);
                $em->persist($senha);
                $em->flush();
                $repositorioSenha->atualizarSenha($idFila, $numero);
                $numeroSenha = "$sigla"."$numero";
                $data = $senha->getDataSolicitacao();
                $emServ = $this->getDoctrine()->getRepository(Servico::class);
                $servicos = $emServ->findBy(["deletar" => 0, "idFila" => $id]);
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
     * @Route ("/gerarSenha", name="GerarSenha")
     */
    public function senha() {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $em = $this->getDoctrine()->getManager();
            $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $idFila = isset($filtro['idFila']) ? $filtro['idFila'] : null;
            $identificacao = isset($filtro['identificacao']) ? $filtro['identificacao'] : null;
            $idPreferencia = isset($filtro['idPreferencia']) ? $filtro['idPreferencia'] : null;
            $idServico = isset($filtro['idServico']) ? $filtro['idServico'] : null;
            $sigla = isset($filtro['sigla']) ? $filtro['sigla'] : null;
            $numero = $this->getDoctrine()->getRepository(Senha::class)->pegarSenha($idFila);
            $senha = new Senha();
            $senha->setIdentificacao($identificacao);
            $senha->setIdPreferencia($idPreferencia);
            $senha->setIdServico($idServico);
            $senha->setSigla($sigla);
            $senha->setNumero($numero);
            $em->persist($senha);
            $em->flush();
            $this->getDoctrine()->getRepository(Senha::class)->atualizaSenha($idFila, $numero);
            $msg = "Serviço cadastrado com sucesso!";
            return $this->render("Servico/cadastrar.html.twig", array(
                        "mensagem" => $msg,
                        "nome" => $_SESSION['nome'],
                        "idFila" => $idFila,
            ));
        }
    }

}
