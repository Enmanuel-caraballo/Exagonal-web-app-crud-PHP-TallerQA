<?php

require_once __DIR__ . '/../Exceptions/InvalidUserRolException.php';

class UserRolEnum
{

    const ADMIN = 'ADMIN';
    const MEMBER = 'MEMBER';
    const REVIEWER = 'REVIEWER';

    public static function values(){
        return array(self::ADMIN, self::MEMBER, self::REVIEWER);
    }

    public static function isValid($value)
    {
        return in_array($value, self::values(), true);
    }

    public static function ensureIsValid($value)
    {
      if(!self::isValid($value)){
          throw InvalidUserRolException::becauseValueIsInvalid($value);
      }
    }

}
