<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $APPLICATION;

$APPLICATION->SetPageProperty("title", "Редактировать задачу");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Редактировать задачу");
?>


<? $APPLICATION->IncludeComponent(
	"smg:task.edit",
	"",
	Array(
		"HIBLOCK_ID"        => $arParams['HIBLOCK_ID'],
		"ELEMENT_ID"		=> $arResult["VARIABLES"]["id"],
		"DATE_FORMAT"       => $arParams['DATE_FORMAT'],

	),
	$component
);?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>