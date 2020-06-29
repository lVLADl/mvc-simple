<?php


namespace App\System\URL;

use App\System\Exceptions\URLNameIsAlreadyUsed;
use App\System\Request;

class URLInstance implements HTTPMethods {
    private $path;
    private $controller;
    private $controller_method;
    private $method;
    protected $name;

    public function __construct($url, $method, $controller) {
        $this->setPath($url);
        $this->setMethod($method);
        $this->setController($controller);
    }

    public function setController(string $controller) {
        $buf = explode('@', $controller);
        $controller_name = $buf[0];
        $controller_method = $buf[1];

        $class = 'App\Controllers\\' . $controller_name;
        $instance = new $class;

        $this->controller = $instance;
        $this->controller_method = $controller_method;
    }
    public function call_method(Request $request) {
        $instance = $this->controller;
        $method = $this->controller_method;
        return $instance->$method($request);
    }
    public function setMethod(string $method) {
        switch ($method) {
            case 'GET':
                $this->method = HTTPMethods::GET;
                break;

            case 'POST':
                $this->method = HTTPMethods::POST;
                break;

            case 'PUT':
                $this->method = HTTPMethods::PUT;
                break;

            case 'DELETE':
                $this->method = HTTPMethods::DELETE;
                break;

            default:
                throw new \Exception("The method isn't supported.");
                break;
        }
    }
    public function getMethod() {
        $result = null;
        switch ($this->method) {
            case HTTPMethods::GET:
                $result = 'GET';
                break;

            case HTTPMethods::POST:
                $result = 'POST';
                break;

            case HTTPMethods::PUT:
                $result = 'PUT';
                break;

            case HTTPMethods::DELETE:
                $result = 'DELETE';
                break;
        }
        return $result;
    }

    public function setPath(string $path) {
        $this->path = explode('?', $path)[0];
    }
    public function getPath()
    {
        return $this->path;
    }

    public function name(string $name) {
        global $URL;
        foreach($URL as $path => $instance) {
            if(@$instance->getName() == $name) {
                throw new URLNameIsAlreadyUsed();
            }
        }

        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }
}