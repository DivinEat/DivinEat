<?php

namespace App\Forms;

use App\core\Form;
use App\models\User;
use App\core\Constraints\Length;
use App\core\Builder\FormBuilder;

class TestType extends Form {

    public function buildForm(FormBuilder $builder)
    {
        $this->setBuilder(
            $builder
                ->add('firstname', 'text', [
                    'label' => 'Votre prénom',
                    'required' => true,
                    'choices' => [
                        'choix1' => 'valeur1'
                    ],
                    'attr' => [
                        'placeholder' => "Votre prénom",
                        'class' => 'form-control form-control-user'
                    ],
                    'constraints' => [
                        new Length(2,50, 'Votre prénom doit contenir au moins 2 caractères', 'Votre prénom doit contenir au plus 50 caractères')
                    ]
                ])
                ->add('submit', 'submit', [
                    'label' => 'Soumettre',
                    'attr' => [
                        'class'=>"btn btn-primary"
                    ]
                ])
                    );
    }

    public function configureOptions(): void
    {
        $this->addConfig('class', User::class)
            ->setName('testype')
            ->addConfig('attr', [
                "id"=>"formRegisterUser",
                "class"=>"user",
        ]);
    }
}
