<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $APPLICATION;

$APPLICATION->SetPageProperty("title", "Редактировать задачу");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Добавить новую задачу");
?>


<? $APPLICATION->IncludeComponent(
	"smg:task.edit",
	"",
	Array(
		"HIBLOCK_ID"        => '1',
		"ELEMENT_ID"		=> $_REQUEST['id'],
		"DATE_FORMAT"       => 'd.m.Y H:i',

	),
	false
);?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>