<?php

namespace Sunxyw\AuthmeWrapper;

abstract class AbstractEncryption
{
    /**
     * Checks whether the given password matches the hash
     *
     * @param string $password Password (usually input by user)
     * @param string $hash Hash stored in database
     * @return boolean
     */
    public abstract function isValidPassword($password, $hash);

    /**
     * Hashes the given password
     *
     * @param string $password Password to hash
     * @return string password's hash
     */
    public abstract function hash($password);
}
