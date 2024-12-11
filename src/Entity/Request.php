<?php 

namespace Rangel\Tcc\Entity;

class Request{
    
    private readonly string $path;
    private readonly string $method;

    public function __construct(string $path, string $method){
        $this->path = $path;
        $this->method = $method;
    }
}