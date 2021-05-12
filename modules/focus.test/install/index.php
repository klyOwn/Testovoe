<?php
/**
 * Bitrix Framework
 * @package test
 * @subpackage test
 * @copyright 2019 Vladimir
 */

use Bitrix\Main,
	Bitrix\Main\Application,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\ModuleManager,
	Bitrix\Main\EventManager,
	Bitrix\Main\Localization\LanguageTable;

Loc::loadMessages(__FILE__);

class focus_test extends CModule
{
	var $MODULE_ID = "focus.test";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;

	function __construct()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		$this->MODULE_VERSION = $arModuleVersion['VERSION'];
		$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];

		$this->MODULE_NAME = Loc::getMessage("MODULE_NAME");
		$this->MODULE_DESCRIPTION = Loc::getMessage("DESCRIPTION");
	}

	public function isVersionD7()
	{
		return CheckVersion(ModuleManager::getVersion('main'), '14.00.00');
	}

	public function getPath($notRoot=false)
	{
		if($notRoot)
		{
			return str_replace(Application::getDocumentRoot(), '', dirname(__DIR__));
		}
		else
		{
			return dirname(__DIR__);
		}
	}

	function DoInstall()
	{
		global $APPLICATION;

		if($this->isVersionD7())
		{
			ModuleManager::registerModule($this->MODULE_ID);

			$this->InstallDB();
			$this->InstallFiles();
			$this->InstallEvents();
		}
		else
		{
			$APPLICATION->ThrowException(Loc::getMessage("D7ERROR"));
		}

		$APPLICATION->IncludeAdminFile(Loc::getMessage("INSTALL"), $this->getPath()."/install/step1.php");
	}

	function DoUninstall()
    {
        global $APPLICATION;

        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();

        if($request['step'] < 2)
        {
        	$APPLICATION->IncludeAdminFile(Loc::getMessage("UNINSTALL"), $this->getPath()."/install/unstep1.php");
    	}
    	elseif($request['step'] == 2)
    	{
    		ModuleManager::unRegisterModule($this->MODULE_ID);

    		if(!$request['savedata'])
    			$this->UnInstallDB();

    		$this->UnInstallFiles();
    		$this->UnInstallEvents();

    		$APPLICATION->IncludeAdminFile(Loc::getMessage("UNINSTALL"), $this->getPath()."/install/unstep2.php");
    	}
    }

    function InstallDB()
	{
		global $DB;

		if(!$DB->query("SELECT 'x' FROM b_log", true))
		{
			$errors = $DB->RunSQLBatch($this->getPath()."/install/db/".strtolower($DB->type)."/install.sql");
		}

		if(!empty($errors))
		{
			$APPLICATION->ThrowException(implode('. ', $errors));
			return false;
		}

		return true;
	}

	function UnInstallDB()
	{
		global $DB;

		if (!isset($arParams["savedata"]) || $arParams["savedata"] != "Y")
		{
			$errors = $DB->RunSQLBatch($this->getPath()."/install/db/".strtolower($DB->type)."/uninstall.sql");
		}

		if(!empty($errors))
		{
			$APPLICATION->ThrowException(implode('. ', $errors));
			return false;
		}

		return true;
	}

    function InstallFiles()
    {

    }

    function UnInstallFiles()
    {

    }

    function InstallEvents()
    {
    
    }

    function UnInstallEvents()
    {

    }

    function GetModuleTasks()
	{
		
	}
}