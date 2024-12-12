<?php 

namespace Rangel\Libs\Objectfy;
use ReflectionClass;
use Exception;

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
}