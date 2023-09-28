<?
/**
 * Created by Kto-to-eshe - 2023
 * @ Offers for full-time work: magicnotepad@yandex.ru
 * @ Technical support for the module, other questions: magicnotepad@gmail.com
 * @ https://www.1c-bitrix.ru/partners/18365340.php
 * @ https://kwork.ru/user/kto-to-eshe
 */

\Bitrix\Main\Loader::registerAutoLoadClasses("ktoto.comments", [
	"Ktoto\Comments\IBTable" 	=>	"lib/ibtable.php",
    "Ktoto\Comments\Site" 	=>	"lib/site.php"
]);

?>
