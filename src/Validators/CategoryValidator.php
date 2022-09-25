<?php
    
namespace App\Validators;

use App\Validators\AbstractValidator;
use App\Table\CategoryTable;

class CategoryValidator extends AbstractValidator{

    public function __construct(array $data, CategoryTable $table, ?int $id = null)    
    {
        parent::__construct($data);
        $v = $this->validator;

        $v->labels(array(
            'name' => "Ce titre",
            'slug' => "Cet URL",
            'content' => "Le contenu"
        ));
    
        $v->rule("required", ["name", "slug"]);
        $v->rule("slug", "slug");
        $v->rule("lengthBetween", ["name", "slug"], 3, 150);
        $v->rule(function($field, $value) use ($table, $id){
            return !$table->exists($field, $value, $id);
        }, ["slug", "name"], " est déjà utilisé.");

        $this->validator = $v;
    }
}

?>