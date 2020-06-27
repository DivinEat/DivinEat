<?php

namespace App\Core\Builder;

use App\Core\Builder\ElementFormBuilder\ElementFormBuilderInterface;

class FormBuilder implements FormBuilderInterface
{
    private $elements = [];
    private $formName;

    public function add(string $name, string $type = "input", array $options = []): FormBuilderInterface
    {
        $elementClass = "App\Core\Builder\ElementFormBuilder\\".ucfirst($type)."Element";
        
        $this->elements[$name] = 
        (new $elementClass())
            ->setId($this->formName . "_" . $name)
            ->setName($this->formName . "_" . $name)
            ->setType($type)
            ->setOptions($options);
     
        return $this;
    }

    public function remove(string $name): FormBuilderInterface
    {
        unset($this->elements[$name]);
     
        return $this;
    }

    public function getElements(): ?array
    {
        return $this->elements;
    }

    public function getElement(string $value): ?ElementFormBuilderInterface
    {
        return $this->elements[$value];
    }

    public function setValue(string $key, $value): FormBuilderInterface
    {
        $this->elements[$key]->setValue($key, $value);

        return $this;
    }

    public function getFormName(): ?string
    {
        return $this->formName;
    }

    public function setFormName(string $formName): FormBuilderInterface
    {
        $this->formName = $formName;

        return $this;
    }
}