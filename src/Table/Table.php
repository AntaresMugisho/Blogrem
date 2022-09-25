<?php
namespace App\Table;
use \PDO;
use \Exception;
use App\Connection;

abstract class Table{

    protected $table = null;
    protected $class = null;
    protected $pdo;

    
    public function __construct()    
    {
        $this->pdo = Connection::get_pdo();

        if ($this->table === null){
            throw new Exception("La classe {$this->table} n'a pas de propriété {$this->table}");
        }

        if ($this->class === null){
            throw new Exception("La classe {$this->class} n'a pas de propriété {$this->class}");
        }
    }

    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $query->execute([$id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        
        $result = $query->fetch();
        if ($result === false){
            throw new Exception("Aucun enregistrement ne correspond à cet ID");
        }

        return $result;
    }

    /**
     * Vérifie si une valeur existe dans la table
     * @param string $field Champ à rechercher
     * @param mixed $value Valeur associé au champ
     */
    public function exists(string $field, $value, ?int $except = null) : bool
    {   
        $sql = "SELECT COUNT(id) FROM {$this->table} WHERE $field = ?";
        $params = [$value];
        if ($except !== null){
            $sql .= " AND id != ?";
            $params[] = $except;
        }

        $query = $this->pdo->prepare($sql);
        $query->execute($params);
   
        return (int)$query->fetch(PDO::FETCH_NUM)[0] > 0;
    }   
}
?>