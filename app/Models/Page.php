<?php

namespace App\Models;

use App\Core\Model\Model;
use App\Core\Model\ModelInterface;

class Page extends Model implements ModelInterface
{
    protected $id;
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
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
    public function setDate_inserted($date_inserted)
    {
        $this->date_inserted = $date_inserted;
        return $this;
    }
    public function setDate_updated($date_updated)
    {
        $this->date_updated = $date_updated;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getData()
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
