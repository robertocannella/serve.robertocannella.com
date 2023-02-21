<?php
/**
 *  Home page controller.
 *
 * @package 'server.robertocannella.com'
 */
namespace App\Controllers;

class IndexController {
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
    public function sayWelcome(){
        return $this->model->welcomeMessage();
    }
}