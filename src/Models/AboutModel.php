<?php
/**
 *  Home page model.
 *
 * @package 'server.robertocannella.com'
 */
namespace App\Models;

class AboutModel {
    public $message;

    public function __construct(){
        $this->message = "Welcome to the of PHP MVC framework official site.";
    }
    public function welcomeMessage(){
        return $this->message;
    }
    public function nowADays()
    {
        return $this->message = "nowadays everybody wants to be a boss.";
    }
}