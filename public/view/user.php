<?php

namespace Views;

use Controller\UserController;

class UserView
{
    // Aqui podem ser adicionados métodos para renderizar views relacionadas a usuários

    private ?UserController $controller = null;
    private \PDO $pdo;
    private $viewModel; // callable|null

    /**
     * @param \PDO $pdo
     * @param callable|null $viewModel função com assinatura fn(\PDO): array
     */
    public function __construct(\PDO $pdo, $viewModel = null)
    {
        $this->pdo = $pdo;
        $this->viewModel = $viewModel;

        // Só instancia o controller se necessário (e existir)
        if ($this->viewModel === null && class_exists('\Controller\UserController')) {
            $this->controller = new UserController($this->pdo);
        }
    }

    public function getAllUsers()
    {
        if(is_callable($this->viewModel)) {
            $users = call_user_func($this->viewModel, $this->pdo);
        } elseif ($this->controller !== null) {
            $users = $this->controller->listUsers($this->pdo);
        } else {
            echo "<p>Erro: Nenhum método disponível para obter usuários.</p>";
            return;
        }
        if (count($users) > 0) {
            echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr style='background: #f0f0f0;'>";
            echo "<th>ID</th><th>Nome</th><th>Email</th><th>Criado em</th>";
            echo "</tr>";
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>{$user['id']}</td>";
                echo "<td>{$user['nome']}</td>";
                echo "<td>{$user['email']}</td>";
                echo "<td>{$user['criado_em']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nenhum usuário cadastrado.</p>";
        }

    }
}