<?php

namespace App\Models;

use App\Models\Page;
use App\Core\Model\Model;
use App\Core\Model\ModelInterface;

class NavbarElement extends Model implements ModelInterface
{
    protected $name;
    protected $page;
    protected $slug;
    protected $date_inserted;
    protected $date_updated;

    public function __construct()
    {
        parent::__construct();
    }

    public function initRelation(): array
    {
        return ['page' => Page::class];
    }


    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setPage(Model $page): self
    {
        $this->page = $page;
        return $this;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
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

    public function getName(): ?string
    {
        return $this->name;
    }
    public function getPage(): Page
    {
        return $this->page;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
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
