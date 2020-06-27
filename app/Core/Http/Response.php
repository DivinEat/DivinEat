<?php

namespace App\Core\Http;

use App\Core\Model\Model;
use App\Core\Form;
use App\Core\View;

class Response
{
    public function render(string $view, string $template = null, array $data = null)
    { 
        $view = new View($view, $template);
        
        if (null !== $data) 
        {
            foreach($data as $key => $value) {
                $view->assign($key, $value);
            }
        }
    }

    public function createForm(string $class, Model &$model = null): Form
    {
        $form = new $class;
        
        if($model)
            $form->setModel($model); 
        
        $form->buildForm();
        $form->configureOptions();
            
        return $form;
    }
}