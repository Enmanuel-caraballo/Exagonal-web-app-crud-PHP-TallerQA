<?php

class InvalidUserNameException extends InvalidArgumentException
{
    public  static function becauseValueIsEmpty(){
        return new self('El nombre de usuario no puede ser vacio');
    }

    public  static function becauseIsToShort($min){
        return new self('El nombre de usuario debe tener al menos' . $min . ' caracteres');
    }
}