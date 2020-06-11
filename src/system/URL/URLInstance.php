<?php


namespace App\System\URL;


class URLInstance implements HTTPMethods {
    private $path;
    private $controller;
    private $method;

    public function __construct($url, $method, $controller) {
        $this->setPath($url);
        $this->setMethod($method);
        $this->setController($controller);
    }

    public function setController(string $controller) {
        $buf = explode('@', $controller);
        $controller_name = $buf[0];
        $controller_method = $buf[1];
        $this->controller = $controller;
    }
    public function getController() {
        return $this->controller;
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
        $this->method = $method;
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
        $this->path = $path;
    }
    public function getPath()
    {
        return $this->path;
    }
}