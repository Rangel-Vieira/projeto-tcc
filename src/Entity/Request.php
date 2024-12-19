<?php 

namespace Rangel\Tcc\Entity;

class Request{
    
    private readonly ?string $path;
    private readonly ?string $method;
    private readonly ?array $params;
    private readonly ?array $files;
    private readonly ?bool $serverRequest;

    public function __construct(string $path, string $method, array $params = null, array $files = null, $serverRequest = false){
        $this->path = $path;
        $this->method = $method;
        $this->params = $params;
        $this->files = $files;
        $this->serverRequest = $serverRequest;
    }

    public function __toString(){
        return $this->method . '|' . $this->path;
    }

    public function getPath(){
        return $this->path;
    }

    public function getMethod(){
        return $this->method;
    }

    public function getRequestParams(){
        return $this->params;
    }

    public function getRequestParam(string $param){
        return $this->params[$param] ?? null;
    }

    public function getRequestFiles(){
        return $this->files;
    }

    public function getRequestFile(string $file){
        return $this->files[$file] ?? null;
    }

    public function isServerRequest(){
        return $this->serverRequest;
    }

}