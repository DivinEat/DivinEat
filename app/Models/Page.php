<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;

class Page extends Model implements ModelInterface
{
    protected $title;
    protected $data;

    public function __construct()
    {
        parent::__construct();
    }

    public function initRelation(): array
    {
        return [];
    }
    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }
    public function setData($data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getData(): ?string
    {
        return htmlspecialchars_decode($this->data);
    }
}
