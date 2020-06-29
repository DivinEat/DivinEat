<?php

namespace App\Core;

use Exception;
use App\Core\Model\Model;
use App\Core\Builder\FormBuilder;
use App\Core\Constraints\Validator;


class Form
{
    private $builder;
    private $config = [];
    private $name;
    private $isSubmit = false;
    private $isValid = false;
    private $validator;
    private $errors = [];
    protected $model;

    public function __construct()
    {
        $this->validator = new Validator();

        $this->config = [
            "method"=>"POST", 
            "action"=>"",
            "attr" => []
        ];
    }

    //Parcours les élements du Builder en récupérant le nom (exemple:firstname)
    // Si le getter de ce nom existe dans le model lié à la page on le modifie
    public function associateValue()
    {
      
        foreach($this->builder->getElements() as $key => $element)
        {
            $method = 'get'.ucfirst($key);

            if(method_exists($this->model, $method))
            {
                $this->builder->setValue($key, $this->model->$method());
            }
        }

    }

    public function getElements(): ?array
    {
        return $this->builder->getElements();
    }

    /**
     *  Si on est en POST, on update isSubmit en lançant checkIsSubmit
     *      si on est isSubmit on update isValid en lançant checkIsValid
     *      Quand on termine, on associe les valeurs des champs du formulaire à notre $model
     * 
     * */ 
    public function handle(): bool
    {
        if($_SERVER['REQUEST_METHOD'] === $this->config["method"]) {
            if (false === $this->checkIsSubmitted())
                return false;
        }

        return $this->checkIsValid();
    }

    /**
     * Comme on peut faire plusieurs formulaire dans une page, le name en front
     * contient le $nomFormulaire_$nomDuChamps, donc je parcours mes données en POST
     * et si une clé contient le $nomFormulaire alors je sais que c'est le bon formulaire qui est soumis
     * Le nom se trouve dans $name / Elle update isSubmit
     */
    private function checkIsSubmitted(): bool
    {
        $this->isSubmit = true;

        foreach($_POST as $key => $value)
        {
            $elementName = explode("_", $key);

            if ($elementName[0] !== $this->name)
                return false;
        }

        return true;
    }

    /**
     * Cette méthode regarde pour chaque élements du builder l'ensemble des contraintes
     * Si il y a des contraintes, alors elles les enregistres dans $errors 
     * Elle update $isValid
     */
    public function checkIsValid(): bool
    {
        $this->isValid = true;
        
        foreach ($this->builder->getElements() as $elementName => $element)
        {
            if (!isset($_POST[$element->getName()]) || !isset($element->getOptions()["constraints"])) {
                continue;
            }

            $name = isset($element->getOptions()["label"]["value"]) ? $element->getOptions()["label"]["value"] : $element->getName();

            foreach ($element->getOptions()['constraints'] as $constraint) {
                $responseValidator = $this->validator->checkConstraint($constraint, $_POST[$element->getName()], $name);

                if (NULL !== $responseValidator) {
                    $this->isValid = false;
                    $this->errors[$element->getName()] = $responseValidator;
                }
            }           
        }

        return $this->isValid;
    }

    // Insere les valeurs du formulaire dans $model
    public function updateObject(): void
    {
        foreach($_POST as $key => $value)
        {
           
            if(FALSE !== strpos($key, $this->name))
            {
                $key = str_replace($this->name.'_', '', $key);
               
                $method = 'set'.ucfirst($key);

                if(method_exists($this->model, $method))
                {
                    $this->model->$method($value);
                }
            }
        }

        // $this->associateValue();
    }

    public function isSubmit(): bool
    {
        return $this->isSubmit;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function setModel(Model $model): self
    {
        $this->model = $model;
        return $this;
    }
    
    public function getModel(): Model
    {
        return $this->model;
    }

    public function getBuilder()
    {
        return $this->builder;
    }

    public function setBuilder(): FormBuilder
    {
        $this->builder = new FormBuilder();

        return $this->builder->setFormName($this->name);
    }

    public function addConfig(string $key, $newConfig): self
    {
        $this->config[$key] = $newConfig;

        return $this;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}