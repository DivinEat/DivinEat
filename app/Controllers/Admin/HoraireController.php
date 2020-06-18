<?php

namespace App\Controllers\Admin;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\View;
use App\Models\Horaire;
use App\Managers\HoraireManager;

class HoraireController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $horaireManager = new HoraireManager();
        $horaires = $horaireManager->findAll();

        $configTableHoraire = Horaire::getShowHoraireTable($horaires);

        $myView = new View("admin.horaire.index", "admin");
        $myView->assign("configTableHoraire", $configTableHoraire);
    }

    public function create(Request $request, Response $response, array $args)
    {
        $configFormHoraire = Horaire::getAddHoraireForm();
        $horaireManager = new HoraireManager();
        $horaires = $horaireManager->findAll();

        $myView = new View("admin.horaire.create", "admin");
        $myView->assign("configFormHoraire", $configFormHoraire);
        $myView->assign("horaires", $horaires);
    }

    public function store(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        $object = new Horaire();
        $object->setHoraire($data['horaire']);

        $manager = new HoraireManager();
        $manager->save($object);

        Router::redirect('admin.horairecreate');

    }

    public function edit(Request $request, Response $response, array $args)
    {
        $id = 2;

        if(isset($id)){
            $horaireManager = new HoraireManager();
            $object = $horaireManager->find($id);
        }

        $configFormHoraire = Horaire::getEditHoraireForm($object);

        $myView = new View("admin.horaire.edit", "admin");
        $myView->assign("configFormHoraire", $configFormHoraire);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        $horaireManager = new HoraireManager();
        $horaire = $horaireManager->find($data["id"]);
        
        $horaire->setHoraire($data["horaire"]);

        $horaireManager->save($horaire);

        Router::redirect('admin.horaireindex');
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $data = $_POST;

        $manager = new HoraireManager();
        $manager->delete($data["id"]);

        Router::redirect('admin.horaireindex');
    }
}