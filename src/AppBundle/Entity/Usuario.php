<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table(name="t_usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario {

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
     * @ORM\Column(name="nome", type="string", length=20)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="senha", type="string", length=255)
     */
    private $senha;

    /**
     * @var string
     *
     * @ORM\Column(name="sobrenome", type="string", length=100)
     */
    private $sobrenome;

    /**
     * @var string
     *
     * @ORM\Column(name="status_2", type="string", length=10)
     */
    private $status_2;

    /**
     * @var int
     *
     * @ORM\Column(name="usuario", type="integer")
     */
    private $usuario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime", nullable=true)
     */
    private $createAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @var int
     *
     * @ORM\Column(name="t_tipo_id", type="integer")
     */
    private $tipo;

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
     * @return Usuario
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
     * Set senha.
     *
     * @param string $senha
     *
     * @return Usuario
     */
    public function setSenha($senha) {
        $this->senha = $senha;

        return $this;
    }

    /**
     * Get senha.
     *
     * @return string
     */
    public function getSenha() {
        return $this->senha;
    }

    /**
     * Set sobrenome.
     *
     * @param string $sobrenome
     *
     * @return Usuario
     */
    public function setSobrenome($sobrenome) {
        $this->sobrenome = $sobrenome;

        return $this;
    }

    /**
     * Get sobrenome.
     *
     * @return string
     */
    public function getSobrenome() {
        return $this->sobrenome;
    }

    /**
     * Set status_2.
     *
     * @param string $status
     *
     * @return Usuario
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
     * Set usuario.
     *
     * @param int $usuario
     *
     * @return Usuario
     */
    public function setUsuario($usuario) {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario.
     *
     * @return int
     */
    public function getUsuario() {
        return $this->usuario;
    }

    /**
     * Set createAt.
     *
     * @param \DateTime|null $createAt
     *
     * @return Usuario
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
     * @return Usuario
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

    /**
     * Set tipo.
     *
     * @param int $tipo
     *
     * @return Usuario
     */
    public function setTipo($tipo) {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return int
     */
    public function getTipo() {
        return $this->tipo;
    }

}
