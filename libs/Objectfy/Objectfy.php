<?php 

namespace Rangel\Libs\Objectfy;
use ReflectionClass;
use Exception;

//TODO: Tem como melhorar essa classe colocando para pegar as chaves por recursão... Ela só obtém no primeiro nível
class Objectfy {

    public static function getArrayKeys(array $object, string $prefix = ''): array{
        $keys = [];

        foreach($object as $key => $values){
            $keys[] = $prefix . $key;
        }

        return $keys;
    }

    public static function getObjectKeysAndValues(object $object): array{

        $objectReflection = new ReflectionClass($object);
        $properties = $objectReflection->getProperties();
        $keyAndValues = array();

        foreach($properties as $property){
            $property->setAccessible(true);

            $keyAndValues[$property->getName()] = $property->getValue($object);
        }

        $properties = get_object_vars($object);
        foreach($properties as $key => $value){
            $keyAndValues[$key] = $value;
        }

        return $keyAndValues;
    }

    public static function checkIfObjectIsValid($object, $allowedList = ['NULL', 'string', 'integer', 'double']): bool{
        $objVals = self::getObjectKeysAndValues($object);

        foreach($objVals as $objVal){
            if(!in_array(gettype($objVal), $allowedList)){
                throw new Exception('O tipo ' . gettype($objVal) . ' não é suportado. Tipos permitidos nos atributos do objeto pai: ' . implode(', ', $allowedList));
            }
        }
        
        return true;
    }

    /**
     * Recebe o mapeamento e um array para converter
     * @param array $convertion ex ['input-id' => 'id', ['input-text'] => 'description']
     * @param array $origin ex ['input-id' => valor, 'input-text' => valor]
     * @return array um objeto do tipo $class com os atributos e valores
     */
    public static function parseArray(array $convertion, array $origin): array{
        $arr = [];

        foreach($origin as $key => $value){
            if(!key_exists($key, $convertion)){
                throw new Exception('A chave ' . $key . ' não está presente no array de conversão ($convertion).');
            }

            $key = $convertion[$key];
            $arr[$key] = $value;
        }

        return $arr;
    }

    /**
     *  Converte um array em uma classe (A classe deve ter um construtor que não recebe parâmetros)
     *  @param array $origin recebe um array com os atributos da classe
     *  @param string $class recebe a classe do objeto de retorno, ex Class::class
     */
    public static function arrayToClass(array $origin, string $class): object | null{
        $parsed = new $class();
        $refObj = new ReflectionClass($parsed);
        
        if(!class_exists($class)){
            throw new Exception('A classe ' . $class . ' não foi encontrada');
        }

        foreach($refObj->getProperties() as $prop){
            $prop->setAccessible(true);
            $prop->setValue($parsed, $origin[$prop->getName()]);
        }

        return $parsed;
    }
}