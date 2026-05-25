<?php
use Phalcon\Config\Config;
use Phalcon\Di\Di;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di\FactoryDefault;
parse_str('userID=test', $_GET);
$di = new FactoryDefault();
$di->setShared('config', function () {
return new \Phalcon\Config\Config([
    'userSlaveDatabase' => [
        [
            'host'        => 'localhost',
            'port'        => 3306,
            'username'    => 'root',
            'password'    => '',
            'dbname'      => 'user1',
            'charset'     => 'utf8',
            'options'     => [
                PDO::ATTR_STRINGIFY_FETCHES => false,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => true,
            ],
        ],
    ],
    'db' => [
        'adapter' => 'Mysql',
        'dividing_key' => 'user_id',
        'set_null' => false, 
        'prevent_updating_by_old_value' => true,
    ]
]);});
$config = $di->get('config');
foreach ($config->userSlaveDatabase as $key => $setting) {
    $di->setShared("slavedb$key", function () use ($di, $setting, $config, $key) {
        $class  = 'Phalcon\\Db\\Adapter\\Pdo\\' . $config->db->adapter;
        $params = [
            'host'       => $setting->host,
            'port'       => $setting->port,
            'username'   => $setting->username,
            'password'   => $setting->password,
            'dbname'     => $setting->dbname,
            'charset'    => $setting->charset,
            'options'    => (array)$setting->options,
        ];
        $connection = new $class($params);
        return $connection;
    });
}
New Code
if (is_numeric($_GET["userID"])) {
    return null;
}
$sql = "select * from user where user_id = \"" . $_GET["userID"] . "\";";
$pdo1 = Di::getDefault()->get("slavedb0");
$statement = $pdo1->prepare($sql);
$statement->execute([]);