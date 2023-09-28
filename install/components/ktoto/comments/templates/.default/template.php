<?
/**
 * Created by Kto-to-eshe - 2023
 * @ Offers for full-time work: magicnotepad@yandex.ru
 * @ Technical support for the module, other questions: magicnotepad@gmail.com
 * @ https://www.1c-bitrix.ru/partners/18365340.php
 * @ https://kwork.ru/user/kto-to-eshe
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<? // params count words ?>
<div class="commentCompParams">
    <div id="iblockIDBASE"><?=$arParams["IBLOCK_ID_BASE"]?></div>
    <div id="iblockID"><?=$arParams["IBLOCK_ID"]?></div>
    <div id="elementID"><?=$arParams["ELEMENT_ID"]?></div>
    <div id="pageURL"><?=$APPLICATION->GetCurPage()?></div>
    <div id="wordsMin"><?=$arParams["WORDS_MIN"]?></div>
    <div id="wordsMax"><?=$arParams["WORDS_MAX"]?></div>
    <div id="postMail"><?=$arParams["ADMIN_EMEIL"]?></div>
    <div id="templateFolder"><?=$componentPath?></div>
</div>

<div class="commentsBlock" id="forCommentOpenAddForm">
    <a href="#commentForm" class="commentLink"><?=GetMessage("KTOTO_COMMENT_CALL_TO_ACTION")?></a>
    <a href="<?=GetMessage("KTOTO_COMMENT_LINK")?>"><img src="<?=$templateFolder."/images/icon.png"?>" width="5px" height="5px"></a>
    <div class="commentsItems" id="commentsItemsPublic">
        <? if ($arResult["ITEMS"]) { ?>
            <? foreach  ($arResult["ITEMS"] as $arItem) { ?>
                <? if ($arItem["ACTIVE"] == "Y" && strtotime($arItem["DATE_ACTIVE_FROM"]) <= strtotime(date("d.m.Y H:i:s"))) { ?>
        <div class="commentItem">
            <div class="commentUserName">
                <? if (isset($arItem["PROPERTY_NAME_VALUE"])) { ?>
                <?=$arItem["PROPERTY_NAME_VALUE"]?>
                <? } else { ?>
                <?=GetMessage("KTOTO_COMMENT_TEXT_GUEST")?>
                <? } ?>
            </div>
            <div class="commentDate"><?=strtolower(FormatDate("d F Y", MakeTimeStamp($arItem["DATE_ACTIVE_FROM"])))?></div>
            <div class="commentText"><?=$arItem["PROPERTY_MESSAGE_VALUE"]["TEXT"]?></div>
        </div>
                <? }
                    else 
                    { if (strtotime($arItem["DATE_ACTIVE_FROM"]) > strtotime(date("d.m.Y H:i:s"))) { ?>
                    <? global $USER; if($USER->isAdmin()) { ?>
        <div class="commentItem commentItemSon">
            <div class="commentUserName">
                <?=GetMessage("KTOTO_COMMENT_WILL_BE_PUB_SOON")?> 
                <? if (isset($arItem["PROPERTY_NAME_VALUE"])) { ?>
                <?=$arItem["PROPERTY_NAME_VALUE"]?>
                <? } else { ?>
                <?=GetMessage("KTOTO_COMMENT_TEXT_GUEST")?>
                <? } ?>
            </div>
            <div class="commentDate"><?=strtolower(FormatDate("d F Y", MakeTimeStamp($arItem["DATE_ACTIVE_FROM"])))?></div>
            <div class="commentText"><?=$arItem["PROPERTY_MESSAGE_VALUE"]["TEXT"]?></div>
        </div>
                    <? }}} ?>
            <? } ?>
        <? } ?>
    </div>
    <div class="commentsItems">
        <? global $USER; if($USER->isAdmin()) { ?>
            <? if ($arResult["ITEMS"]) { ?>
                <? $formIdLocal = 1; ?>
                <? foreach  ($arResult["ITEMS"] as $arItem) { ?>
                    <? if ($arItem["ACTIVE"] == "N") { ?>
        <div class="commentItem commentItemNew" id="commentItemNew-<?=$formIdLocal?>">
            <div class="commentUserName">
                <? if (isset($arItem["PROPERTY_NAME_VALUE"])) { ?>
                <?=$arItem["PROPERTY_NAME_VALUE"]?>
                <? } else { ?>
                <?=GetMessage("KTOTO_COMMENT_TEXT_GUEST")?>
                <? } ?>
            </div>
            <div class="commentDate"><?=strtolower(FormatDate("d F Y", MakeTimeStamp($arItem["DATE_CREATE"])))?></div>
            <div class="commentText"><?=$arItem["PROPERTY_MESSAGE_VALUE"]["TEXT"]?></div>
            <div class="commentPanel">
                <form>
                    <input type="hidden" id="formID" name="formID" value="2">
                    <input type="hidden" id="elementid-<?=$formIdLocal?>" value="<?=$arItem["ID"]?>">
                    <input type="datetime-local" id="meeting-time-<?=$formIdLocal?>"
                    name="meeting-time" value="<?=$arResult["DATE_START_NEW"]?>"
                    min="<?=$arResult["DATE_START_MIN"]?>" max="<?=$arResult["DATE_START_MAX"]?>">
                    <input name="submit" type="submit" class="adminModerCommentsButtonsAdd" value="<?=GetMessage("KTOTO_COMMENT_BUTTON_PUBL")?>" data-formid-local="<?=$formIdLocal?>">
                    <input name="submit" type="submit" class="adminModerCommentsButtonsDel" value="<?=GetMessage("KTOTO_COMMENT_BUTTON_DEL")?>" data-formid-local="<?=$formIdLocal?>">
                </form>
            </div>
        </div>
                    <? } ?>
                <? $formIdLocal++; ?>
                <? } ?>
            <? } ?>
        <? } ?>
    </div>
</div>

<div id="commentForm" class="commentForm">
    <span class="commentTitle"><?=GetMessage("KTOTO_COMMENT_LEAVE")?></span>

    <form action="" method="post">
        <span id="lengthResult"></span><br>
        <input type="hidden" id="formIDUser" name="formIDUser" value="1">
        <textarea class="commentTextarea" id="messms" name="user_message" placeholder="<?=GetMessage("KTOTO_COMMENT_YOUR_COMMENT")?>" required></textarea>
        <input class="commentInput" type="text" id="commentName" name="user_name" maxlength="50" placeholder="<?=GetMessage("KTOTO_COMMENT_YOUR_NAME")?>" required>
        <input class="commentEmail" type="text" id="commentEmail" name="email" maxlength="100" placeholder="<?=GetMessage("KTOTO_COMMENT_YOUR_EMAIL")?>" style="display: none;">
        <input name="submit" type="submit" id="commentSubmit" class="commentBtn btn btn-primary" value="<?=GetMessage("KTOTO_COMMENT_BUTTON_SUB_COMMENT")?>">
    </form>
</div>

<div id="responceOfComment">
</div>
