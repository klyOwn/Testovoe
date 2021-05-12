<?php
use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses(
	'focus.test',
	array(
		'Log\Lib\LogTable' => 'lib/log.php',
	)
);
?>