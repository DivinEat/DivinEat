<?php

namespace App\Core;

class StringValue
{
    private string $string;
    private $value;

    public function __construct(?string $string = null, $value = null)
    {
        $this->string = $string;
        $this->value = $value;
    }

    public function setString(string $string): StringValue
    {
        $this->string = $string;
        return $this;
    }

    public function getString(): ?string
    {
        return $this->string;
    }

    public function setValue($value): StringValue
    {
        $this->value = $value;
        return $this;
    }

    public function getvalue()
    {
        return $this->value;
    }
}