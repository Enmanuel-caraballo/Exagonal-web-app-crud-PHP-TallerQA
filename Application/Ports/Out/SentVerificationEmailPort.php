<?php
declare(strict_types=1);

interface SentVerificationEmailPort
{
        public function sendVerificationEmail(string $email, string $name, string $verificationToken): void;
}