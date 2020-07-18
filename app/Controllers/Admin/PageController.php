<?php

namespace App\Controllers\Admin;

use App\Core\View;


use App\Models\Page;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Managers\PageManager;
use App\Core\Builder\QueryBuilder;
use App\Forms\Page\CreatePageForm;
use App\Core\Controller\Controller;
use App\Managers\NavbarElementManager;

class PageController extends Controller
{
    private object $_dataObject;
    private string $_dataHTML;

    public function index(Request $request, Response $response)
    {
        $response->render('admin.page.index', 'admin', ['dataIndex' => $this->getIndexModalData()]);
    }

    public function show(Request $request, Response $response)
    {
        $this->_view = new View("pageBuilder");
    }

    public function create(Request $request, Response $response)
    {
        $form = $response->createForm(CreatePageForm::class);
        $response->render('admin.page.create', 'admin', ["createPageForm" => $form]);
    }

    public function store(Request $request, Response $response): void
    {
        $request->setInputPrefix('createPageForm_');

        $page = (new Page())->hydrate($request->getParams(["title", "data"]));

        $form = $response->createForm(CreatePageForm::class, $page);

        if (false === $form->handle($request)) {
            $response->render('admin.page.create', 'admin', ["createPageForm" => $form]);
        } else {
            (new PageManager())->save($page);
            Router::redirect('admin.page.index');
        }
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        (new QueryBuilder())
            ->delete("navbar_elements")
            ->where("`page` = {$args["page_id"]}")
            ->getQuery();

        (new PageManager())->delete($args["page_id"]);

        return Router::redirect('admin.page.index');
    }

    public function displayPageContent(Request $request, Response $response)
    {
        preg_match('/\/(.*)$/', $request->getCurrentRoute()->getPath(), $match);

        if (empty($match[1]))
            return Router::redirect('home');

        $navbarElement = current((new NavbarElementManager())->findBy(["slug" => $match[1]]));

        if (false === $navbarElement)
            return Router::redirect('not.found');

        $page = $navbarElement->getPage();
        $data = $page->getData();
        $this->getHTMLPageData($data);

        $response->render('custom_page', 'main', ['page' => $this->_dataHTML]);
    }

    public function getHTMLPageData(string $data): void
    {
        $this->_dataObject = json_decode($data);

        $page = $this->_dataObject->page;
        $first = $page->first;
        $first = $this->_dataObject->$first;

        $this->_dataHTML = '';
        $this->generateHTML($first);
    }

    /**
     * add HTML content to the html data page (_dataHTML)
     * 
     */
    private function generateHTML(object $element): void
    {
        $type = $element->type;
        if ($type === 'row') {
            if (NULL === $element->first)
                return;

            $this->_dataHTML .= $this->getRowHTML();
            $first = $element->first;

            $this->generateHTML($this->_dataObject->$first);

            $this->_dataHTML .= $this->getEndDivHTML();
        }

        if ($type === 'childRow') {
            if (NULL === $element->first)
                return;

            $this->_dataHTML .= $this->getChildRowHTML($element);
            $first = $element->first;

            $this->generateHTML($this->_dataObject->$first);

            $this->_dataHTML .= $this->getEndDivHTML();
            $this->_dataHTML .= $this->getEndDivHTML();
            $this->_dataHTML .= $this->getEndDivHTML();
        }

        if ($type === 'container')
            $this->_dataHTML .= $this->getContainerHTML($element);

        $next = $element->next;

        if (NULL === $next)
            return;

        $this->generateHTML($this->_dataObject->$next);

        return;
    }

    private function getRowHTML(): string
    {
        return '<div class="row padding-0">';
    }

    private function getEndDivHTML(): string
    {
        return '</div>';
    }

    private function getContainerHTML(object $element): string
    {
        $containerHTML = '';

        $containerHTML .= "<div class='$element->class'>";
        $containerHTML .= '<div class="col-inner padding-0">';
        $containerHTML .= $element->content;
        $containerHTML .= $this->getEndDivHTML();
        $containerHTML .= $this->getEndDivHTML();

        return $containerHTML;
    }

    private function getChildRowHTML(object $element): string
    {
        $containerHTML = '';

        $containerHTML .= "<div class='$element->class'>";
        $containerHTML .= '<div class="col-inner padding-0">';
        $containerHTML .= '<div class="row padding-0">';

        return $containerHTML;
    }

    private function getIndexModalData()
    {
        $pages = (new PageManager())->findAll();

        $pagesData = [];
        foreach ($pages as $page) {
            $pagesData[] = [
                "title" => $page->getTitle(),
                "edit" => Router::getRouteByName('admin.page.edit', $page->getId()),
                "destroy" => Router::getRouteByName('admin.page.destroy', $page->getId())
            ];
        }

        $data = [
            "config" => [
                "class" => "admin-table"
            ],

            "colonnes" => [
                "Catégorie",
                "Titre",
                "Actions",
            ],

            "fields" => [
                "Page" => $pagesData
            ]
        ];

        return $data;
    }
}
