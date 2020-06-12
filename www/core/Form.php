<?php

namespace App\core;

use App\core\Builder\FormBuilder;
use App\core\Constraints\Validator;

class Form
{
    private $builder;
    private $config = [];
    private $model;
    private $name;
    private $isSubmit = false;
    private $isValid = false;
    private $validator;
    private $errors = [];

    public function __construct()
    {
        $this->validator = new Validator();

        $this->config = [
            "method"=>"POST", 
            "action"=>"",
            "attr" => [ ]
           
        ];
    }

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

    public function handle(): void
    {
        if($_SERVER['REQUEST_METHOD'] === $this->config["method"])
        {
            $isSubmit = $this->checkIsSubmitted();
            if($isSubmit)
            {
                $this->checkIsValid();
            }

            $this->updateObject();
        }
    }

    private function checkIsSubmitted()
    {
        foreach($_POST as $key => $value)
        {
            if(FALSE !== strpos($key, $this->name))
            {
                $this->isSubmit = true;
                return true;
            }
        }

        return false;
    }

    public function checkIsValid(): void
    {
        $this->isValid = true;
       
        foreach($_POST as $key => $value)
        {
            if(FALSE !== strpos($key, $this->name))
            {
                $key = str_replace($this->name.'_', '', $key);
                
                $element = $this->builder->getElement($key);
             
                if(isset($element->getOptions()['constraints']))
                {
                    foreach($element->getOptions()['constraints'] as $constraint)
                    {
                        $responseValidator = $this->validator->checkConstraint($constraint, $value);
                       
                        if(NULL !== $responseValidator)
                        {
                            $this->isValid = false;
                            $this->errors[$key] = $responseValidator;
                        }
                    }
                }
            }
        }
    }

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

        $this->associateValue();
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

    public function setBuilder(FormBuilder $formBuilder): self
    {
        $this->builder = $formBuilder;

        return $this;
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