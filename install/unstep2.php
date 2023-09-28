<?
/**
 * Created by Kto-to-eshe - 2023
 * @ Offers for full-time work: magicnotepad@yandex.ru
 * @ Technical support for the module, other questions: magicnotepad@gmail.com
 * @ https://www.1c-bitrix.ru/partners/18365340.php
 * @ https://kwork.ru/user/kto-to-eshe
 */
use \Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()) {
	return;
}

if ($ex = $APPLICATION->GetException()) {
	echo CAdminMessage::ShowMessage([
		"TYPE" => "ERROR",
		"MESSAGE" => Loc::getMessage("MOD_UNINST_ERR"),
		"DETAILS" => $ex->GetString(),
		"HTML" => true,
	]);
}
else 
{
	echo CAdminMessage::ShowNote(Loc::getMessage("MOD_UNINST_OK"));
}

?>

<?=GetMessage("KTOTO_COMMENT_MODULE_ADS")?>

<form action="<?echo $APPLICATION->GetCurPage(); ?>">
	<input type="hidden" name="lang" value="<?echo LANGUAGE_ID?>">
	<input type="submit" name="" value="<?echo Loc::getMessage("MOD_BACK"); ?>">
<form>