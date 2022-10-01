<?php

namespace App\Model;

class Category{
    private $id;
    private $name;
    private $slug;

    private $post_id;
    private $post;



    public function set_id(int $id):self
    {
        $this->id = $id;
        return $this;
    }

    public function set_name(string $name):self
    {
        $this->name = $name;
        return $this;
    }

    public function set_slug(string $slug):self
    {
        $this->slug = $slug;
        return $this;
    }


    public function get_id() : ?int
    {
        return $this->id;
    }
    
    public function get_name() : ?string
    {
        return $this->name;
    }

    public function get_slug() : ?string
    {
        return $this->slug;
    }

    public function get_post_id() : ?int
    {
        return $this->post_id;
    }

    public function set_post(Post $post)
    {
        $this->post = $post;
    }
}