<?php

class IvalidPasswordException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(){
        return new self('La contraseña no puede estar vacia');
    }

    public static function becauseLengthIsToShort($min)
    {
        return new self('La contraseña debe tener al menos' . $min . ' caracteres');
    }
}