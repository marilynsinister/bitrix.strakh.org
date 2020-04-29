<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $APPLICATION;

$APPLICATION->SetPageProperty("title", "Добавить новую задачу");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Добавить новую задачу");
?>


<? $APPLICATION->IncludeComponent(
	"smg:task.new",
	"",
	Array(
		"IBLOCK_TYPE"       => 'content',
		"IBLOCK_ID"         => '2',

	),
	false
);?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>