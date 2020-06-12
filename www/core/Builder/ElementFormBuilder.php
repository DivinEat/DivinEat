<?php

namespace App\core\Builder;

class ElementFormBuilder implements ElementFormBuilderInterface
{
    private $name;

    private $type;

    private $options;

    public function __construct()
    {
        $this->options = [];
    }

    public function setValue(string $key, string $value): ElementFormBuilderInterface
    {
        $this->options['value'] = $value;

        return $this;
    }

    public function setName(string $name): ElementFormBuilderInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setType(string $type): ElementFormBuilderInterface
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setOptions(array $options): ElementFormBuilderInterface
    {
        $this->options = $options;

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

}