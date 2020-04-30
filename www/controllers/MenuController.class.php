<?php

class MenuController
{
    public function indexAction()
    {
        $myView = new View("menus", "front");
    }

    public function addAction()
    {
        $configFormMenu = menus::getAddMenuForm();
        $configTableMenu = menus::getShowMenuTable();

        $myView = new View("admin_add_menus", "back");
        $myView->assign("configFormMenu", $configFormMenu);
        $myView->assign("configTableMenu", $configTableMenu);
    }

    public function showAction()
    {
        $configTableMenu = menus::getShowMenuTable();

        $myView = new View("admin_add_menus", "back");
        $myView->assign("configTableMenu", $configTableMenu);
    }

}
