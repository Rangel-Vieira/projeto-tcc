<?php 

namespace Rangel\Tcc\Entity;

class Request{
    
    private readonly string $path;
    private readonly string $method;
    private readonly array $params;

    public function __construct(string $path, string $method, array $params){
        $this->path = $path;
        $this->method = $method;
        $this->params = $params;
    }

    public function __toString(){
        return $this->method . '|' . $this->path;
    }

    public function getRequestParams(){
        return $this->params;
    }

    public function getRequestParam(string $param){
        return $this->params[$param] ?? null;
    }

}