<?php 

// Definição do namespace para a classe User
namespace Model;

class User {
    private $id;
    private $name;
    private $email;
    private $password;

    private $active;
    private $created_at;

    public function __construct($id, $name, $email, $password, $active, $created_at) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->active = $active;
        $this->created_at = $created_at;
    }

    // Getters e Setters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function isActive() {
        return $this->active;
    }
}