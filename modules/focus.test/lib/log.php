<?php
/**
 * Bitrix Framework
 * @package test
 * @subpackage test
 */
namespace Log\Lib;

use Bitrix\Main;
use Bitrix\Main\ORM;

class LogTable extends ORM\Data\DataManager
{
	/**
	 * Returns File path.
	 *
	 * @return string
	 */
	public static function getFilePath()
	{
		return __FILE__;
	}

	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_log';
	}

	/**
	 * Returns DB connection name.
	 *
	 * @return string
	 */
	public static function getConnectionName()
	{
		return 'default';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return array(
			'ID' => new ORM\Fields\IntegerField('ID', array(
				'primary' => true,
				'autocomplete' => true,
			)),
			'TIMECREATE' => new ORM\Fields\DatetimeField('TIMECREATE', array(
				'default_value' => function()
					{
						return new Main\Type\DateTime();
					}
			)),
			'IP' => new ORM\Fields\StringField('IP', array(
				'required' => true,
			)),
			'AGENT' => new ORM\Fields\StringField('AGENT', array(
				'required' => true,
			)),
			'URL' => new ORM\Fields\StringField('URL', array(
				'required' => true,
			)),
			'USER_ID' => new ORM\Fields\IntegerField('USER_ID', array(
			
			)),
		);
	}
}