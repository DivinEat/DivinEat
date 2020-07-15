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

        $file = $request->get("file");

        if($file["error"] !== 0) 
            $form->addErrors(["error" => "Impossible de téléverser le fichier !"]);  
        
        if (false === $form->handle($request))
            return $response->render("admin.image.create", "admin", ["createImageForm" => $form]);

        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);

        $path = uniqid() . "." . $ext;

        if(move_uploaded_file($file["tmp_name"], "img/uploadedImages/" . $path)){
            $image = (new ImageManager())->create([
                'name' => $file["name"],
                'path' => $path,
            ]);
        }

        Router::redirect('admin.image.index');
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $manager = new ImageManager();

        $image = $manager->find($args["image_id"]);

        unlink("img/uploadedImages/" . $image->getPath());

        $manager->delete($args["image_id"]);

        Router::redirect('admin.image.index');
    }
}