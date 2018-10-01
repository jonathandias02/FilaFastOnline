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
     * @ORM\Column(name="email", type="string", length=120, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="identificacao", type="string", length=60, nullable=true)
     */
    private $identificacao;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="string", length=5)
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
     * @var string
     *
     * @ORM\Column(name="observacoes", type="string", length=255, nullable=true)
     */
    private $observacoes;
    
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="duracao", type="time", nullable=true)
     */
    private $duracao;

    /**
     * @var int
     *
     * @ORM\Column(name="t_preferencia_id", type="integer")
     */
    private $idPreferencia;

    /**
     * @var int
     *
     * @ORM\Column(name="t_servicos_id", type="integer")
     */
    private $idServico;
    
    /**
     * @var int
     *
     * @ORM\Column(name="t_filas_id", type="integer")
     */
    private $idFila;

    /**
     * @var int|null
     *
     * @ORM\Column(name="t_usuario_id", type="integer", nullable=true)
     */
    private $idUsuario;
    
    /**
     * Construct
     */
    public function __construct() {
        $this->dataSolicitacao = new \DateTime("now", new \DateTimeZone("America/Sao_Paulo"));
        $this->situacao = "Aguardando";
    }

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
     * Set email.
     *
     * @param string $email
     *
     * @return Senha
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * Set observacoes.
     *
     * @param string $observacoes
     *
     * @return Senha
     */
    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;

        return $this;
    }

    /**
     * Get observacoes.
     *
     * @return string
     */
    public function getObservacoes()
    {
        return $this->observacoes;
    }
    
    /**
     * Set duracao.
     *
     * @param \DateTime|null $duracao
     *
     * @return Senha
     */
    public function setDuracao($duracao = null)
    {
        $this->duracao = $duracao;

        return $this;
    }

    /**
     * Get duracao.
     *
     * @return \DateTime|null
     */
    public function getDuracao()
    {
        return $this->duracao;
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
     * Set idFila.
     *
     * @param int $idFila
     *
     * @return Senha
     */
    public function setIdFila($idFila)
    {
        $this->idFila = $idFila;

        return $this;
    }

    /**
     * Get idFila.
     *
     * @return int
     */
    public function getIdFila()
    {
        return $this->idFila;
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
