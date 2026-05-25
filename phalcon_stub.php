<?php
/**
 * Phalcon framework type stubs for SonarQube taint analysis.
 * Declares Di::get() return type so the DI container pattern
 * in test_di.php resolves to a concrete type for sink matching.
 */
namespace Phalcon\Di;
class Di
{
    public function get(string $name, $parameters = null): \Phalcon\Db\Adapter\Pdo\Mysql
    {
        return new \Phalcon\Db\Adapter\Pdo\Mysql();
    }
}
namespace Phalcon\Db\Adapter\Pdo;
class Mysql {}
