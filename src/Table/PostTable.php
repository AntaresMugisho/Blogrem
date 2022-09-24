<?php

namespace App\Table;

use App\PaginatedQuery;
use App\Model\Post;
use App\Table\Table;
use Exception;

final class PostTable extends Table{

    protected $table = "post";
    protected $class = Post::class;

    public function create(Post $post)
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET name=:name, slug=:slug, content=:content, created_at=:created_at");
        $success = $query->execute([
            "name" => $post->get_name(),
            "slug" => $post->get_slug(),
            "content" => $post->get_content(),
            "created_at" => $post->get_created_at()->format("Y-m-d H:i:s")
        ]);
            
        if ($success === false){
            throw new Exception("Impossible de créer l'article");
        }
        
    $post->set_id($this->pdo->lastInsertId());
    }

    public function update(Post $post)
    {
        $query = $this->pdo->prepare("UPDATE {$this->table} SET name=:name, slug=:slug, content=:content, created_at=:created_at WHERE id = :id");
        $success = $query->execute([
            "id" => $post->get_id(), 
            "name" => $post->get_name(),
            "slug" => $post->get_slug(),
            "content" => $post->get_content(),
            "created_at" => $post->get_created_at()->format("Y-m-d H:i:s")
        ]);
            
        
        if ($success === false){
            throw new Exception("Echec de mise à jour de l'article {$post->get_id()}");
        }
    }

    public function delete($id)
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $success = $query->execute([$id]);
        
        if ($success === false){
            throw new Exception("Echec de suppression de l'article {$id}");
        }
    }

    public function find_paginated_articles()
    {
        $query = "SELECT * FROM {$this->table} ORDER BY id ASC";
        $query_count = "SELECT COUNT(id) FROM {$this->table}";

        $paginated_query = new PaginatedQuery($query, $query_count, Post::class);
        $posts = $paginated_query->get_items();
        (new CategoryTable)->find_related_categories($posts);
        return [$posts, $paginated_query];
    }

    public function find_paginated_with_category(int $category_id)
    {
        $query = "SELECT p.*
                FROM post p
                JOIN post_category pc ON pc.post_id = p.id
                WHERE pc.category_id = {$category_id}
                ORDER BY p.created_at DESC";

        $query_count = "SELECT COUNT(category_id)
                        FROM post_category
                        WHERE category_id = {$category_id}";

        $paginated_query = new PaginatedQuery($query, $query_count, Post::class);
       
        /** @var Post[] */
        $posts = $paginated_query->get_items();
        (new CategoryTable)->find_related_categories($posts);
        return [$posts, $paginated_query];
    }
}

?>