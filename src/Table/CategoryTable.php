<?php

namespace App\Table;

use App\Connection;
use \PDO;
use App\Model\Category;
use App\Table\Table;

final class CategoryTable extends Table {

    protected $table = "category";
    protected $class = Category::class;
    
    
    /** @param App\Model\Post[] $posts */
    public function find_related_categories(array $posts):  void     
    {
        $post_by_id = [];
        foreach ($posts as $post){
            $post_by_id[$post->get_id()] = $post;
        }

        $categories = $this->pdo
            ->query("SELECT c.*, pc.post_id
                    FROM category c
                    JOIN post_category pc ON pc.post_id = c.id
                    WHERE pc.post_id IN (". implode(",", array_keys($post_by_id)) .")")
            ->fetchAll(PDO::FETCH_CLASS, $this->class);

        foreach ($categories as $category){
            $post_by_id[$category->get_post_id()]->add_category($category);
        }
    }
}
?>