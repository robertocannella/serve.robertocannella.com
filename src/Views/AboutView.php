<?php
/**
 *  About page view.
 *
 * @package 'server.robertocannella.com'
 */

namespace App\Views;

class AboutView
{

    public $modelObj;

    public $controller;

    function __construct($controller, $model)
    {
        $this->controller = $controller;

        $this->modelObj = $model;

        print "About - ";
    }

    public function now()
    {
        return $this->modelObj->nowADays();
    }

    public function today()
    {
        return $this->controller->current();
    }

}