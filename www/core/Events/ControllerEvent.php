<?php

namespace App\Core\Events;

use App\models\User;
use SplObserver;
use SplSubject;

class ControllerEvent implements SplObserver
{

    public function __construct(){}
    /**
     * @var SplSubject[]
     */
    private $controllers = [];

    public function update(SplSubject $subject)
    {
        $this->controllers[] = clone $subject;
    }

    /**
     * @return SplSubject[]
     */
    public function getChangedController(): array
    {
        return $this->controllers;
    }

    public function logged(string $uri): void
    {
        echo "Url appelé ( $uri ) le ". date('Y-m-d H:i');
    }
}