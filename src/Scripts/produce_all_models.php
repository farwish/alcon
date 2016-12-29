<?php

/**
 * 用于生成所有model文件的模板脚本.
 * 
 * Usage:
 *  1. 更改三处, 要生成模型的数据库名 search_database, $db_config 配置正确的 username 和 password.
 *	2. 注意修改项目 namespace 和 output.
 *	3. 在项目跟目录执行 `php vendor/farwish/alcon/src/Scripts/produce_all_models.php`
 *
 *
 * (备注)终端单条执行的命令示例:
 * phalcon model --name=members	\
 * --namespace=\Ucenter\\Frontend\\Models 	\
 * --directory=/home/www/ucenter		    \
 * --output=apps/frontend/models
 *
 * @farwish
 */

use Phalcon\Di\FactoryDefault;

const search_database = 'ucenter_dev'; // 更改

$db_config = [
	'host' => 'localhost',
	'username' => 'root',	// 更改
	'password' => '123456',	// 更改
	'dbname' => 'information_schema',
	'port' => '3306',
	'options' => [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC],
];

try {

	$di = new FactoryDefault;

	$di->set('db', function() use ($db_config) {
		return new \Phalcon\Db\Adapter\Pdo\Mysql($db_config);
	});

	$result = $di->get('db')->query("SELECT TABLE_NAME FROM TABLES WHERE TABLE_SCHEMA = '" . search_database . "'");

	$data = $result->fetchAll();

	if ($data) {
		echo "\n  Note: 已存在的模型文件, 将不会覆盖并提示Error, 忽略此提示, 等待执行.\n";

		$backslash = "\\";
		foreach ($data as $v) {
			// 这里和直接在终端执行命令不一样, 要加三行反斜线.
			$cmd = "phalcon model --name=". $v['TABLE_NAME'] ." --namespace=\Ucenter\\\Frontend\\\Models --directory=/home/www/Ucenter --output=apps/frontend/models";

			// echo die($cmd);

			shell_exec($cmd);
		}

		echo "\n  Complete!\n";
	}

} catch (\Exception $e) {
	echo $e->getMessage(), PHP_EOL;
}
