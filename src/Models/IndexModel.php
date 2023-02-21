<?php
/**
 *  Home page model.
 *
 * @package 'server.robertocannella.com'
 */
namespace App\Models;

class IndexModel {
    private $message = 'Welcome to Home page.';

    public function __construct(){
    }
    public function welcomeMessage(){
        return $this->message;
    }
}