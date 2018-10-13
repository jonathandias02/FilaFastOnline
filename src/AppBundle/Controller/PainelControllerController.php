<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class PainelControllerController extends Controller {

    /**
     * @Route ("/painel", name="Painel")
     */
    public function triagemFilas() {
        return $this->render("Painel/painel.html.twig");
    }

}
