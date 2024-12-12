<?php 

namespace Rangel\Libs\SecureSql;

class SecureSql {
    
    public static function removeUnsafeChars(string $text, $unsafes = ['\'', ';', '"', "`"]): string{

        foreach($unsafes as $unsafe){
            $text = str_replace($unsafe, '', $text);
        }

        return $text;
    }
}