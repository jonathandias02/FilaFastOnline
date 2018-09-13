<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servico
 *
 * @ORM\Table(name="t_servicos")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServicoRepository")
 */
class Servico {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, unique=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="sigla", type="string", length=2, unique=true)
     */
    private $sigla;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=255, nullable=true)
     */
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="status_2", type="string", length=10)
     */
    private $status_2;

    /**
     * @var int
     *
     * @ORM\Column(name="t_filas_id", type="integer")
     */
    private $idFila;

    /**
     * @var int
     *
     * @ORM\Column(name="t_usuario_id", type="integer")
     */
    private $idUsuario;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="create_at", type="datetime", nullable=true)
     */
    private $createAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private $updateAt;
    
    /**
     * @var int
     *
     * @ORM\Column(name="deletar", type="integer")
     */
    private $deletar;
    
    

    /**
     * Construct
     */
    public function __construct() {
        $this->createAt = new \DateTime("now", new \DateTimeZone("America/Sao_Paulo"));
        $this->updateAt = new \DateTime("now", new \DateTimeZone("America/Sao_Paulo"));
        $this->deletar = 0;
    }
    
    /**
     * Get deletar.
     *
     * @return int
     */
    function getDeletar() {
        return $this->deletar;
    }

    /**
     * Set deletar.
     *
     * @param string $deletar
     *
     * @return Usuario
     */
    function setDeletar($deletar) {
        $this->deletar = $deletar;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nome.
     *
     * @param string $nome
     *
     * @return Servico
     */
    public function setNome($nome) {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome.
     *
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Set sigla.
     *
     * @param string $sigla
     *
     * @return Servico
     */
    public function setSigla($sigla) {
        $this->sigla = $sigla;

        return $this;
    }

    /**
     * Get sigla.
     *
     * @return string
     */
    public function getSigla() {
        return $this->sigla;
    }

    /**
     * Set descricao.
     *
     * @param string $descricao
     *
     * @return Servico
     */
    public function setDescricao($descricao) {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao.
     *
     * @return string
     */
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * Set status_2.
     *
     * @param string $status
     *
     * @return Servico
     */
    public function setStatus_2($status) {
        $this->status_2 = $status;

        return $this;
    }

    /**
     * Get status_2.
     *
     * @return string
     */
    public function getStatus_2() {
        return $this->status_2;
    }

    /**
     * Set idFila.
     *
     * @param int $idFila
     *
     * @return Servico
     */
    public function setIdFila($idFila) {
        $this->idFila = $idFila;

        return $this;
    }

    /**
     * Get idFila.
     *
     * @return int
     */
    public function getIdFila() {
        return $this->idFila;
    }

    /**
     * Set idUsuario.
     *
     * @param int $idUsuario
     *
     * @return Servico
     */
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario.
     *
     * @return int
     */
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    /**
     * Set createAt.
     *
     * @param \DateTime|null $createAt
     *
     * @return Servico
     */
    public function setCreateAt($createAt = null) {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt.
     *
     * @return \DateTime|null
     */
    public function getCreateAt() {
        return $this->createAt;
    }

    /**
     * Set updateAt.
     *
     * @param \DateTime|null $updateAt
     *
     * @return Servico
     */
    public function setUpdateAt($updateAt = null) {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt.
     *
     * @return \DateTime|null
     */
    public function getUpdateAt() {
        return $this->updateAt;
    }

}
