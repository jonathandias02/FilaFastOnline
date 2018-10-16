<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Fila;

class PainelControllerController extends Controller {

    /**
     * @Route ("/configuracao", name="Configuracao")
     */
    public function configuracao() {
        $filas = $this->getDoctrine()->getRepository(Fila::class)->findAll();
        return $this->render("Painel/configuracao.html.twig", array(
                    "filas" => $filas
        ));
    }

    /**
     * @Route ("/painelweb", name="Painel")
     */
    public function painel() {
        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $idFila = isset($filtro['idFila']) ? $filtro['idFila'] : null;
        if ($idFila == null) {
            return $this->redirectToRoute("Configuracao");
        } else {
            return $this->render("Painel/painel.html.twig", array(
                        "idFila" => $idFila
            ));
        }
    }

}
