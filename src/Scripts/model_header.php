<?php
/**
 * 连数据库.
 *
 * Usage:
 *  include('model_header.php');
 *  $db = $di->get('db');
 *
 *  $sql = '...';
 *  $result = $db->query($sql);
 *  $data = $result->fetchAll();
 *
 *  $sql = '...';
 *  $bool = $db->execute($sql);
 *
 * @farwish
 */

$db_config = [ 
    'host' => 'localhost',
    'username' => 'root',       // 更改
    'password' => '123456',     // 更改
    'dbname' => 'ucenter_dev',  // 更改
    'port' => '3306',
    'charset' => 'utf8',
    'options' => [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC],
];

$di = new Phalcon\Di\FactoryDefault();

$di->set('db', function() use ($db_config) {
    return new \Phalcon\Db\Adapter\Pdo\Mysql($db_config);
});
