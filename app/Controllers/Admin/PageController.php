<?php

namespace App\Controllers\Admin;

use App\Core\View;


use App\Models\Page;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Managers\PageManager;
use App\Core\Controller\Controller;

class PageController extends Controller
{
    private string $_dataString;
    private object $_dataObject;
    private string $_dataHTML;

    public function __construct()
    {
        $this->_dataHTML = '';
    }

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
        $response->render('admin.page.create', 'admin');
    }

    public function store(Request $request, Response $response): void
    {
        if (null === $request->get('page_data'))
            die("probleme pas de data");

        $this->_dataString = $request->get('page_data');

        $this->getHTMLPageData();
        $pageManager = new PageManager();

        $page = $pageManager->create([
            'title' => 'Ma page',
            'data' => $this->_dataHTML,
        ]);

        Router::redirect('admin.page.index');
    }

    public function getHTMLPageData(): void
    {
        $this->_dataObject = json_decode($this->_dataString);

        $page = $this->_dataObject->page;

        $first = $page->first;
        $first = $this->_dataObject->$first;

        $this->blou($first);
    }


    /**
     * add HTML content to the html data page (_dataHTML)
     * 
     */
    private function blou(object $element): void
    {
        $type = $element->type;
        if ($type === 'row') {
            if (NULL === $element->first)
                return;

            $this->_dataHTML .= $this->getRowHTML();
            $first = $element->first;

            $this->blou($this->_dataObject->$first);

            $this->_dataHTML .= $this->getEndDivHTML();
        }

        if ($type === 'childRow') {
            if (NULL === $element->first)
                return;

            $this->_dataHTML .= $this->getChildRowHTML();
            $first = $element->first;

            $this->blou($this->_dataObject->$first);

            $this->_dataHTML .= $this->getEndDivHTML();
            $this->_dataHTML .= $this->getEndDivHTML();
        }

        if ($type === 'container')
            $this->_dataHTML .= $this->getContainerHTML($element);

        $next = $element->next;

        if (NULL === $next)
            return;

        $this->blou($this->_dataObject->$next);

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

    private function getChildRowHTML(): string
    {
        $containerHTML = '';

        $containerHTML .= "<div class='col-sm-12 padding-0'>";
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
