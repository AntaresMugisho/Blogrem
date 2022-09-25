<?php

namespace App\Table;

use App\PaginatedQuery;
use App\Model\Post;
use App\Table\Table;
use Exception;

final class PostTable extends Table{

    protected $table = "post";
    protected $class = Post::class;

    public function find_paginated_articles()
    {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
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