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
    public function filas($id) {
        if (!isset($_SESSION['login'])) {
            return $this->redirectToRoute("Login");
        } else {
            $entityManage = $this->getDoctrine()->getRepository(Fila::class);
            $filas = $entityManage->findOneBy(["deletar" => 0, "id" => $id]);
            if ($filas) {
                $em = $this->getDoctrine()->getRepository(Servico::class);   
                $servicos = $em->findBy(["deletar" => 0, "idFila" => $id]);
                return $this->render("Senha/servicoTriagem.html.twig", array(
                            "nome" => $_SESSION['nome'],
                            "id" => $id,
                            "servicos" => $servicos,
                ));
            } else {
                return $this->redirectToRoute("TriagemFila");
            }
        }
    }

}
