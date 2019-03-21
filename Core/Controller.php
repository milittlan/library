<?php

namespace Core;

/**
 * Base controller
 *
 * PHP version 5.4
 */
abstract class Controller {

    /**
     * Parameters from the matched route
     * @var array
     */

    protected $route_params = [];

    /**
     * @var array
     */

    public $errors = [];


    /**
     * Return all route params if type is not sent. If type is sent it returns specified param
     *
     * @param null $type - Type can be controler or action or id
     * @return array
     */

    public function getRouteParams($type = null)
    {
        if(isset($this->route_params[$type])) {
            return $this->route_params[$type];
        }

        return $this->route_params;

    }

    /**
     * Class constructor
     *
     * @param array $route_params  Parameters from the route
     *
     * @return void
     */

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */

    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            //echo "Method $method not found in controller " . get_class($this);
            throw new \Exception("Method $method not found in controller " .
                get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */

    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */

    protected function after()
    {
        echo "After action";
    }


    /**
     * Get errors
     * @return array
     */

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Adding errors
     * @param $error_message
     */

    public function addError($error_message)
    {
        array_push($this->errors, $error_message);
    }
}
