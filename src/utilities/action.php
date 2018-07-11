<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

class Action
{
    public $name;
    public $action;

    function __construct($name, $action) {
        $this->name = $name;
        $this->action = $action;
    }

    function getName() {
        return $this->name;
    }

    function __call($name, $arguments) {
        return call_user_func_array($this->action, $arguments);
    }
}