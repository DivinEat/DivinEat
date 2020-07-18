<?php

namespace App\Forms\Comments;

use App\Core\Form;
use App\Core\Routing\Router;
use App\Managers\CommentManager;
use App\Core\Constraints\RequiredConstraint;

class UpdateCommentForm extends Form
{
    public function buildForm()
    {   
        $this->setName("updateCommentForm");

        $this->setBuilder()
            ->add("content", "textArea", [
                "label" => [
                    "value" => "Poster un commentaire",
                    "class" => "",
                ],
                "attr" => [
                    "placeholder"=>"&#xf0e5;  Ecrire ici",
                    "class" => "form-control form-control-textarea form-control-user"
                ],
                "constraints" => [
                    new RequiredConstraint()
                ],
                "text" => $this->model->getContent()

            ])
            ->add("submit", "input", [
                "attr" => [
                    "type" => "submit",
                    "value" => "&#xf1d8 Poster",
                    "class" => "btn btn-primary"
                ]
            ]);
    }

    public function configureOptions(): void
    {
        $comments = (new CommentManager())->findBy(['article' => $this->model->getId(), 'hide' => false]);

        $this->addConfig("attr", [
                "id" => "updateCommentForm",
                "class" => "admin-form width-100",
                "name" => "updateCommentForm"
            ]);
            //->addConfig("action", Router::getRouteByName('actualites.comments.update', [$this->model->getSlug(), $comments->getId()])->getUrl());
    }
}