<?php

class TestController 
{
    public function defaultAction() {
        $view = new View("home", "front");
    }

    public function bddAction() {
        $view = new View("install_bdd", "account");
    }

    public function adminAction() {
        $view = new View("install_admin", "account");
    }
}