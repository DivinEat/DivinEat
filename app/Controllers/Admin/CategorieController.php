<?php

namespace App\Controllers\Admin;

use App\Models\Categorie;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Managers\CategorieManager;
use App\Core\Controller\Controller;
use App\Forms\Categorie\CreateCategorieForm;
use App\Forms\Categorie\UpdateCategorieForm;

class CategorieController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $response->render("admin.categorie.index", "admin", [
            "categorieData" => $this->getCategorieData()
        ]);
    }

    public function create(Request $request, Response $response, array $args)
    {
        $form = $response->createForm(CreateCategorieForm::class);

        $response->render("admin.categorie.create", "admin", ["createCategorieForm" => $form]);
    }

    public function store(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('createCategorieForm_');

        $fields = $request->getParams(["name", "slug"]);

        $object = (new Categorie())->hydrate($fields);

        $form = $response->createForm(CreateCategorieForm::class, $object);

        if (false === $form->handle($request))
            return $response->render("admin.categorie.create", "admin", ["createCategorieForm" => $form]);

        (new CategorieManager())->save($object);
        return Router::redirect('admin.categorie.index');
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $categorie = (new CategorieManager())->find($args['categorie_id']);
        if (null === $categorie)
            return Router::redirect('admin.categorie.index');

        $form = $response->createForm(UpdateCategorieForm::class, $categorie);

        $response->render("admin.categorie.edit", "admin", ["updateCategorieForm" => $form]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $request->setInputPrefix('updateCategorieForm_');
        $categorieManager = new CategorieManager();
        if (null === $categorieManager->find($args['categorie_id']))
            return Router::redirect('admin.article.index');

        $categorie = (new Categorie())->hydrate($request->getParams(['name', 'slug']));

        $categorie->setId($args['categorie_id']);

        $form = $response->createForm(UpdateCategorieForm::class, $categorie);

        if (false === $form->handle($request))
            return $response->render("admin.categorie.edit", "admin", ["updateCategorieForm" => $form]);

        $categorieManager->save($categorie);

        return Router::redirect('admin.categorie.edit', [$args['categorie_id']]);
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        (new CategorieManager())->delete($args["article_id"]);
        Router::redirect('admin.article.index');
    }

    private function getCategorieData(): array
    {
        $datas = (new CategorieManager())->findAll();

        $dataCategorie = [];
        foreach ($datas as $data) {
            if ("default" !== $data->getSlug()) {
                $dataCategorie[] = [
                    "name" => $data->getName(),
                    "slug" => $data->getSlug(),
                    "edit" => Router::getRouteByName('admin.categorie.edit', $data->getId()),
                    "destroy" => Router::getRouteByName('admin.article.destroy', $data->getId())
                ];
            } else {
                $dataCategorie[] = [
                    "name" => $data->getName(),
                    "slug" => $data->getSlug(),
                    "edit" => Router::getRouteByName('admin.categorie.edit', $data->getId())
                ];
            }
        }

        $data = [
            "config" => [
                "class" => "admin-table"
            ],

            "colonnes" => [
                "Catégorie",
                "Nom",
                "Slug",
                "Actions"
            ],

            "fields" => [
                "Configuration" => $dataCategorie
            ]
        ];

        return $data;
    }
}
