<?php 

namespace Rangel\Tcc\Service;
use Rangel\Libs\Objectfy\Objectfy;
use Rangel\Tcc\Entity\Request;

class RequestService {

    public static function getRequest(): Request{
        if(!isset($_SESSION['SERVER_REQUEST'])){
            $request = self::userRequest();
        }else{
            $request = self::serverRequest();
        }

        return $request;
    }

    private static function userRequest(): Request{
        $path_info      = $_SERVER['PATH_INFO']      ?? '/';
        $request_method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $params         = $request_method === 'GET'   ? $_GET : $_POST;
        $files          = $request_method === 'POST'  ? $_FILES : [];

        return new Request($path_info, $request_method, $params, $files);
    }

    private static function serverRequest(): Request{
        $path_info      = $_SESSION['SERVER_REQUEST']['path']   ?? '/';
        $request_method = $_SESSION['SERVER_REQUEST']['method'] ?? 'GET';
        $params         = $_SESSION['SERVER_REQUEST']['params'] ?? [];
        $files          = $_SESSION['SERVER_REQUEST']['files']  ?? [];

        $request = new Request($path_info, $request_method, $params, $files, true);
        unset($_SESSION['SERVER_REQUEST']);

        return $request;
    }

}