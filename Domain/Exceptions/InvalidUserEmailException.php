<?php

class InvalidUserEmailException extends  InvalidArgumentException
{
 public static function becauseFormatIsInvalid($email)
 {
     return new self('El Formato del  email es  invalido' .$email);
 }

 public static function becauseValueIsEmpty()
 {
     return new self('El email es obligatorio');
 }
}