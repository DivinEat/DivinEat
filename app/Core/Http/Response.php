<?php

namespace App\Core\Http;

use App\Core\Form;
use App\Core\View;
use App\Core\Model\Model;
use Exception;

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
        if($model) {
            $form->setModel($model); 
            if (method_exists($model, "getId"))
                $_SESSION["idModel"] = $model->getId();
            if (method_exists($model, "getDateInserted"))
                $_SESSION["dateInsertedModel"] = $model->getDateInserted();
        }
        
        $form->buildForm();
        $form->configureOptions();
            
        return $form;
    }

    /**
     * 
     *
     * $response->checkFormData([
     *     "idModel" => $data["id"],
     *     "dateInsertedModel" => $data["dateInserted"],
     * ]);
     */
    public function checkFormData(array $data): bool{

        // TODO : page d'erreur de formulaire

        foreach ($data as $key => $value) {
            if (isset($_SESSION[$key."Model"])) {
                $session_value = $_SESSION[$key."Model"];
                unset($_SESSION[$key."Model"]);
                if ($value !== $session_value) {
                    die("Le formulaire n'est pas valide car une donnée non modifiable a été modifiée par l'utilisateur.");
                    throw new Exception("Le formulaire n'est pas valide car une donnée non modifiable a été modifiée par l'utilisateur.");
                    return false;
                }
            }
        }
        
        return true;
    }
}