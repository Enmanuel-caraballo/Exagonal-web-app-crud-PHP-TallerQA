<?php

class InvalidUserRolException extends InvalidArgumentException
{
    public static function becauseValueIsInvalid($value)
    {
        return new self('El rol '. $value . 'es invalido');
    }
}