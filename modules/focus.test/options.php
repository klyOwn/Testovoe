<?
/** @global CMain $APPLICATION */

use Bitrix\Main\Loader,
	Bitrix\Main\ModuleManager,
	Bitrix\Main\HttpApplication,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Config\Option,
	Bitrix\Main;

$module_id = 'focus.test';

Loader::includeModule($module_id);
Loc::loadMessages(__FILE__);

$request = HttpApplication::getInstance()->getContext()->getRequest();

$aTabs = array(
	array(
		"DIV" 	  => "edit1",
		"TAB" 	  => Loc::getMessage("FALBAR_TOTOP_OPTIONS_TAB_NAME"),
		"TITLE"   => Loc::getMessage("FALBAR_TOTOP_OPTIONS_TAB_NAME"),
		"OPTIONS" => array(
			Loc::getMessage("FALBAR_TOTOP_OPTIONS_TAB_COMMON"),
			array(
				"switch_on",
				Loc::getMessage("FALBAR_TOTOP_OPTIONS_TAB_SWITCH_ON"),
				"",
				array("checkbox")
			),
		)
	)
);

if($request->isPost() && check_bitrix_sessid()) {

	foreach($aTabs as $aTab) {

		foreach($aTab["OPTIONS"] as $arOption) {

			if(!is_array($arOption)) {
				continue;
			}

			if($arOption["note"])
			{
				continue;
			}

			$optionName = $arOption[0];
			$optionValue = $request->getPost($optionName);

			Option::set($module_id, $optionName, is_array($optionValue) ? implode(",", $optionValue):$optionValue);
		}
	}
}

$tabControl = new CAdminTabControl(
	"tabControl",
	$aTabs
);

$tabControl->Begin();
?>

<form method="POST" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($mid)?>&amp;lang=<?echo LANG?>">
<?=bitrix_sessid_post();?>
<? foreach($aTabs as $aTab) {

		if($aTab["OPTIONS"]) {

			$tabControl->BeginNextTab();

			__AdmSettingsDrawList($module_id, $aTab["OPTIONS"]);
		}
	}

	$tabControl->Buttons();
	?>

	<input type="submit" name="apply" value="<? echo(Loc::GetMessage("FALBAR_TOTOP_OPTIONS_INPUT_APPLY")); ?>" class="adm-btn-save" />
	<input type="submit" name="default" value="<? echo(Loc::GetMessage("FALBAR_TOTOP_OPTIONS_INPUT_DEFAULT")); ?>" />

</form>
<? $tabControl->End();