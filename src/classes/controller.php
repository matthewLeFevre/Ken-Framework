<?php
class Controller
{
    public $name;
    public $actions = array();

    function __construct($name) {
        $this->name = $name;
    }
    function getName() {
        return $this->name;
    }
    function addAction($actionName, $actionFunc) {
        $this->$actions[$actionName] = new Action($actionName, $actionFunc);
    }
    function callAction($action, $params) {
        for ($this->$actions as $storedAction) {
            if($storedAction === $action) {
                // return $storedAction->action($params);
                return $storedAction($params);
            }
        }
        return response("failure", "The specified action has not been defined.");
    }
}

class Action
{
    public $name;
    public $action;

    function __construct($name, $action) {
        $this->name = $name;
        $this->action = $action;
    }

    function __call($arguments) {
        return call_user_func_array($this->action, $arguments);
    }
}

// test

$hello = new Controller("hello");

$hello->addAction("world", function($params) {
    return params;
});

$hello->callAction("world", "how are you doing");