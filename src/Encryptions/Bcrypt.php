<?php

namespace Sunxyw\AuthmeWrapper\Encryptions;

use Sunxyw\AuthmeWrapper\AbstractEncryption;

class Bcrypt extends AbstractEncryption
{
    public function isValidPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function hash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
