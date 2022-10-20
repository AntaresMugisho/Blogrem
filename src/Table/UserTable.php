<?php

namespace App\Table;

use App\Model\User;
use App\Table\Table;
use \PDO;
use Exception;

final class UserTable extends Table{

    protected $table = "user";
    protected $class = User::class;

    public function find_by_username(string $username)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE username = ?");
        $query->execute([$username]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        
        $result = $query->fetch();
        if ($result === false){
            return null;
            // throw new Exception("Aucun enregistrement ne correspond à ce nom");
        }

        return $result;
    }
}

?>