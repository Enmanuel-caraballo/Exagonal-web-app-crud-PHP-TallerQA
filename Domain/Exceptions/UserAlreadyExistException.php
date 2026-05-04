<?php

class UserAlreadyExistException extends DomainException
{

    public static function becauseEmailAlreadyExists(){
        return new self('Este email ya esta siendo utilizado');
    }
}