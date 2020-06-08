<?php 

namespace App\Controllers;

use App\Core\View;


use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;

class PageBuilderController extends Controller
{
    private $_pageData;
    private $_view;

    public function show(Request $request, Response $response) {
        $this->_view = new View("pageBuilder");
    }


    public function getPageData() {
        return $this->_pageData;
    }

    /**
     * Permet de créer le code html de la page à partir de $data
     * 
     * @param string $data Données de la page au format JSON
     */ 
    public function createPageData($pageData) {
        return $this->_pageData = $pageData;
    }

    public function addTextAreaEditor() {
        echo file_get_contents("/ressources/views/modals/textEditor.php");
    }
}