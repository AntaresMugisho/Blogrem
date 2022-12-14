<?php

namespace App\Model;
use App\Helpers\Text;
use \Datetime;

class Post{
    private $id;
    private $name;
    private $slug;
    private $content;
    private $created_at;

    private $categories = [];

    public function set_id(int $id) : int
    {
        $this->id = $id;
        return $this->id;
    }

    public function set_name(string $name):self
    {
        $this->name = $name;
        return $this;
    }

    public function set_slug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function set_content(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function set_created_at(string $created_at) : void
    {
        $this->created_at = $created_at;
    }

    public function get_id() : ?int
    {
        return ($this->id);
    }

    public function get_name() : ?string
    {
        return $this->name;
    }

    public function get_slug() : ?string
    {
        return $this->slug;
    }

    public function get_excerpt(): ?string
    {
        if ($this->content === null){
            return null;
        }

        return Text::excerpt($this->content, 65);
    }

    public function get_content(): ?string
    {
        if ($this->content === null){
            return null;
        }

        return nl2br($this->content);
    }

    public function get_created_at(): Datetime
    {
        return (new DateTime($this->created_at));
    }
    
    /** @return Category */
    public function get_categories(): array
    {
        return $this->categories;
    }

    public function add_category(Category $category): void
    {
        $this->categories[] = $category;
        $category->set_post($this);
    }
}