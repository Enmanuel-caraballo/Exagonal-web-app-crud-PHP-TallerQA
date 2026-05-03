<?php

require_once __DIR__ . "/../Exceptions/InvalidUserNameException.php";
class UserName
{
    private $value;

    private int $MIN_LENGTH_USER_NAME = 3;

    public function __construct( $value){

        $normalized = trim((string)$value);

        if($normalized === ''){
            throw InvalidUserNameException::becauseValueIsEmpty();
        }

        if(mb_strlen($normalized) < $this->MIN_LENGTH_USER_NAME){
            throw InvalidUserNameException::becauseIsToShort($this->MIN_LENGTH_USER_NAME);
        }

        $this->value = $normalized;

    }

    public function value(): string
    { return $this->value; }
    public function equals(UserName $other){ return $this->value === $other->value(); }
    public function __toString(){return $this->value; }
}