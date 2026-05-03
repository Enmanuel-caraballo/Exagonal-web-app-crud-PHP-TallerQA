<?php 
class InvalidUserIdException extends InvalidArgumentException {
    public static  function becauseValueIsEmpty()
    {
      return new self('El id del usuario no puede ser vacio');
    }

}