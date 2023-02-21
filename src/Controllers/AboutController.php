<?php
/**
 *  About page controller.
 *
 * @package 'server.robertocannella.com'
 */

namespace App\Controllers;

class AboutController {
    public $modelObj;

    public function __construct($model)
    {
        $this->modelObj = $model;
    }

    public function current(){

        return $this->modelObj->message; //= "About us today changed by the aboutController";
    }
}