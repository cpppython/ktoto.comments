<?
/**
 * Created by Kto-to-eshe - 2023
 * @ Offers for full-time work: magicnotepad@yandex.ru
 * @ Technical support for the module, other questions: magicnotepad@gmail.com
 * @ https://www.1c-bitrix.ru/partners/18365340.php
 * @ https://kwork.ru/user/kto-to-eshe
 */

namespace Ktoto\Comments; 

use Bitrix\Main\SiteTable;

class Site
{

	public static function getSiteId() {
		$rsSites = SiteTable::getList(
            [
                "filter" => [
					"=SERVER_NAME" => $_SERVER["SERVER_NAME"],
                    "=LANGUAGE_ID" => SITE_ID
                ]
            ]
        );

        if ($arSite = $rsSites->fetch()) {
            return $arSite["LID"];
        }
	}
}

?>
