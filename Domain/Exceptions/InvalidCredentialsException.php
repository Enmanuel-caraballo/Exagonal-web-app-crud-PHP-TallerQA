<?php

declare(strict_types=1);
class InvalidCredentialsException extends  RuntimeException
{
    public static function becauseCredentialsAreInvalid(): self
    {
        return new self('Correo o contraseña incorrectos');
    }

    public static  function becauseIsNotActive(): self
    {
        return new self('Cuenta inactiva');
    }
}