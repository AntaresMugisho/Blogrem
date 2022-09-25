<?php

namespace App\Model;

class User{

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;


    public function get_id() : ?int
    {
        return $this->id;
    }

    public function set_id(string $id):self
    {
        $this->id = $id;
        return $this;
    }
    
    public function get_username() : ?string
    {
        return $this->username;
    }

    public function set_username(string $username):self
    {
        $this->username = $username;
        return $this;
    }

    public function get_password() : ?string
    {
        return $this->password;
    }

    public function set_password(string $password): self
    {
        $this->password = $password;
        return $this;
    }
}