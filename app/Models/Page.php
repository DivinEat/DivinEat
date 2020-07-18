<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;

class Page extends Model implements ModelInterface
{
    protected $title;
    protected $data;
    protected $date_inserted;
    protected $date_updated;

    public function __construct()
    {
        parent::__construct();
    }

    public function initRelation(): array
    {
        return [];
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
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
    public function setDate_inserted($date_inserted): self
    {
        $this->date_inserted = $date_inserted;
        return $this;
    }
    public function setDate_updated($date_updated): self
    {
        $this->date_updated = $date_updated;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getData(): ?string
    {
        return $this->data;
    }
    public function getDate_inserted()
    {
        return $this->date_inserted;
    }
    public function getDate_updated()
    {
        return $this->date_updated;
    }
}
