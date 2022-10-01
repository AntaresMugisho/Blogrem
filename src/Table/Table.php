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

    public function all():array
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
    }

    // CRUD 

    public function create(array $data): int  
    {   
        $sql_fields = [];
        foreach ($data as $k => $value){
            $sql_fields[] = "$k = :$k";
            dump($sql_fields); 
        }
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET " . implode(', ', $sql_fields));
        $success = $query->execute($data);
            
        if ($success === false){
            throw new Exception("Impossible de créer l'enregistrement dans la table");
        }
        
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $data, int $id): void   
    {
        $sql_fields = [];
        foreach ($data as $k => $value){
            $sql_fields[] = "$k = :$k";
            
        }
        $query = $this->pdo->prepare("UPDATE {$this->table} SET " . implode(', ', $sql_fields) . " WHERE id = :id");

        $success = $query->execute(array_merge($data, ["id" => $id]));
            
        if ($success === false){
            throw new Exception("Impossible de modifier l'enregistrement dans la table");
        }
    }

    public function delete(int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $success = $query->execute([$id]);
        
        if ($success === false){
            throw new Exception("Echec de suppression de l'article {$id}");
        }
    }
}
?>