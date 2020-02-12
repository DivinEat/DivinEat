<?php

class TestController 
{
    public function defaultAction() {
        $view = new View("dashboard", "back");
    }
}