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

        $myView = new View("admin_menu_add", "back");
        $myView->assign("configFormMenu", $configFormMenu);
    }

    public function showAction()
    {
        $configTableMenu = menus::getShowMenuTable();

        $myView = new View("admin_menu", "back");
        $myView->assign("configTableMenu", $configTableMenu);
    }

    public function editAction()
    {
        $configFormMenu = menus::getAddMenuForm();

        $myView = new View("admin_menu_edit", "back");
        $myView->assign("configFormMenu", $configFormMenu);
    }
}
