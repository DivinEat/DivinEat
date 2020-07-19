<?php

namespace App\Forms\Comments;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Core\Constraints\RequiredConstraint;

class CreateCommentForm extends Form
{
    public function buildForm()
    {   
        $this->setName("createCommentForm");

        $this->setBuilder()
            ->add("content", "textArea", [
                "label" => [
                    "value" => "Poster un commentaire",
                    "class" => "",
                ],
                "attr" => [
                    "placeholder"=>"Ecrire ici",
                    "class" => "form-control form-control-textarea"
                ],
                "constraints" => [
                    new RequiredConstraint()
                ]
            ])
            ->add("submit", "input", [
                "attr" => [
                    "type" => "submit",
                    "value" => "Poster",
                    "class" => "btn btn-primary"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $this->addConfig("attr", [
                "id" => "createCommentForm",
                "class" => "admin-form width-100",
                "name" => "createCommentForm"
            ])
            ->addConfig("action", Router::getRouteByName('actualites.comments.store', [$this->model->getCategorie()->getSlug(), $this->model->getSlug()])->getUrl());
    }
}