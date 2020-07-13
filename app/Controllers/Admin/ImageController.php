<?php

namespace App\Controllers\Admin;

use App\Models\Image;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Managers\ImageManager;
use App\Core\Controller\Controller;
use App\Forms\Image\CreateImageForm;

class ImageController extends Controller
{
    
    public function index(Request $request, Response $response)
    {
        $imageManager = new ImageManager();
        $images = $imageManager->findAll();

        $configTableImage = Image::getShowImageTable($images);

        $response->render("admin.image.index", "admin", ["configTableImage" => $configTableImage]);
    }

    public function create(Request $request, Response $response)
    {
        $form = $response->createForm(CreateImageForm::class);

        $response->render("admin.image.create", "admin", ["createImageForm" => $form]);
    }

    public function store(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('createImageForm_');
        
        $form = $response->createForm(CreateImageForm::class);
        
        if (false === $form->handle($request)) {
            $response->render("admin.image.create", "admin", ["createImageForm" => $form]);
        } else {
            $file = $request->get("createImageForm_file");

            $type = explode("/", $file["type"]);
            $type = ucwords(end($type));

            $image = (new ImageManager())->create([
                'nom' => $file["name"],
                'path' => (string) uniqid() . "." . $type,
            ]);

            //Upload l'image dans les fichiers

            Router::redirect('admin.image.index');
        }
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        /*Router::redirect('admin.menu.index');*/
    }
}