<?
/**
 * Created by Kto-to-eshe - 2023
 * @ Offers for full-time work: magicnotepad@yandex.ru
 * @ Technical support for the module, other questions: magicnotepad@gmail.com
 * @ https://www.1c-bitrix.ru/partners/18365340.php
 * @ https://kwork.ru/user/kto-to-eshe
 */

namespace Ktoto\Comments;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Loader::includeModule("main");
Loader::includeModule("iblock");

class IBTable
{

   public static function getIBType() 
   {
      return "ktoto_ib_type";
   }

   public static function getIBCode() 
   {
      return "ktoto_comments";
   }

   public static function getIBId() 
   {

      if ($iblockId = \Bitrix\Iblock\IblockTable::getList(["filter" => ["CODE" => self::getIBCode() ]])->Fetch()["ID"]) {
         return $iblockId;
      } else {
         return false;
      }
   }

   public static function createDbTable () 
   {
      $arFields = [
         "ID"=> self::getIBType(),
         "SECTIONS" => "Y",
         "IN_RSS" => "N",
         "SORT" => 100,
         "LANG" => [
            "ru" => [
               "NAME" => GetMessage("KTOTO_COMMENT_IB_TYPE_NAME"),
               "SECTION_NAME" => GetMessage("KTOTO_COMMENT_IB_TYPE_SECTION_NAME"),
               "ELEMENT_NAME" => GetMessage("KTOTO_COMMENT_IB_TYPE_ELEMENT_NAME")
            ]
         ]
      ];
      $obBlocktype = new \CIBlockType;

      $res = $obBlocktype->Add($arFields);

      if (self::getIBId() === false) {

         $ib = new \CIBlock;
         $arFields = [
            "ACTIVE" => "Y",
            "NAME" => GetMessage("KTOTO_COMMENT_IB_NAME"),
            "CODE" => self::getIBCode(),
            "IBLOCK_TYPE_ID" => self::getIBType() ,
            "SITE_ID" => [Site::getSiteID()],
            "SORT" => "20",
            "GROUP_ID" => ["2"=>"R"]
         ];

         $IBLOCK_ID = $ib->Add($arFields);

         $arFields = [
            [
               "NAME" => GetMessage("KTOTO_COMMENT_IB_FIELDS_NAME_NAME"),
               "ACTIVE" => "Y",
               "SORT" => "100",
               "CODE" => "NAME",
               "PROPERTY_TYPE" => "S",
               "USER_TYPE" => "", 
               "IBLOCK_ID" => $IBLOCK_ID,
            ], 
            [
               "NAME" => GetMessage("KTOTO_COMMENT_IB_FIELDS_NAME_ID"),
               "ACTIVE" => "Y",
               "SORT" => "200",
               "CODE" => "PROFILE_ID",
               "PROPERTY_TYPE" => "N",
               "USER_TYPE" => "", 
               "IBLOCK_ID" => $IBLOCK_ID,
            ], 

            [
               "NAME" => GetMessage("KTOTO_COMMENT_IB_FIELDS_NAME_COMMENT"),
               "ACTIVE" => "Y",
               "SORT" => "300",
               "CODE" => "MESSAGE",
               "PROPERTY_TYPE" => "S",
               "USER_TYPE" => "HTML", 
               "IBLOCK_ID" => $IBLOCK_ID,
            ], 

            [
               "NAME" => GetMessage("KTOTO_COMMENT_IB_FIELDS_NAME_ELEMENT_ID"),
               "ACTIVE" => "Y",
               "SORT" => "400",
               "CODE" => "TO_THIS_ELEMENT_ID",
               "PROPERTY_TYPE" => "N",
               "USER_TYPE" => "", 
               "IBLOCK_ID" => $IBLOCK_ID,
            ], 
            [
               "NAME" => GetMessage("KTOTO_COMMENT_IB_FIELDS_NAME_LINK"),
               "ACTIVE" => "Y",
               "SORT" => "500",
               "CODE" => "TO_THIS_PAGE_URL",
               "PROPERTY_TYPE" => "S",
               "USER_TYPE" => "", 
               "IBLOCK_ID" => $IBLOCK_ID,
            ], 

         ];

         $ibp = new \CIBlockProperty;
         foreach ($arFields as $arField) {
            $PropID = $ibp->Add($arField);
         }
      }
   }

   public static function deleteDbTable () {

      if(!\CIBlock::Delete( self::getIBId() ))
      {
         $strWarning .= GetMessage("IBLOCK_DELETE_ERROR");
      }

      if(!\CIBlockType::Delete(self::getIBCode()))
      {
         echo "Delete error!";
      }
   }
}

?>
