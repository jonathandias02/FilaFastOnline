<?php

namespace AppBundle\Repository;

/**
 * SenhaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SenhaRepository extends \Doctrine\ORM\EntityRepository {

    public function pegarSenha($idFila) {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT nsenha FROM t_filas
        WHERE id = :ID and deletar = 0';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['ID' => $idFila]);

        return $stmt->fetchAll();
    }
    
    public function atualizarSenha($idFila, $senha) {
        $conn = $this->getEntityManager()->getConnection();
        $novaSenha = $senha + 1;
        $sql = 'UPDATE t_filas
        SET nsenha = :NOVASENHA
        WHERE id = :ID and deletar = 0';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['ID' => $idFila, 'NOVASENHA' => $novaSenha]);
        $count = $stmt->rowCount();
        return $count;
    }
    
    public function numeroDeSenhas($id) {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT id FROM t_senhas WHERE t_servicos_id = :ID';
        $stmt = $conn->prepare($sql);
        $stmt->execute(["ID" => $id]);
        $count = $stmt->rowCount();
        return $count;
    }
    
    public function numeroDeSenhasAtendidas($id) {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT id FROM t_senhas WHERE situacao != "Aguardando" and t_servicos_id = :ID';
        $stmt = $conn->prepare($sql);
        $stmt->execute(["ID" => $id]);
        $count = $stmt->rowCount();
        return $count;
    }
    
    public function senhasNormais($idFila): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT ser.nome, s.id, s.sigla, s.numero, s.identificacao, p.preferencia FROM t_servicos ser, t_senhas s, t_preferencia p
                WHERE ser.id = s.t_servicos_id AND p.id = s.t_preferencia_id
                AND s.situacao = "Aguardando" AND s.t_preferencia_id = 1 AND
                s.t_filas_id = :IDFILA AND s.t_usuario_id IS NULL;';
        $stmt = $conn->prepare($sql);
        $stmt->execute(["IDFILA" => $idFila]);
        return $stmt->fetchAll();
    }
    
    public function senhasPreferenciais($idFila): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT ser.nome, s.id, s.sigla, s.numero, s.identificacao, p.preferencia FROM t_servicos ser, t_senhas s, t_preferencia p
                WHERE ser.id = s.t_servicos_id AND p.id = s.t_preferencia_id AND s.situacao = "Aguardando" AND s.t_preferencia_id = 2 AND
                s.t_filas_id = :IDFILA AND s.t_usuario_id IS NULL;';
        $stmt = $conn->prepare($sql);
        $stmt->execute(["IDFILA" => $idFila]);
        return $stmt->fetchAll();
    }
    
    public function chamarSenha($idSenha, $idUsuario){
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'UPDATE t_senhas
        SET situacao = "Chamada", t_usuario_id = :IDUSUARIO
        WHERE id = :IDSENHA;';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['IDSENHA' => $idSenha, 'IDUSUARIO' => $idUsuario]);
        $count = $stmt->rowCount();
        return $count;
    }
    
    public function senha($idSenha){
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT ser.nome, s.id, s.sigla, s.numero, s.identificacao, s.situacao, p.preferencia FROM t_servicos ser, t_senhas s, t_preferencia p
                WHERE ser.id = s.t_servicos_id AND p.id = s.t_preferencia_id
                AND s.id = :IDSENHA;';
        $stmt = $conn->prepare($sql);
        $stmt->execute(["IDSENHA" => $idSenha]);
        return $stmt->fetch();
    }
    
    public function finalizar($idSenha, $duracao, $dataAtendimento){
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'UPDATE t_senhas
        SET situacao = "Atendida", duracao = :DURACAO, dataAtendimento = :DATA
        WHERE id = :IDSENHA;';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['IDSENHA' => $idSenha, 'DURACAO' => $duracao, 'DATA' => $dataAtendimento]);
        $count = $stmt->rowCount();
        return $count;
    }
    
    public function naoCompareceu($idSenha, $dataAtendimento){
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'UPDATE t_senhas
        SET situacao = "Não Compareceu", dataAtendimento = :DATA
        WHERE id = :IDSENHA;';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['IDSENHA' => $idSenha, 'DATA' => $dataAtendimento]);
        $count = $stmt->rowCount();
        return $count;
    }

    
    
}
