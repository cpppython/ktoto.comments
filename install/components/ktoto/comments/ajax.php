<?
/**
 * Created by Kto-to-eshe - 2023
 * @ Offers for full-time work: magicnotepad@yandex.ru
 * @ Technical support for the module, other questions: magicnotepad@gmail.com
 * @ https://www.1c-bitrix.ru/partners/18365340.php
 * @ https://kwork.ru/user/kto-to-eshe
 */

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

$succeessEcho = GetMessage("KTOTO_COMMENT_SOON");
$succeessEchoAdmAdd = GetMessage("KTOTO_COMMENT_BUBL");
$succeessEchoAdmDel = GetMessage("KTOTO_COMMENT_DEL");

function clearVar($var) {
    return htmlspecialchars(strip_tags($var));
}

if (isset($_POST)) {

    if (isset($_POST["formID"]) && !empty($_POST["formID"]) && $_POST["formID"] == "1" && $_POST["isadmin"] != "true") {

        $name;
        $message;
        $BASE_IBlock = clearVar($_POST["IBLOCK_ID_BASE"]);
        $toThisElement = clearVar($_POST["ELEMENT_ID"]);
        $MAIL_ADMIN = clearVar($_POST["MAIL_ADMIN"]);
        $toThisPageUrl = clearVar($_POST["PAGE_URL"]);
    
        if (empty($_POST["email"])) {
            
            if (isset($_POST["msg"])) {
                
                if (strpos($_POST["msg"], "http") || strpos($_POST["msg"], "www")) { 
                    echo $succeessEcho; 
                    die(); 
                }
                else 
                {
                    $message = clearVar($_POST["msg"]);
                }
            }
            else 
            {
                die();
            }

            if (isset($_POST["name"])) {
                $name = clearVar($_POST["name"]);
            }
            else 
            {
                $name = "Гость";
            }
        }
        else 
        {
            die();
        }

        $prop["NAME"] = $name;
        $prop["MESSAGE"] = $message;
        $prop["TO_THIS_ELEMENT_ID"] = $toThisElement;
        $prop["TO_THIS_PAGE_URL"] = $toThisPageUrl;

        $arFields = [
            "NAME" => GetMessage("KTOTO_COMMENT_FROM") ."" . date("d-m-Y G:i:s"),
            "IBLOCK_ID" => $BASE_IBlock,
            "ACTIVE" => "N",
            "PROPERTY_VALUES" => $prop
        ];

        $obElement = new CIBlockElement();
        $intProductID = $obElement->Add($arFields);

        echo $succeessEcho;

        $to = "".$MAIL_ADMIN."";

        $headers = "From: no-reply@".$_SERVER["SERVER_NAME"]."\r\n" .
            "Reply-To: no-reply@".$_SERVER["SERVER_NAME"]."\r\n" .
            "X-Mailer: PHP/" . phpversion();

        $subject = GetMessage("KTOTO_COMMENT_NEW_ON_SITE")."".$_SERVER["SERVER_NAME"];
        $message = GetMessage("KTOTO_COMMENT_FOR_PAGE")."http://{$_SERVER["SERVER_NAME"]}{$toThisPageUrl}\n\n".GetMessage("KTOTO_COMMENT_M").":\n\n {$message}";

        mail($to, $subject, $message, $headers);

    }

    if (isset($_POST["formID"]) && !empty($_POST["formID"]) && $_POST["formID"] == "2") {
        
        $ELEMENT_ID = clearVar($_POST["elementid"]);
        $NEW_TIME_TEMP = clearVar(str_replace("T", " ", $_POST["newtime"]));
        $NEW_TIME = date("d.m.Y G:i:s", strtotime($NEW_TIME_TEMP));

        if ($_POST["add"] == "1") {

            $el = new CIBlockElement;
            $el->Update(
            $ELEMENT_ID, 
            [ "DATE_ACTIVE_FROM" => $NEW_TIME, "ACTIVE" => "Y" ],
            true
            );

            echo $succeessEchoAdmAdd;
        }

        if ($_POST["delete"] == "1") {

            CIBlockElement::Delete($ELEMENT_ID);

            echo $succeessEchoAdmDel;
        }
    }
}

?>
