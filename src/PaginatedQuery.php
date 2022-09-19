<?php

namespace App;
use PDO, Exception;

class PaginatedQuery{

    private $query;
    private $query_count;
    private $class_mapping;
    private $pdo;
    private $per_page;
    
    private $count;
    private $items;

    public function __construct(
        string $query, 
        string $query_count, 
        string $class_mapping, 
        ?PDO $pdo = null, 
        int $per_page = 12)
    {
       $this->query = $query; 
       $this->query_count = $query_count; 
       $this->class_mapping = $class_mapping; 
       $this->pdo = $pdo ? : Connection::get_pdo(); 
       $this->per_page = $per_page; 
    }

    public function get_items (): array
    {
        if ($this->items === null){
     
            $current_page = $this->get_current_page();;
            $total_pages = $this->get_total_pages();

            if ($current_page > $total_pages){
                throw new Exception("Numéro de page invalide");
            }

            $offset = $this->per_page * ($current_page - 1);
            
            $this->items = $this->pdo->query(
                $this->query
                . " LIMIT $this->per_page OFFSET $offset")

                ->fetchAll(PDO::FETCH_CLASS, $this->class_mapping);
        }
        return $this->items;
    }

    public function previous_link(string $link): ?string
    {
        $current_page = $this->get_current_page();
        if ($current_page <= 1) return null;

        if ($current_page > 2) $link .= "?page=" . ($current_page - 1);

        return <<<HTML
            <a href="{$link}" class="me-4 btn btn-dark ms-auto">&laquo; Page précédente</a>
            HTML;
    }

    public function next_link($link): ?string
    {
        $current_page = $this->get_current_page();;
        $total_pages = $this->get_total_pages();

        if ($current_page >= $total_pages) return null;
        
        $link .= "?page=" . ($current_page + 1);

        return <<<HTML
            <a href="{$link}" class="btn btn-dark">Page suivante &raquo;</a>
            HTML;
    }

    private function get_current_page():int
    {   
        if (isset($_GET["page"]) && $_GET["page"] === "1" ){
    
            $uri = explode("?", $_SERVER["REQUEST_URI"])[0];
        
            $get = $_GET;
            unset($get["page"]);
        
            $query = http_build_query($get);
        
            if (!empty($query)){
                $uri .= "?$query";
            }
        
            http_response_code(301);
            header("Location: $uri");
            exit();
        }

        return $_GET["page"] ?? 1;
    }

    private function get_total_pages(): int
    {
        if ($this->count == null){
            $this->count = (int)$this->pdo
                ->query($this->query_count)
                ->fetch(PDO::FETCH_NUM)[0];
            }

        return ceil($this->count / $this->per_page);
    }
}

?>