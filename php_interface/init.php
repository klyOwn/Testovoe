<?php
use Bitrix\Main\EventManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Log\Lib\LogTable;

EventManager::getInstance()->addEventHandler("main", "OnProlog", array('Logick', 'init'));

class Logick
{
	function init()
	{
		$size = Option::get("focus.test", "switch_on");

		if(!empty($size) && $size == 'Y') {
			self::log();
		}
	}

	function Log()
	{
		global $USER, $DB, $APPLICATION;
		
		if(Loader::includeModule('focus.test')) {

			$isAdmin = \Bitrix\Main\Context::getCurrent()->getRequest();
			$isAjax = Application::getInstance()->getContext()->getRequest();

			try {
				if(empty($isAdmin->isAdminSection()) && !$isAjax->isAjaxRequest()) {
					LogTable::add(array(
						'TIMESTAMP' => $DB->ForSql(self::getDate()),
						'IP'        => $DB->ForSql(self::getIP()),
						'AGENT'     => $DB->ForSql(self::getUserAgent()),
						'URl'       => $DB->ForSql(self::getUrl()),
						'USER_ID'   => $USER->IsAuthorized() ? $USER->GetID() : 0
					));


				}
			}
			catch(Exception $exception) {
				//echo $exception->getMessage();
			}
			
		}
	}

	function getUrl()
	{
        global $APPLICATION;
        $protocol = ($APPLICATION->IsHTTPS()) ? "https://" : "http://";
        $uri = $protocol.$_SERVER['HTTP_HOST'].$APPLICATION->GetCurUri();

        return $uri;
	}

	function getUserAgent()
	{
		return $_SERVER['HTTP_USER_AGENT'];
	}

	function getIP()
    {
        foreach (array('HTTP_CLIENT_IP',
                     'HTTP_X_FORWARDED_FOR',
                     'HTTP_X_FORWARDED',
                     'HTTP_X_CLUSTER_CLIENT_IP',
                     'HTTP_FORWARDED_FOR',
                     'HTTP_FORWARDED',
                     'REMOTE_ADDR') as $key)
        {
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $IPaddress){
                    $IPaddress = trim($IPaddress);

                    if (filter_var($IPaddress, FILTER_VALIDATE_IP) !== false) {
                        return $IPaddress;
                    }
                }
            }
        }
    }

    function getDate()
	{
		$date = new DateTime();
		$date = $date->format('Y-m-d H:i:s');
		return new Bitrix\Main\Type\DateTime($date, 'Y-m-d H:i:s');
	}
}