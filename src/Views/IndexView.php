<?php
/**
 *  Home page view.
 *
 * @package 'server.robertocannella.com'
 */

namespace App\Views;

class IndexView{
    private $model;
    private $controller;

    public function __construct($controller,$model)
    {
        $this->model = $model;
        $this->controller = $controller;

        print ("Home - ");
    }

    public function index(){
        return $this->controller->sayWelcome();
    }
    public function action(){
        return $this->controller->takeAction();
    }
}