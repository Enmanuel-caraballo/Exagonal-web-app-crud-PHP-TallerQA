<?php

class UserNotFoundException extends DomainException
{
    public static function becauseIdWasNotFound(string $id)
    {
      return new self('El id del usuario ' . $id . ' no existe');
    }
}