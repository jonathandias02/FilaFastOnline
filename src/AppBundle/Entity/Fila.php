<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fila
 *
 * @ORM\Table(name="t_filas")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FilaRepository")
 */
class Fila {

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
     * @ORM\Column(name="nome", type="string", length=60)
     */
    private $nome;

    /**
     * @var int
     *
     * @ORM\Column(name="nsenha", type="integer")
     */
    private $nsenha;

    /**
     * @var string
     *
     * @ORM\Column(name="status_2", type="string", length=10)
     */
    private $status_2;

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
        $this->nsenha = 1;
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
     * @return Fila
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
     * @return Fila
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
     * Set nsenha.
     *
     * @param int $nsenha
     *
     * @return Fila
     */
    public function setNsenha($nsenha) {
        $this->nsenha = $nsenha;

        return $this;
    }

    /**
     * Get nsenha.
     *
     * @return int
     */
    public function getNsenha() {
        return $this->nsenha;
    }

    /**
     * Set status_2.
     *
     * @param string $status
     *
     * @return Fila
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
     * Set idUsuario.
     *
     * @param int $idUsuario
     *
     * @return Fila
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
     * @return Fila
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
     * @return Fila
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
