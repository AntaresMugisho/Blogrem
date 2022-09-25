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

    public function set_name(string $name):self
    {
        $this->name = htmlentities($name);
        return $this;
    }

    public function set_slug(string $slug): self
    {
        $this->slug = htmlentities($slug);
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

    public function set_id(int $id) : int
    {
        $this->id = $id;
        return $this->id;
    }

    public function get_name() : ?string
    {
        return nl2br(htmlentities($this->name));
    }

    public function get_slug() : ?string
    {
        return htmlentities($this->slug);
    }

    public function get_excerpt(): ?string
    {
        if ($this->content === null){
            return null;
        }

        return nl2br(htmlentities(Text::excerpt($this->content, 60)));
    }

    public function get_content(): ?string
    {
        if ($this->content === null){
            return null;
        }

        return htmlentities($this->content);
    }

    public function get_created_at(): string
    {
        return (new Datetime($this->created_at))->format("Y-m-d H:m:s");
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