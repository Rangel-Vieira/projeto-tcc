<?php 

namespace Rangel\Tcc\Service;
use Rangel\Tcc\Entity\Request;

class RequestService {

    public static function getRequest(): Request{
        $path_info = $_SERVER['PATH_INFO'] ?? '/';
        $request_method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $params = $request_method === 'GET' ? $_GET : $_POST;
        $files = $request_method === 'POST' ? $_FILES : [];

        return new Request($path_info, $request_method, $params, $files);
    }

}