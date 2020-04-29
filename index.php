<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $APPLICATION;

$APPLICATION->SetPageProperty("title", "Менеджер задач");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Менеджер задач");
?>


	<? $APPLICATION->IncludeComponent(
		"smg:task.list",
		"",
		Array(
			"HIBLOCK_ID"        => '1',
			"DATE_FORMAT"       => 'd.m.Y H:i',
			"PAGE_COUNT"        => 3,
			"PAGE_SHOW_ALL"     => false,
			"SEF_MODE"          => "Y",
			"SORT_BY1"          => $_REQUEST['sort'],
			"SORT_ORDER1"       => $_REQUEST['order'],
			"CACHE_TIME"        => 3600,
		),
		false
	);?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>