<?
/**
 * Created by Kto-to-eshe - 2023
 * @ Offers for full-time work: magicnotepad@yandex.ru
 * @ Technical support for the module, other questions: magicnotepad@gmail.com
 * @ https://www.1c-bitrix.ru/partners/18365340.php
 * @ https://kwork.ru/user/kto-to-eshe
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); 

/**
 * @var string $componentPath
 * @var string $componentName
 * @var array $arCurrentValues
 * */
 
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Ktoto\Comments\IBTable;

Loader::includeModule("ktoto.comments");

if ( !Loader::includeModule("iblock") ) {
    throw new \Exception(GetMessage("KTOTO_ERROR_MODUL"));
}

$arIBlockType = CIBlockParameters::GetIBlockTypes(["-" => " "]);

$arIBlocks = [];
$iblockFilter = !empty($arCurrentValues["IBLOCK_TYPE"])
    ? ["TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE" => "Y"]
    : ["ACTIVE" => "Y"];

$rsIBlock = CIBlock::GetList(["SORT" => "ASC"], $iblockFilter);
while ($arr = $rsIBlock->Fetch()) {
    $arIBlocks[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}
unset($arr, $rsIBlock, $iblockFilter);

$arComponentParameters = [
    "GROUPS" => [
        "TO_THIS"    =>  [
            "NAME"  =>  GetMessage("KTOTO_GROUPS_TO_THIS_NAME"),
            "SORT"  =>  "200",
        ],
        "DATE"    =>  [
            "NAME"  =>  GetMessage("KTOTO_GROUPS_DATE_NAME"),
            "SORT"  =>  "200",
        ],
        "WORDS"    =>  [
            "NAME"  =>  GetMessage("KTOTO_GROUPS_WORDS_NAME"),
            "SORT"  =>  "300",
        ],
        "MODIFIED"    =>  [
            "NAME"  =>  GetMessage("KTOTO_GROUPS_MODIFIED_NAME"),
            "SORT"  =>  "400",
        ],
        "ADMIN_EMEIL_GROUP"    =>  [
            "NAME"  =>  GetMessage("KTOTO_ADMIN_EMEIL_GROUP_NAME"),
            "SORT"  =>  "500",
        ],
    ],
    "PARAMETERS" => [
        "IBLOCK_ID_BASE" => [
			"PARENT" 			=> "BASE",
            "NAME"              =>  GetMessage("KTOTO_IBLOCK_ID_BASE_NAME"),
            "TYPE"              =>  "STRING",
            "ADDITIONAL_VALUES" => "Y", 
            "MULTIPLE"          => "N",
            "DEFAULT"           => IBTable::getIBId()
		],
        "IBLOCK_ID_NO_PUBLIC_BASE" => [
			"PARENT" 			=> "BASE",
            "NAME"              =>  GetMessage("KTOTO_IBLOCK_ID_NO_PUBLIC_BASE_NAME"),
            "TYPE"              =>  "STRING",
            "ADDITIONAL_VALUES" => "Y", 
            "MULTIPLE"          => "N",
            "DEFAULT"           =>  ""
		],
        "IBLOCK_ID_DB_USERS_BASE" => [
			"PARENT" 			=> "BASE",
            "NAME"              =>  GetMessage("KTOTO_IBLOCK_ID_DB_USERS_NAME"),
            "TYPE"              =>  "STRING",
            "ADDITIONAL_VALUES" => "Y", 
            "MULTIPLE"          => "N",
            "DEFAULT"           =>  ""
		],
        "ELEMENT_ID" => [
			"PARENT" 			=> "TO_THIS",
			"NAME" 				=> GetMessage("KTOTO_ELEMENT_ID_NAME"),
			"TYPE" 				=> "STRING",
			"DEFAULT" 			=> '={$arResult["ID"]}',
			"ADDITIONAL_VALUES" => "Y",
            "MULTIPLE"          => "N"
		],
        "DATE_START" => [
            "PARENT"            =>  "DATE",
            "NAME"              =>  GetMessage("KTOTO_DATE_START_NAME"),
            "TYPE"              =>  "STRING",
            "ADDITIONAL_VALUES" => "Y", 
            "MULTIPLE"          => "N",
            "DEFAULT"           =>  date("d.m.Y G:i:s") 
        ],
        "WORDS_MIN" => [
            "PARENT"            =>  "WORDS",
            "NAME"              =>  GetMessage("KTOTO_WORDS_MIN_NAME"),
            "TYPE"              =>  "STRING",
            "ADDITIONAL_VALUES" => "Y", 
            "MULTIPLE"          => "N",
            "DEFAULT"           =>  "150"
        ],
        "WORDS_MAX" => [
            "PARENT"            =>  "WORDS",
            "NAME"              =>  GetMessage("KTOTO_WORDS_MAX_NAME"),
            "TYPE"              =>  "STRING",
            "ADDITIONAL_VALUES" => "Y", 
            "MULTIPLE"          => "N",
            "DEFAULT"           =>  "2000"
        ],
        "MODIFIED_DATE" => [
            "PARENT"            =>  "MODIFIED",
            "NAME"              =>  GetMessage("KTOTO_MODIFIED_DATE_NAME"),
            "TYPE"              =>  "CHECKBOX",
        ],
        "MODIFIED_DATE_ARTICLE" => [
            "PARENT"            =>  "MODIFIED",
            "NAME"              =>  GetMessage("KTOTO_MODIFIED_DATE_ARTICLE_NAME"),
            "TYPE"              =>  "CHECKBOX",
        ],
        "ADMIN_EMEIL" => [
            "PARENT"            =>  "ADMIN_EMEIL_GROUP",
            "NAME"              =>  GetMessage("KTOTO_ADMIN_EMEIL_NAME"),
            "TYPE"              =>  "STRING",
            "ADDITIONAL_VALUES" => "Y", 
            "MULTIPLE"          => "N",
            "DEFAULT"           =>  "email@email.ru"
        ],

    ],
]

?>
