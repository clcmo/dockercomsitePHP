<?php 

namespace Controller;

use Model\User;
use PDO;

class UserController {
    // Aqui podem ser adicionados métodos para manipular usuários

    private PDO $pdo;
    private $data;

    public function __construct(PDO $pdo) {
        // Construtor vazio ou inicializações necessárias
        $this->pdo = $pdo;
    }

    // Primeira função de exemplo para verificar se usuários existem
    public function checkUsersExist($pdo) {
        // Verificar se já existem usuários
        $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    // Segunda função de exemplo para adicionar um usuário
    public function addUser($pdo, $name, $email, $password, $active) {
        $senhaHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, ativo, criado_em) VALUES (:nome, :email, :senha, :ativo, :criado_em)");
        $stmt->bindParam(':nome', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senhaHash);
        $stmt->bindParam(':ativo', $active);
        $stmt->bindParam(':criado_em', date('Y-m-d H:i:s'));
        return $stmt->execute();
    }

    // Terceira função de exemplo para listar todos os usuários
    public function listUsers($pdo) {
        $stmt = $pdo->query("SELECT id, nome, email, criado_em FROM usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Quarta função de exemplo para alterar o dado de um usuário
    public function updateUserEmail($pdo, $userId, $newEmail) {
        $stmt = $pdo->prepare("UPDATE usuarios SET email = :email WHERE id = :id");
        $stmt->bindParam(':email', $newEmail);
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }

    public function updateUserPass($pdo, $userId, $newPassword) {
        $senhaHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
        $stmt->bindParam(':senha', $senhaHash);
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }

    public function updateUserName($pdo, $userId, $newName) {
        $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome WHERE id = :id");
        $stmt->bindParam(':nome', $newName);
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }

    public function updateUserActive($pdo, $userId, $newActive) {
        $stmt = $pdo->prepare("UPDATE usuarios SET ativo = :ativo WHERE id = :id");
        $stmt->bindParam(':ativo', $newActive);
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }

    // Quinta função de exemplo para deletar um usuário
    public function deleteUser($pdo, $userId) {
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }
}