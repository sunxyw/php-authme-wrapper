<?php

namespace Sunxyw\AuthmeWrapper;

use InvalidArgumentException;

class Wrapper
{
    private static $instance = null;
    public static $supportedEncryptions = [
        'Bcrypt', 'Pbkdf2', 'Sha256'
    ];
    protected $usingEncryption = 'Sha256';

    /**
     * Using Encryption Instance
     *
     * @var AbstractEncryption
     */
    protected $encryption = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * Get authme wrapper instance
     *
     * @return Wrapper
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Choose which encryption you want to use
     *
     * @param String $encryption See $supportedEncryptions
     * @return Wrapper
     */
    public function use($encryption)
    {
        if (in_array($encryption, self::$supportedEncryptions)) {
            $this->usingEncryption = $encryption;
            $class = 'Sunxyw\\AuthmeWrapper\\Encryptions\\' . $encryption;
            $this->encryption = new $class;
            return $this;
        }

        throw new InvalidArgumentException(`Provided encryption '{$encryption}' not supported.`);
    }

    /**
     * Get encryption class or new it
     *
     * @return AbstractEncryption
     */
    protected function getOrNewEncryption()
    {
        if (is_null($this->encryption)) {
            $class = 'Sunxyw\\AuthmeWrapper\\Encryptions\\' . $this->usingEncryption;
            $this->encryption = new $class;
        }

        return $this->encryption;
    }

    /**
     * Checks whether the given password matches the hash
     *
     * @param string $password Password (usually input by user)
     * @param string $hash Hash stored in database
     * @return boolean
     */
    public function verify($password, $hash)
    {
        $encryption = $this->getOrNewEncryption();
        return $encryption->isValidPassword($password, $hash);
    }

    /**
     * Hashes the given password
     *
     * @param string $password Password to hash
     * @return string password's hash
     */
    public function hash($password)
    {
        $encryption = $this->getOrNewEncryption();
        return $encryption->hash($password);
    }
}
