<?php

namespace Sunxyw\AuthmeWrapper\Encryptions;

use Sunxyw\AuthmeWrapper\AbstractEncryption;

class Pbkdf2 extends AbstractEncryption
{
    private $CHARS;

    const SALT_LENGTH = 16;
    const NUMBER_OF_ITERATIONS = 10000;

    public function __construct()
    {
        $this->CHARS = self::initCharRange();
    }

    public function isValidPassword($password, $hash)
    {
        $parts = explode('$', $hash);
        return count($parts) === 4 && $hash === $this->computeHash($parts[1], $parts[2], $password);
    }

    public function hash($password)
    {
        $salt = $this->generateSalt();
        return $this->computeHash(self::NUMBER_OF_ITERATIONS, $salt, $password);
    }

    private function computeHash($iterations, $salt, $password)
    {
        return 'pbkdf2_sha256$' . $iterations . '$' . $salt
            . '$' . hash_pbkdf2('sha256', $password, $salt, $iterations, 64, false);
    }

    private function generateSalt()
    {
        $maxCharIndex = count($this->CHARS) - 1;
        $salt = '';
        for ($i = 0; $i < self::SALT_LENGTH; ++$i) {
            $salt .= $this->CHARS[mt_rand(0, $maxCharIndex)];
        }
        return $salt;
    }

    private static function initCharRange()
    {
        return array_merge(range('0', '9'), range('a', 'f'));
    }
}
