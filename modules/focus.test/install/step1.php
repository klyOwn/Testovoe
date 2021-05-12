<?php
use \Bitrix\Main\Localization\Loc,
	\Bitrix\Main;

if(!check_bitrix_sessid()) 
	return;

if($ex = $APPLICATION->GetException())
{
	echo CAdminMessage::ShowMessage(array(
        "MESSAGE" => Loc::GetMessage("ERROR"),
        "DETAILS" => $ex->GetString(),
        "HTML"    => true,
        "TYPE"    => "ERROR",
     ));
}
else
{
	echo CAdminMessage::ShowNote(Loc::GetMessage("SUCCESS"));
}

	Loc::loadMessages(__FILE__);
?>
	<form action="<?=$APPLICATION->GetCurPage()?>">
		<input type="hidden" name="lang" value="<?=LANGUAGE_ID; ?>">
		<input type="submit" name="" value="<?=Loc::GetMessage("MOD_BACK")?>">
	<form>