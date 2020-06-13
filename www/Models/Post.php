<?php

namespace App\Models;

use App\Core\Model;
use App\Core\helpers;
use App\Models\User;

class Post extends Model
{
    protected $id;
    protected $author;
    protected $title;

    public function __construct()
    {
        parent::__construct();
    }

    public function initRelation(): array
    {
       return [
           'author' => User::class
       ];
    }

    public function setId(int $id): self
    {
        $this->id=$id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $user): self
    {
        $this->author = $user;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
}












