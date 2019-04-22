<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/include.php';

/**
 * Ken Class
 * 
 *  Here is where the server exists.
 *  The server keeps track of all of the 
 *  controllers and listens for GET and
 *  POST requests. When the requests are
 *  made it pushes the data along to the
 *  right controller and that controller
 *  will fire the correct action.
 * 
 */

class Ken {

    /**
     *  request information
     * ---------------------
     * The request needs to contain these
     * values in order to be a valid request
     * the exception to this is a get request
     * 
     *  @var string $reqController
     *  @var string $reqAction
     *  @var array $payload
     * 
     */
    private $reqController;
    private $reqAction;
    private $payload;
    
    /**
     *  Configuration
     * 
     *  @var boolean $tokenValidation
     *  @var array $controller
     * 
     */
    private $tokenValidation;
    private $controllers = array();
    private $actionExemptions = array();

    /**
     *  class constructor
     *  
     *  @param array $options
     * 
     *  @todo explore more configuration options
     *        for the server.
     *  @todo having the options specified like so could pose
     *        issues when all of them are not explicitely used
     */
    public function __construct($options = ['tokenValidation' => FALSE, 'actionExemptions' => array()]) {
        if(is_bool($options['tokenValidation'])) {
            $this->tokenValidation = $options['tokenValidation'];
        }
        if(!empty($options['actionExemptions'])) {
            $this->actionExemptions = $options['actionExemptions'];
        }
    }

    /**
     * Setters
     *-----------------
     * setTokenValidation(boolean) - 
     *
     * if boolean is true token validation will 
     * be required for all protected requests
     *
     * if boolean is false token validation will 
     * never be required.
     *
     *  @param boolean $tokenValidation
     */

    protected function setTokenValidation($tokenValidation) {
        $this->tokenValidation = $tokenValidation;
    }

     /**
     * Getters
     *---------------
     * getTokenValidation()
     *
     * - returns a the tokenValidation boolean
     * this funcitons return value is passed to
     * assit in the propegation of tokenvalidation
     * for controllers
     *
     * getPayload()
     *
     * - returns the value of a payload whenever
     *  a request is made the payload field is populated
     */
    
    public function getTokenValidation() {
        return $this->tokenValidation;
    }

    public function getPayload() {
        return $this->payload;
    }

     /**
     * addController(instantiated object)
     *----------------------------------
     * - each controller is an object and 
     * has already been instatiated. 
     *
     * - this function records the controller
     * objects that will be used in the application and
     * and passes down the application token validation value.
     * 
     * - When a request is made the controller will be pulled
     * to find an aciton that matches a request in a controller
     * 
     *  @param controller $controller;
     */

    public function addController($controller) {
        // if token validation has been implemented on the server
        // implement it in each controller
        if ($this->tokenValidation) {
            $controller->setTokenValidation($this->tokenValidation);
        }
        $this->controllers[$controller->getName()] = $controller;
    }

    /**
     * isNoTokenAction()
     * -------------------
     * Checks to see if the action running does not require a token
     */

    private function isActionExemption($reqAction) {
        foreach($this->actionExemptions as $action) {
            if ($action == $reqAction) {
                return TRUE;
            }
        }
    }

    /**
     * start()
     *-----------------
     * - once start is called our server will
     * start listening for GET and POST requests
     *
     * - whenever there is a response to be sent 
     * to the client it comes back to this `echo`
     * function bellow unless there is an error
     * in this class
     */

    public function start() {
        $this->GETListener();
        $this->POSTListener();
    }

    /**
     * process()
     *------------------------------
     * - When a request is made `process` iterates
     * over each controller and compares the controller
     * name to the controller name specified in the 
     * request.
     *
     * - Once the controller is found the action
     * is then searched for inside of the controller 
     * and executed.
     */

    function process() {
        foreach ($this->controllers as $controller) {
            if($controller->getName() == $this->reqController) {
                return $controller->callAction($this->reqAction, $this->payload);
            } 
        }
        return Response::err("The " . $this->reqController . " controller does not exist");
    }

    /**
     * validateJsonPost(string)
     *---------------------------
     * - The request is a post request and we need
     * to find the controller, action, and payload
     * of the request.
     * 
     *  - Ckecks for an api token if token validation
     * is enabled.
     *
     * - **NOTE** if token validation is enabled
     * and there are certain post requests that
     * do not require the token they must be
     * specified here. One example it user
     * authentication which is preconfigured.
     * 
     * @param string $json_str
     */

    function validateJsonPost($json_str) {
        // JSON POST listener has content
        if(!empty($json_str)) {

            $reqArr = json_decode($json_str, true);
            
            $this->reqAction = filter_var($reqArr['action'], FILTER_SANITIZE_STRING);
            $this->reqController = filter_var($reqArr['controller'], FILTER_SANITIZE_STRING);
            $this->payload = $reqArr['payload'];

            if( empty($this->reqAction) || 
                empty($this->reqController)|| 
                empty($this->payload)){
                echo json_encode(response("failure", "Bad post request. Either the controller action or payload was not sent."));
                return; 
                exit;
            }

            /** 
             * A token is not required for the following requests and tokens are not 
             * required --currently-- for any get requests unless they are specifically assigned 
             * at the action level. If a request is made for an aciton other than those in
             * this logic statement a valid token is required.
             * 
             * @todo create options when creating the server for post actions that do not
             *       require token validation.
            */ 

            // Verify that token validation is used on this server
            if($this->tokenValidation) {
                if (!$this->isActionExemption($this->reqAction)) {
                    if(isset($this->payload["apiToken"])) {
                        $token = $this->payload["apiToken"];
                        $sanitizedToken = filter_var($token, FILTER_SANITIZE_STRING); // I don't think there is any reason to sanitize the token...
                    } else {
                        echo json_encode(Response::err("No token was submitted with the request. Please log back in and try again or consult your web administrator."));
                        return exit;
                    }
                }
            }

            echo json_encode($this->process());

        } else {
            echo json_encode(Response::err("failure", "Bad post request. Either the controller action or payload was not sent."));
            return;
        }
    }

    /**
     * listeners
     *-------------------------
     * GETListener()
     * - Filters the controller and aciton on a
     * GET request
     *
     * POSTListener()
     * - collects the controller and action of a 
     * request if the it is an file upload(asset)
     * request
     *
     * @todo - I need to find out how to filter
     * the file upload.
     *
     * - collects entire post request by accessing
     * the json for none asset/file upload requests
     */

    function GETListener() {
        // GET request Listener
        $this->reqController = filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_STRING);
        $this->reqAction     = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
    }

    function POSTListener() {
        /**
         * Post request Listener
         * 
         * If the controller and action have not
         * yet been populated by the GETListener
         * we have a post request.
         */
        if($this->reqController == NULL || $this->reqAction == NULL){

            /**
             * Asset Listener
             * 
             * If we can directly access the controller
             * from the $_POST object we are dealing with
             * a form.
             */
            if(isset($_POST['controller'])) {
                if(!isset($_POST['action'])) {
                    echo(json_encode(response("failure", "The specified controller or action has not been supplied.")));
                    exit;
                } else {
                    $this->reqController = filter_var($_POST['controller'], FILTER_SANITIZE_STRING);
                    $this->reqAction = filter_var($_POST['action'], FILTER_SANITIZE_STRING);
                    $this->payload = $_POST; //How do I sanitize a file upload?...
                    echo json_encode($this->process());
                }
            }

            // JSON POST Listener
            $json_str = file_get_contents('php://input');
            if(!empty($json_str)) {
                $this->validateJsonPost($json_str);
            } 
            
        } else {
            // GET payload if not a POST Request
            $this->payload = $_GET;
            if(isset($this->reqController) || isset($this->reqAction)){
                echo json_encode($this->process());
            } else {
                return;
            }
        }
    }
}
