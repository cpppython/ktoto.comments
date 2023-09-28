<?
/**
 * Created by Kto-to-eshe - 2023
 * @ Offers for full-time work: magicnotepad@yandex.ru
 * @ Technical support for the module, other questions: magicnotepad@gmail.com
 * @ https://www.1c-bitrix.ru/partners/18365340.php
 * @ https://kwork.ru/user/kto-to-eshe
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $LastModifiedDate;
$randTime = substr($arParams["DATE_START"], 0, 14);
$arParams["DATE_START"] = $randTime."".rand(10, 60).":".rand(10, 60)."";

$arParams["DATE_INTERVAL"] = 0; 
$datePlus = date('Y-m-d+h:i:s', strtotime("+".$arParams["DATE_INTERVAL"]." hours", strtotime($arParams["DATE_START"])));
$datePlusMin = date('Y-m-d+h:i:s', strtotime("-0 day", strtotime($arParams["DATE_START"])));
$datePlusMax = date('Y-m-d+h:i:s', strtotime("+7 day", strtotime($arParams["DATE_START"])));
$arResult["DATE_START_NEW"] = str_replace("+", "T", $datePlus);
$arResult["DATE_START_MIN"] = str_replace("+", "T", $datePlusMin);
$arResult["DATE_START_MAX"] = str_replace("+", "T", $datePlusMax);

$arSelect = [
    "ID", 
    "NAME", 
    "ACTIVE", 
    "DATE_CREATE", 
    "DATE_ACTIVE_FROM", 
    "PROPERTY_NAME",
    "PROPERTY_PROFILE_ID",
    "PROPERTY_MESSAGE",
    "PROPERTY_TO_THIS_IBLOCK",
    "PROPERTY_TO_THIS_ELEMENT_ID"
];
$arFilter = ["IBLOCK_ID" => IntVal($arParams["IBLOCK_ID_BASE"]), "PROPERTY_TO_THIS_IBLOCK" => $arParams["IBLOCK_ID"], "PROPERTY_TO_THIS_ELEMENT_ID" => $arParams["ELEMENT_ID"]];
$res = CIBlockElement::GetList(["DATE_ACTIVE_FROM" => "ASC"], $arFilter, false, [], $arSelect);
while ($ob = $res->GetNextElement())
{
$arFields = $ob->GetFields();
    $arResultTemp[] = $arFields;

    if (strtotime($arFields["DATE_ACTIVE_FROM"]) < strtotime(date("d.m.Y H:i:s")) && $arFields["ACTIVE"] == "Y") {
        $lastActive = $arFields["DATE_ACTIVE_FROM"];

    }
}
$arResult["ITEMS"] = $arResultTemp;
$arResult["LAST_COMMENT_DATE_ACTIVE"] = $lastActive;

if ($arParams["MODIFIED_DATE"] == "Y") { 

    if ($arResult["LAST_COMMENT_DATE_ACTIVE"]) {

        $lastDate = $arResult["LAST_COMMENT_DATE_ACTIVE"];

    }
    else 
    {
        if ($arParams["MODIFIED_DATE_ARTICLE"] == "Y") {
            $res = CIBlockElement::GetByID($arParams["ELEMENT_ID"]);
            if ($ar_res = $res->GetNext()) {
                $lastDate = $ar_res["TIMESTAMP_X"];
            }
        }
    }

    if ($lastDate) {

        $_SESSION["LastModifiedDate"] = $lastDate;
        $LastModified = gmdate("D, d M Y H:i:s \G\M\T", strtotime($lastDate));
        $IfModifiedSince = false;
        if (isset($_ENV["HTTP_IF_MODIFIED_SINCE"]))
            $IfModifiedSince = strtotime(substr($_ENV["HTTP_IF_MODIFIED_SINCE"], 5)); 
        if (isset($_SERVER["HTTP_IF_MODIFIED_SINCE"]))
            $IfModifiedSince = strtotime(substr($_SERVER["HTTP_IF_MODIFIED_SINCE"], 5));
        if ($IfModifiedSince && $IfModifiedSince >= $LastModified_unix) {
            header($_SERVER["SERVER_PROTOCOL"] . " 304 Not Modified");
            exit;
        }
        header("Last-Modified: ". $LastModified);
    }
}

$this->IncludeComponentTemplate();

?>
