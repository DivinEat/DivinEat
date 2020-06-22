<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Builder\QueryBuilder;
use App\Core\View;
use App\Models\Article;
use App\Managers\ArticleManager;

class ArticleController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $articles =  (new QueryBuilder())
            ->select('*')
            ->from('articles', 'a')
            ->orderBy('id', 'DESC')
            ->getQuery()
            ->getArrayResult(Article::class);

        foreach($articles as $article){
            $article->setContent($this->setJsonToHtml($article->getContent()));
        }

        $myView = new View("article.index", "main");
        $myView->assign("articles", $articles);
    }

    public function show(Request $request, Response $response, array $args)
    {
        $id = $args["article_id"];

        $articleManager = new ArticleManager();
        $article = $articleManager->find($id);
        $article->setContent($this->setJsonToHtml($article->getContent()));

        $myView = new View("article.show", "main");
        $myView->assign("article", $article);
    }

    public function setJsonToHtml($content){
        $content = str_replace("'", "\"", $content);
        $json = json_decode($content);

        $html = "";
        foreach($json->blocks as $block){
            switch($block->type){
                case "header":
                    $html .= "<h".$block->data->level.">".$block->data->text."</h".$block->data->level.">";
                    break;
                case "paragraph":
                    $html .= "<p>".$block->data->text."</p>";
                    break;
                case "list":
                    if($block->data->style == "ordered"){
                        $html .= "<ol>";
                    } else {
                        $html .= "<ul>";
                    }
                    foreach($block->data->items as $value){
                        $html .= "<li>$value</li>";
                    }
                    if($block->data->style == "ordered"){
                        $html .= "</ol>";
                    } else {
                        $html .= "</ul>";
                    }
                    break;
            }
        }

        return $html;
    }
}