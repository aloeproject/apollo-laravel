<?php


namespace Sunaloe\ApolloLaravel;


class ApolloVariable
{
    protected $immutable;

    public function __construct($immutable = false)
    {
        $this->immutable = $immutable;
    }

    /**
     * @param $name
     * @return array|false|null|string
     */
    public function getEnvironmentVariable($name)
    {
        switch (true) {
            case array_key_exists($name, $_ENV):
                return $_ENV[$name];
            case array_key_exists($name, $_SERVER):
                return $_SERVER[$name];
            default:
                $value = getenv($name);
                return $value === false ? null : $value; // switch getenv default to null
        }
    }

    /**
     * @param $name
     * @param null $value
     */
    public function setEnvironmentVariable($name, $value = null)
    {
        if ($this->immutable && $this->getEnvironmentVariable($name) !== null) {
            return;
        }

        if (function_exists('apache_getenv') && function_exists('apache_setenv') && apache_getenv($name) !== false) {
            apache_setenv($name, $value);
        }

        if (function_exists('putenv')) {
            putenv("$name=$value");
        }

        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }

    public function clearEnvironmentVariable($name)
    {
        if ($this->immutable) {
            return;
        }

        if (function_exists('putenv')) {
            putenv($name);
        }

        unset($_ENV[$name], $_SERVER[$name]);
    }
}