<?php

require_once __DIR__ . "/../Exceptions/IvalidPasswordException.php";
class UserPassword
{
    private $value;

    public function __construct($value)
    {
        $normalized = trim((string) $value);

        if ($normalized === '') {
            throw IvalidPasswordException::becauseValueIsEmpty();
        }
        if (strlen($normalized) < 8) {
            throw IvalidPasswordException::becauseLengthIsTooShort(8);
        }
        $this->value = $normalized;
    }

    public function value() { return $this->value; }
    public function equals(UserPassword $other) { return $this->value === $other->value(); }
    public function __toString() { return $this->value; }

    public static function fromPlainText(string $plainText): self
    {
        return new self(password_hash($plainText, PASSWORD_BCRYPT));
    }

    public static function fromHash(string $hash): self
    {
        return new self($hash);
    }

    public function verifyPlain(string $plainText): bool
    {
        return password_verify($plainText, $this->value);
    }
}
