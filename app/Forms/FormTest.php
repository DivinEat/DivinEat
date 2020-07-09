<?php

namespace App\Forms;

use App\Core\Form;
use App\Models\User;
use App\Managers\OrderManager;
use App\Core\Builder\FormBuilder;
use App\Core\Constraints\LengthConstraint;

class FormTest extends Form {

    
    public function buildForm(FormBuilder $builder)
    {
        $orderManager = new OrderManager();

        $this->setBuilder(
            $builder
                ->add('firstname', 'text', [
                    'label' => [
                        'value' => 'Votre prénom',
                        'classs' => '',
                    ],
                    'required' => true,
                    'attr' => [
                        'placeholder' => "Votre prénom",
                        'class' => 'form-control form-control-user'
                    ],
                    'constraints' => [
                        new LengthConstraint(2,50, 'Votre prénom doit contenir au moins 2 caractères', 'Votre prénom doit contenir au plus 50 caractères')
                    ]
                ])
                ->add('submit', 'submit', [
                    'label' => 'Soumettre',
                    'attr' => [
                        'class'=>"btn btn-primary"
                    ]
                ])
                ->add('commandes', 'select', [
                    'data' => $orderManager->findAll(),
                    'getter' => 'getId',
                    'selected' => $orderManager->find(1),
                ])
        );
    }

    public function configureOptions(): void
    {
        $this
            ->addConfig('class', User::class)
            ->setName('testype')
            ->addConfig('attr', [
                "id"=>"formRegisterUser",
                "class"=>"user",
            ]);
    }
}