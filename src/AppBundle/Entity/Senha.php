<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Senha
 *
 * @ORM\Table(name="t_senhas")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SenhaRepository")
 */
class Senha
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dataAtendimento", type="datetime", nullable=true)
     */
    private $dataAtendimento;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dataSolicitacao", type="datetime", nullable=true)
     */
    private $dataSolicitacao;

    /**
     * @var string
     *
     * @ORM\Column(name="identificacao", type="string", length=60)
     */
    private $identificacao;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="sigla", type="string", length=2)
     */
    private $sigla;

    /**
     * @var string
     *
     * @ORM\Column(name="situacao", type="string", length=20)
     */
    private $situacao;

    /**
     * @var int
     *
     * @ORM\Column(name="idPreferencia", type="integer")
     */
    private $idPreferencia;

    /**
     * @var int
     *
     * @ORM\Column(name="idServico", type="integer")
     */
    private $idServico;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idUsuario", type="integer", nullable=true)
     */
    private $idUsuario;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dataAtendimento.
     *
     * @param \DateTime|null $dataAtendimento
     *
     * @return Senha
     */
    public function setDataAtendimento($dataAtendimento = null)
    {
        $this->dataAtendimento = $dataAtendimento;

        return $this;
    }

    /**
     * Get dataAtendimento.
     *
     * @return \DateTime|null
     */
    public function getDataAtendimento()
    {
        return $this->dataAtendimento;
    }

    /**
     * Set dataSolicitacao.
     *
     * @param \DateTime|null $dataSolicitacao
     *
     * @return Senha
     */
    public function setDataSolicitacao($dataSolicitacao = null)
    {
        $this->dataSolicitacao = $dataSolicitacao;

        return $this;
    }

    /**
     * Get dataSolicitacao.
     *
     * @return \DateTime|null
     */
    public function getDataSolicitacao()
    {
        return $this->dataSolicitacao;
    }

    /**
     * Set identificacao.
     *
     * @param string $identificacao
     *
     * @return Senha
     */
    public function setIdentificacao($identificacao)
    {
        $this->identificacao = $identificacao;

        return $this;
    }

    /**
     * Get identificacao.
     *
     * @return string
     */
    public function getIdentificacao()
    {
        return $this->identificacao;
    }

    /**
     * Set numero.
     *
     * @param int $numero
     *
     * @return Senha
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero.
     *
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set sigla.
     *
     * @param string $sigla
     *
     * @return Senha
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;

        return $this;
    }

    /**
     * Get sigla.
     *
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set situacao.
     *
     * @param string $situacao
     *
     * @return Senha
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;

        return $this;
    }

    /**
     * Get situacao.
     *
     * @return string
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * Set idPreferencia.
     *
     * @param int $idPreferencia
     *
     * @return Senha
     */
    public function setIdPreferencia($idPreferencia)
    {
        $this->idPreferencia = $idPreferencia;

        return $this;
    }

    /**
     * Get idPreferencia.
     *
     * @return int
     */
    public function getIdPreferencia()
    {
        return $this->idPreferencia;
    }

    /**
     * Set idServico.
     *
     * @param int $idServico
     *
     * @return Senha
     */
    public function setIdServico($idServico)
    {
        $this->idServico = $idServico;

        return $this;
    }

    /**
     * Get idServico.
     *
     * @return int
     */
    public function getIdServico()
    {
        return $this->idServico;
    }

    /**
     * Set idUsuario.
     *
     * @param int|null $idUsuario
     *
     * @return Senha
     */
    public function setIdUsuario($idUsuario = null)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario.
     *
     * @return int|null
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
}
