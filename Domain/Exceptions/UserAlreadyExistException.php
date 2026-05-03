<?php

class UserAlreadyExistException extends DomainException
{

    public static function becauseEmailAlreadyExists(){
        return new self('No se encontro usuario con el email: ');
    }
}