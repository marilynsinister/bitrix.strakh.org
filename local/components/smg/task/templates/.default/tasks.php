<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<? $APPLICATION->IncludeComponent(
	"smg:task.list",
	"",
	Array(
		"HIBLOCK_ID"        => $arParams['HIBLOCK_ID'],
		"DATE_FORMAT"       => $arParams['DATE_FORMAT'],
		"PAGE_COUNT"        => $arParams['PAGE_COUNT'],
		"PAGE_SHOW_ALL"     => $arParams['PAGE_SHOW_ALL'],
		"SORT_BY1"          => $arParams['SORT_BY1'],
		"SORT_ORDER1"       => $arParams['SORT_ORDER1'],
		"CACHE_TIME"        => $arParams['CACHE_TIME'],
		"NEW_URL" 			=> $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["new"],
		"EDIT_URL" 			=> $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["edit"],

	),
	$component
);?>
