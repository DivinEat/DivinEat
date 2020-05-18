<?php 

class PageBuilderController
{
    private $_pageData;
    private $_view;

    public function defaultAction() {
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

    public function addTextAreaEditorAction() {
        echo file_get_contents("views/modals/textEditor.php");
    }
}