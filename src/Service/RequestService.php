<?php 

namespace Rangel\Tcc\Service;
use Rangel\Libs\Objectfy\Objectfy;
use Rangel\Tcc\Entity\Request;

class RequestService {

    public static function getRequest(): Request{
        $request = self::userRequest();;

        return $request;
    }

    private static function userRequest(): Request{
        $path_info = $_SERVER['PATH_INFO'] ?? '/';
        $request_method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $params = $request_method === 'GET' ? $_GET : $_POST;
        $files = $request_method === 'POST' ? $_FILES : [];

        return new Request($path_info, $request_method, $params, $files);
    }

}